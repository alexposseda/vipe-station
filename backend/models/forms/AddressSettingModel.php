<?php

    namespace backend\models\forms;

    use common\models\ShopSettingTable;
    use Yii;
    use yii\base\Model;
    use yii\base\Object;

    class AddressSettingModel extends SettingForm{
        public $models;

        public function init(){
            parent::init();
            $models = self::getModels(ShopSettingTable::getSettingValue('address'));
            if(empty($models)){
                $models[] = new AddressForm(['index' => 0]);
            }
            $this->models = $models;
        }

        public function save(){
            $model = ShopSettingTable::getSetting('social');

            $model->value = json_encode($this->getAddressData());
            return $model->save();
        }

        public function load($data, $formName = null){
            for($i = 0; $i < count($data['AddressForm']); $i++){
                if(!isset($this->models[$i])){
                    $this->models[$i] = new AddressForm(['index' => $i]);
                }
            }

            if(!Model::loadMultiple($this->models, $data)){
                return false;
            }

            if(!Model::validateMultiple($this->models)){
                return false;
            }

            return true;
        }
        protected function getSocialData(){
            $data = [];
            foreach($this->models as $index => $model){
                $data[$index] = $model->getDataAsArray();
            }
            return $data;
        }
    }

