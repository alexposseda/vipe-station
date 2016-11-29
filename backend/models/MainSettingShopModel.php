<?php

    namespace backend\models;

    use common\models\ShopSettingTable;
    use Yii;
    use yii\base\Model;

    class MainSettingShopModel extends Model{
        public $shopName;
        public $socialLink;
        public $aboutAs;
        public $bannerLink;
        public $bannerText;

        public function rules(){
            return [
                [
                    [
                        'shopName',
                        'socialLink',
                        'aboutAs',
                        'bannerLink',
                        'bannerText',
                    ],
                    'string'
                ],
            ];
        }

        public function save(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $shopName = ShopSettingTable::getSetting('shopName');
                $shopName->value = $this->shopName;
                if(!$shopName->save()){
                    throw new \Exception('error save shopName');
                }

                $socialLink = ShopSettingTable::getSetting('socialLink');
                $socialLink->value = json_encode($this->socialLink);
                if(!$socialLink->save()){
                    throw new \Exception('error save socialLink');
                }

                $aboutAs = ShopSettingTable::getSetting('aboutAs');
                $aboutAs->value = $this->aboutAs;
                if(!$aboutAs->save()){
                    throw new \Exception('error save aboutAs');
                }

                $bannerLink = ShopSettingTable::getSetting('bannerLink');
                $bannerLink->value = $this->bannerLink;
                if(!$bannerLink->save()){
                    throw new \Exception('error save bannerLink');
                }

                $bannerText = ShopSettingTable::getSetting('bannerText');
                $bannerText->value = $this->bannerText;
                if(!$bannerText->save()){
                    throw  new \Exception('error save bannerText');
                }

                $transaction->commit();

                return true;
            }catch(\Exception $e){
                $transaction->rollBack();

                return false;
            }
        }

        public function init(){
            $this->shopName = ShopSettingTable::getSetting('shopName')->value;
            $this->socialLink = json_decode(ShopSettingTable::getSetting('socialLink')->value)[0]; //todo разбирать массив социалок
            $this->aboutAs = ShopSettingTable::getSetting('aboutAs')->value;
            $this->bannerLink = ShopSettingTable::getSetting('bannerLink')->value;
            $this->bannerText = ShopSettingTable::getSetting('bannerText')->value;
        }

    }