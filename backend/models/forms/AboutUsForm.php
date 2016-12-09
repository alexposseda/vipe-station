<?php

    namespace backend\models\forms;

    use common\models\ShopSettingTable;

    class AboutUsForm extends SettingForm{
        public $about;

        public function init(){
            parent::init();

            $this->about = ShopSettingTable::getSettingValue('aboutUs');
        }

        public function rules(){
            return [
                [
                    'about',
                    'required'
                ],
                [
                    [
                        'about'
                    ],
                    'string'
                ]
            ];
        }

        public function attributeLabels(){
            return [
                'about'  => 'About Us',
            ];
        }

        public function save(){
            // TODO: Implement save() method.
        }
    }