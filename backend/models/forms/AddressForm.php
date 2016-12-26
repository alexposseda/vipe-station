<?php

    namespace backend\models\forms;

    use yii\base\Model;

    class AddressForm extends Model{
        public $index;
        public $address;
        public $coordinates;
        public $schedule;
        public $phones;
        public $isGeneral;

        public function rules(){
            return [
                [
                    ['address', 'coordinates', 'schedule', 'phones'],
                    'required'
                ],
                [
                    ['isGeneral'], 'boolean'
                ]
            ];
        }

        public function attributeLabels(){
            return [
                'address' => 'Address',
                'coordinates' => 'Coordinates',
                'schedule' => 'Schedule',
                'phones' => 'Phones',
                'isGeneral' => 'General'
            ];
        }

        public function getDataAsArray(){
            return [
                'address' => $this->address,
                'coordinates'  => $this->coordinates,
                'schedule'  => $this->schedule,
                'phones'  => $this->phones,
                'isGeneral'  => $this->isGeneral,
            ];
        }

    }