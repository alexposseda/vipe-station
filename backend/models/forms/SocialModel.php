<?php

    namespace backend\models\forms;

    use common\models\ShopSettingTable;
    use yii\base\Model;

    class SocialModel extends SettingForm{
        public $socialForms = [];

        public function init(){
            parent::init();

            $this->socialForms = self::getModels(ShopSettingTable::getSettingValue('social'));
        }

        public function validate($attributeNames = null, $clearErrors = true){
            if(!Model::validateMultiple($this->socialForms)){
                return false;
            }

            return true;
        }

        public function load($data, $formName = null){

            for($i = 0; $i < count($data['SocialItemForm']); $i++){
                if(!isset($this->socialForms[$i])){
                    $this->socialForms[$i] = new SocialItemForm(['index' => $i]);
                }
            }

            if(!Model::loadMultiple($this->socialForms, $data)){
                return false;
            }

            return true;
        }

        public function save(){
            $model = ShopSettingTable::getSetting('social');

            $model->value = json_encode($this->getSocialData());
            $model->save();
        }

        /**
         * Метод для получения моделей
         *
         * @param string $data json строка полученная из таблицы setting
         *
         * @return SocialItemForm[]
         */
        public static function getModels($data){
            $data = (!is_null($data) and !empty($data) and $data !== 'null') ? json_decode($data) : [];
            $models = [];
            foreach($data as $item){
                $models[] = new SocialItemForm($item);
            }

            return $models;
        }

        protected function getSocialData(){
            $data = [];
            foreach($this->socialForms as $index => $social){
                $data[$index] = $social->getDataAsArray();
            }
            return $data;
        }
    }