<?php

    namespace common\models\forms;

    use yii\base\Model;

    /**
     * @property string name
     */
    class DeliveryAddressForm extends Model{
        public $f_name;
        public $l_name;
        public $city;
        public $address;
        public $phone;
        public $email;

        public function getName(){
            return $this->f_name.' '.$this->l_name;
        }

        public function rules(){
            return [
                [
                    [
                        'f_name',
                        'l_name',
                        'city',
                        'address',
                        'phone',
                    ],
                    'required'
                ],
                [
                    [
                        'f_name',
                        'l_name',
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