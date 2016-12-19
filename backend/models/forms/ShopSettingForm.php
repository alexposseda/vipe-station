<?php

    namespace backend\models\forms;

    use common\models\ShopSettingTable;

    class ShopSettingForm extends SettingForm{
        public $shopName;


        public function init(){
            parent::init();

            $this->shopName = ShopSettingTable::getSettingValue('shopName');
            if(is_null($this->shopName)){
                $this->shopName = \Yii::$app->name;
            }
        }

        public function rules(){
            return [
                [
                    'shopName',
                    'required'
                ],
                [
                    [
                        'shopName',
                    ],
                    'string',
                    'max' => 255
                ],
            ];
        }

        public function attributeLabels(){
            return [
                'shopName'    => 'Shop Name'
            ];
        }

        public function save(){
            $model = ShopSettingTable::getSetting('shopName');
            $model->value = $this->shopName;
            if(!$model->save()){
                $this->addErrors($model->getErrors());
            }
        }
    }