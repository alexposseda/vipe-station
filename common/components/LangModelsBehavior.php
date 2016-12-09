<?php

    namespace common\components;

    use yii\base\Behavior;

    class LangModelsBehavior extends Behavior{
        public $attributes;

        public function canSave(){
            foreach($this->attributes as $attribute){
                if(!empty($this->owner->{$attribute})){
                    return true;
                }
            }

            return false;
        }
    }