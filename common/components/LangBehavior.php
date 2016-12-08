<?php

    namespace common\components;

    use Yii;
    use yii\base\Behavior;
    use yii\db\ActiveRecord;
    use yii\helpers\ArrayHelper;

    class LangBehavior extends Behavior{
        public $langModels;
        public $langModelName;
        public $relationFieldName;
        public $attributes;

        protected $_availableLangs = [];

        public function init(){
            parent::init();

            $this->_availableLangs = ArrayHelper::map($this->langModels, 'code', 'title');
        }

        public function events(){
            return [
                ActiveRecord::EVENT_AFTER_FIND    => 'findLangs',
                ActiveRecord::EVENT_AFTER_INSERT  => 'insertLangs',
                ActiveRecord::EVENT_BEFORE_UPDATE => 'updateLangs'
            ];
        }

        public function findLangs(){
            if(Yii::$app->sourceLanguage != Yii::$app->language){
                $lang = (new $this->langModelName)->find([
                                                             $this->relationFieldName => $this->owner->id,
                                                             'language'               => Yii::$app->language
                                                         ])
                                                  ->one();
                if($lang){
                    foreach($this->attributes as $attr){
                        $this->owner->$attr = (!empty($lang->$attr)) ? $lang->attr : $this->owner->$attr;
                    }
                }
            }
        }

        public function insertLangs(){
        }

        public function updateLangs(){
        }

        public function deleteLangs(){
        }

        public function getLangs(){
            return $this->owner->hasMany($this->langModelName, [$this->relationFieldName => 'id']);
        }
    }