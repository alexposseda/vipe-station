<?php

    namespace frontend\models;

    use common\models\ShopSettingTable;
    use Yii;
    use yii\base\Model;


    class AddressForm extends Model{
        public $_count;

        public $address;
        public $schedule;
        public $phones;
        public $baseAddress;
        public $centerMap;

        public function attributeLabels(){
            return [
                'address'     => Yii::t('shop/setting', 'Address'),
                'schedule'    => Yii::t('shop/setting', 'schedule'),
                'phones'      => Yii::t('shop/setting', 'phones'),
                'baseAddress' => Yii::t('shop/setting', 'baseAddress'),
            ];
        }

        public function getAllAddress(){
            $address_setting = json_decode(ShopSettingTable::getSetting('address')->value);
            $listAddress = [];
            if(!empty($address_setting)){
                $_count = count($address_setting);
                for($i = 0; $i < $_count; $i++){
                    $listAddress[$i]['address'] = $address_setting[$i]->address;
                    $listAddress[$i]['schedule'] = $address_setting[$i]->schedule;
                    $listAddress[$i]['phones'] = $address_setting[$i]->phones;
                    $listAddress[$i]['baseAddress'] = $address_setting[$i]->baseAddress;
                    $listAddress[$i]['centerMap'] = $address_setting[$i]->centerMap;
                }
            }

            return $listAddress;
        }
    }