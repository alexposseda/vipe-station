<?php

    namespace common\models\forms;

    use yii\base\Model;

    class DeliveryAddressForm extends Model{
        public $firstName;
        public $lastName;
        public $city;
        public $address;
        public $phone;

        public function rules(){
            return [
                [
                    [
                        'firstName',
                        'lastName',
                        'city',
                        'address',
                        'phone'
                    ],
                    'required'
                ],
                [
                    [
                        'firstName',
                        'lastName',
                        'city',
                        'address',
                        'phone'
                    ],
                    'string'
                ]
            ];
        }
    }