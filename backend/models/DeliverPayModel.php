<?php

    namespace backend\models;

    use common\models\ShopSettingTable;
    use Yii;
    use yii\base\Model;

    class DeliverPayModel extends Model{
        public $logo;
        public $title;
        public $desc;


        public function rules(){
            return [
                [
                    [
                        'logo',
                        'title',
                        'desc'
                    ],
                    'string'
                ],
            ];
        }

        public function attributeLabels(){
            return [
                'logo'  => Yii::t('shop/setting', 'Logo'),
                'title' => Yii::t('shop/setting', 'Title'),
                'desc'  => Yii::t('shop/setting', 'Desc')
            ];
        }

        public function init(){
            $delivery = json_decode(ShopSettingTable::getSetting('delivery_'.Yii::$app->language)->value);
            if(!empty($delivery)){
                $this->logo[0] = $delivery->logo;
                $this->title[0] = $delivery->title;
                $this->desc[0] = $delivery->desc;
            }
            $payment = json_decode(ShopSettingTable::getSetting('payment_'.Yii::$app->language)->value);
            if(!empty($payment)){
                $this->logo[1] = $payment->logo;
                $this->title[1] = $payment->title;
                $this->desc[1] = $payment->desc;
            }
        }

        public function save(){
            $del = ShopSettingTable::getSetting('delivery_'.Yii::$app->language);
            $pay = ShopSettingTable::getSetting('payment_'.Yii::$app->language);
            if($del){
                $delivery = [
                    'logo'  => $this->logo[0],
                    'title' => $this->title[0],
                    'desc'  => $this->desc[0],
                ];
                $del->value = json_encode($delivery);
            }
            if($pay){
                $payment = [
                    'logo'  => $this->logo[1],
                    'title' => $this->title[1],
                    'desc'  => $this->desc[1],
                ];
                $pay->value = json_encode($payment);
            }

            if($pay->save() && $del->save()){
                return true;
            }

            return false;
        }

    }