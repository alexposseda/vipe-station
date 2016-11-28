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
                $shopName = $this->getSetting('shopName');
                $shopName->value = $this->shopName;
                if(!$shopName->save()){
                    throw new \Exception('error save shopName');
                }

                $socialLink = $this->getSetting('socialLink');
                $socialLink->value = json_encode($this->socialLink);
                if(!$socialLink->save()){
                    throw new \Exception('error save socialLink');
                }

                $aboutAs = $this->getSetting('aboutAs');
                $aboutAs->value = $this->aboutAs;
                if(!$aboutAs->save()){
                    throw new \Exception('error save aboutAs');
                }

                $bannerLink = $this->getSetting('bannerLink');
                $bannerLink->value = $this->bannerLink;
                if(!$bannerLink->save()){
                    throw new \Exception('error save bannerLink');
                }

                $bannerText = $this->getSetting('bannerText');
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

        public function __construct(){
            //parent::__construct($config);
            $this->shopName = self::getSetting('shopName')->value;
            $this->socialLink = json_decode(self::getSetting('socialLink')->value)[0]; //todo разбирать массив социалок
            $this->aboutAs = self::getSetting('aboutAs')->value;
            $this->bannerLink = self::getSetting('bannerLink')->value;
            $this->bannerText = self::getSetting('bannerText')->value;
        }

        private static function getSetting($setting){
            $set = ShopSettingTable::find()
                                   ->where(['key' => $setting])
                                   ->one();
            if(!$set){
                $set = new ShopSettingTable();
                $set->key = $setting;
            }

            return $set;
        }
    }