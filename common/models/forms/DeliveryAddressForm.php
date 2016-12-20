<?php

    namespace common\models\forms;

    use yii\base\Model;

    class DeliveryAddressForm extends Model{
        public $f_name;
        public $l_name;
        public $city;
        public $address;
        public $phone;
        public $email;

        public function rules(){
            return [
                [
                    [
                        'firstName',
                        'lastName',
                        'city',
                        'address',
                        'phone',
                    ],
                    'required'
                ],
                [
                    [
                        'firstName',
                        'lastName',
                        'city',
                        'address',
                        'phone',
                        'email'
                    ],
                    'string'
                ]
            ];
        }
    }