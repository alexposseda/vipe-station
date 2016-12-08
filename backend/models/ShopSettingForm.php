<?php

    namespace backend\models;

    use common\models\ShopSettingTable;

    class ShopSettingForm extends SettingForm{
        public $shopName;
        public $bannerFile;
        public $banner;
        public $bannerTitle;

        public function init(){
            parent::init();

            $this->shopName = ShopSettingTable::getSettingValue('shopName');
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
                        'bannerTitle'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    'bannerFile',
                    'file',
                    'skipOnEmpty' => true,
                    'extensions'  => 'png, jpg, gif',
                    'maxSize'     => 1024 * 1024,
                    'maxFiles'    => 1
                ],
            ];
        }

        public function attributeLabels(){
            return [
                'shopName'    => 'Shop Name',
                'bannerFile'  => 'Banner Picture',
                'banner'      => 'Banner Picture',
                'bannerTitle' => 'Banner Title'
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