<?php

    namespace common\components;

    use common\models\BrandLangModel;
    use common\models\LanguageModel;
    use Yii;
    use yii\base\Behavior;
    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;
    use yii\helpers\ArrayHelper;

    /**
     * Class LanguageBehavior
     * @package common\components
     *
     * @property ActiveRecord $owner
     */
    class LanguageBehavior extends Behavior{
        public $langModelName;
        public $relationFieldName;
        public $attributes;
        public $namespace = '\common\models\\';
        //        public    $langs;
        protected $_languages;

        public function init(){
            parent::init();
            $this->_languages = LanguageModel::getAll();
        }

        public function events(){
            return [
                ActiveRecord::EVENT_AFTER_FIND => 'findCurrentLang',
            ];
        }

        public function findCurrentLang(){
            $className = $this->langModelName;
            $langModel = $className::findOne([
                                                 'language'               => Yii::$app->language,
                                                 $this->relationFieldName => $this->owner->primaryKey
                                             ]);
            if(!$langModel){
                return false;
            }
            foreach($this->attributes as $attr){
                if(!empty($langModel->$attr)){
                    $this->owner->$attr = $langModel->$attr;
                }
            }
        }

        public function getAvailableLangs(){
            $availableLangModels = [];
            if($this->owner->isNewRecord){
                foreach($this->_languages as $lang){
                    $availableLangModels[] = new $this->langModelName (['language' => $lang->code]);
                }
            }else{
            }

            return $availableLangModels;
        }

        public function getLangs(){
            $className = $this->langModelName;
            $ownerClass = $this->namespace.$this->owner->formName();
            $owner = $this->owner;
            $relationFieldName = $this->relationFieldName;

            $dependency = new DbDependency([
                                               'sql' => 'SELECT MAX(updated_at) FROM '.$ownerClass::tableName(),
                                           ]);

            return $ownerClass::getDb()
                              ->cache(function() use ($owner, $className, $relationFieldName){
                                  return $owner->hasMany($className, [$relationFieldName => $owner->primaryKey()[0]])
                                               ->all();
                              }, 3600, $dependency);
        }
    }