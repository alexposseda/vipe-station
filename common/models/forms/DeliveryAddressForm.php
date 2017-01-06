<?php

namespace common\models\forms;

use Yii;
use yii\base\Model;

/**
 * @property string name
 */
class DeliveryAddressForm extends Model
{
    public $f_name;
    public $l_name;
    public $city;
    public $address;
    public $phone;
    public $email;

    public function getName()
    {
        return $this->f_name . ' ' . $this->l_name;
    }

    public function rules()
    {
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

    public function attributeLabels()
    {
        return [
            'f_name' => Yii::t('models/client', 'First name'),
            'l_name' => Yii::t('models/client', 'Last name'),
            'city' => Yii::t('models/client', 'City'),
            'address' => Yii::t('models/client', 'Address'),
            'phone' => Yii::t('models/client', 'Phone'),
            'email' => Yii::t('models/client', 'Email')
        ];
    }
}