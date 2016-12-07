<?php

    namespace common\components;

    use common\models\LanguageModel;
    use Yii;
    use yii\base\Behavior;
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

    class LanguageBehavior extends Behavior{
        public $langModelName;
        public $relationFieldName;
        public $attributes;
        public $namespace = '\common\models\\';
        public $t_category;

        public function events(){
            return [
                ActiveRecord::EVENT_AFTER_FIND => 'findCurrentLang',
                ActiveRecord::EVENT_AFTER_INSERT => 'saveLangModels',
            ];
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
         * Метод для получения всех возможных языковых моделей
         *
         * @return ActiveRecord[]
         */
        public function getAvailableLangs(){
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

            return $availableLangModels;
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