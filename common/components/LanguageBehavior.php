<?php

    namespace common\components;

    use common\models\LanguageModel;
    use Exception;
    use Yii;
    use yii\base\Behavior;
    use yii\base\Model;
    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;

    /**
     * Class LanguageBehavior
     *
     * Класс расширяет модели для работы с дополнительными языками
     * Использование:
     *  - Добавить в необходимую (базовую) модель как поведение
     *
     * Настройки:
     *  - 'langModelName'       --- имя языковой модели
     *  - 'relationFieldName'   --- имя связи между языковой и базовой моделями
     *  - 't_category'          --- имя категории, хранящей переводы
     *  - 'attributes'          --- атрибуты базовой модели, которые должны быть переведены
     *
     * @package common\components
     *
     * @property ActiveRecord $owner
     * @property string       $langModelName
     * @property string       $relationFieldName
     * @property string       $namespace    this is owner class namespace
     * @property string       $t_category   translation category
     */
    class   LanguageBehavior extends Behavior{
        public $langModelName;
        public $relationFieldName;
        public $attributes;
        public $namespace = '\common\models\\';
        public $t_category;

        protected $_availableLangModels = null;

        /**
         * Метод для получения всех возможных языковых моделей
         */
        protected function getLangModels(){
            $availableLangModels = [];
            $languages = LanguageModel::getAll();
            if($this->owner->isNewRecord){
                foreach($languages as $lang){
                    $availableLangModels[] = new $this->langModelName (['language' => $lang->code]);
                }
            }else{
                $currentLangModels = $this->getLangs();
                foreach($languages as $lang){
                    foreach($currentLangModels as $langModel){
                        if($langModel->language == $lang->code){
                            $availableLangModels[] = $langModel;
                            continue 2;
                        }
                    }
                    $availableLangModels[] = new $this->langModelName (['language' => $lang->code]);
                }
            }

            $this->_availableLangModels = $availableLangModels;
        }

        public function events(){
            return [
                ActiveRecord::EVENT_AFTER_FIND   => 'findCurrentLang',
                ActiveRecord::EVENT_AFTER_INSERT => 'saveLangModels',
                ActiveRecord::EVENT_AFTER_UPDATE => 'saveLangModels'
            ];
        }

        /**
         * Метод для загрузки и валидации языковых моделей
         *
         * @param ActiveRecord[] $langModels
         *
         * @return bool
         */
        public function loadAndValidate($langModels){
            if(!Model::loadMultiple($langModels, Yii::$app->request->post())){
                return false;
            }
            foreach($langModels as $langModel){
                if($langModel->isNewRecord){
                    $langModel->{$this->relationFieldName} = $this->owner->getPrimaryKey();
                }
            }
            if(!Model::validateMultiple($langModels)){
                return false;
            }

            return true;
        }

        /**
         * метод вызывается при ActiveRecord::EVENT_AFTER_FIND для замены переданных атрибутов
         */
        public function findCurrentLang(){
            $className = $this->langModelName;
            $langModel = $className::findOne([
                                                 'language'               => Yii::$app->language,
                                                 $this->relationFieldName => $this->owner->primaryKey
                                             ]);
            if($langModel){
                foreach($this->attributes as $attr){
                    if(!empty($langModel->$attr)){
                        $this->owner->$attr = $langModel->$attr;
                    }
                }
            }
        }

        /**
         * Метод для сохранения языковых моделей
         *
         * @throws Exception
         */
        public function saveLangModels(){
            try{
                $langModels = $this->getAvailableLangs();
                if($this->loadAndValidate($langModels)){
                    foreach($langModels as $langModel){
                        if($langModel->canSave()){
                            $langModel->save(false);
                        }else if(!$langModel->isNewRecord){
                            $langModel->delete();
                        }
                    }
                }else{
                    throw new Exception(Yii::t('system/error', 'Sorry, I can not save the language data'));
                }
            }catch(Exception $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        /**
         * @return ActiveRecord[]
         */
        public function getAvailableLangs(){
            if(is_null($this->_availableLangModels)){
                $this->getLangModels();
            }

            return $this->_availableLangModels;
        }

        /**
         * Метод добавляет языковую связь в модель
         *
         * @return ActiveRecord[]|null
         */
        public function getLangs(){
            $className = $this->langModelName;
            $ownerClass = $this->namespace.$this->owner->formName();
            $owner = $this->owner;
            $relationFieldName = $this->relationFieldName;

            $dependency = new DbDependency([
                                               'sql' => 'SELECT MAX(updated_at) FROM '.$className::tableName(),
                                           ]);

            return $ownerClass::getDb()
                              ->cache(function() use ($owner, $className, $relationFieldName){
                                  return $owner->hasMany($className, [$relationFieldName => $owner->primaryKey()[0]])
                                               ->all();
                              }, 3600, $dependency);
        }

        /**Метод возвращает категорию перевода
         *
         * @return string
         */
        public function getTcategory(){
            return $this->t_category;
        }
    }