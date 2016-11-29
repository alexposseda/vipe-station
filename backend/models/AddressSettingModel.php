<?php

    namespace backend\models;

    use common\models\ShopSettingTable;
    use Yii;
    use yii\base\Model;

    class AddressSettingModel extends Model{

        public $_count;

        public $address;
        public $schedule;
        public $phones;
        public $baseAddress;
        public $centerMap;

        public function rules(){
            return [
                [
                    [
                        'address',
                        'schedule',
                        'phones',
                        'baseAddress',
                        'centerMap'
                    ],
                    'safe'
                ],
                ['centerMap','default','value'=>Yii::$app->params['mapConfig']['center']]
            ];
        }

        public function attributeLabels(){
            return [
                'address'     => Yii::t('shop/setting', 'Address'),
                'schedule'    => Yii::t('shop/setting', 'schedule'),
                'phones'      => Yii::t('shop/setting', 'phones'),
                'baseAddress' => Yii::t('shop/setting', 'baseAddress'),
            ];
        }

        public function init(){
            $address_setting = ShopSettingTable::getSetting('address');
            $val = json_decode($address_setting->value);
            if(!empty($val)){
                $this->_count = count($val);
                for($i = 0; $i < $this->_count; $i++){
                    $this->address[$i] = $val[$i]->address;
                    $this->schedule[$i] = $val[$i]->schedule;
                    $this->phones[$i] = $val[$i]->phones;
                    $this->baseAddress[$i] = $val[$i]->baseAddress;
                    $this->centerMap[$i] = $val[$i]->centerMap;
                }
            }
        }

        public function save(){
            $address_setting = ShopSettingTable::getSetting('address');

            $this->_count = count($this->address);
            $val = [];
            for($i = 0; $i < $this->_count; $i++){
                $val[$i]['address'] = $this->address[$i];
                $val[$i]['schedule'] = $this->schedule[$i];
                $val[$i]['phones'] = $this->phones[$i];
                $val[$i]['baseAddress'] = $this->baseAddress[$i];
                $val[$i]['centerMap'] = $this->centerMap[$i];
            }
            $address_setting->value = json_encode($val);

            if($address_setting->save()){
                return true;
            }

            return false;
        }
    }

