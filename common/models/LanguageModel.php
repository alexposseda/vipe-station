<?php

    namespace common\models;

    use common\components\GetAllFromCacheTrait;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%language}}".
     *
     * @property string                           $code
     * @property string                           $title
     * @property integer                          $created_at
     * @property integer                          $updated_at
     *
     * @property CategoryLangModel[]              $categoryLangs
     * @property DeliveryLangModel[]              $deliveryLangs
     * @property PaymentLangModel[]               $paymentLangs
     * @property ProductCharacteristicLangModel[] $productCharacteristicLangs
     * @property ProductLangModel[]               $productLangs
     * @property ProductOptionLangModel[]         $productOptionLangs
     * @property StockLangModel[]                 $stockLangs
     */
    class LanguageModel extends ActiveRecord{
        use GetAllFromCacheTrait;
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%language}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'code',
                        'title'
                    ],
                    'required'
                ],
                [
                    [
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    ['code'],
                    'string',
                    'max' => 4
                ],
                [
                    ['title'],
                    'string',
                    'max' => 20
                ],
                [
                    ['code'],
                    'unique'
                ],
                [
                    ['title'],
                    'unique'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'code'       => 'Code',
                'title'      => 'Title',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategoryLangs(){
            return $this->hasMany(CategoryLangModel::className(), ['language' => 'code']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getDeliveryLangs(){
            return $this->hasMany(DeliveryLangModel::className(), ['language' => 'code']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPaymentLangs(){
            return $this->hasMany(PaymentLangModel::className(), ['language' => 'code']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductCharacteristicLangs(){
            return $this->hasMany(ProductCharacteristicLangModel::className(), ['language' => 'code']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductLangs(){
            return $this->hasMany(ProductLangModel::className(), ['language' => 'code']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductOptionLangs(){
            return $this->hasMany(ProductOptionLangModel::className(), ['language' => 'code']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getStockLangs(){
            return $this->hasMany(StockLangModel::className(), ['language' => 'code']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getBrandLangs(){
            return $this->hasMany(BrandLangModel::className(), ['language' => 'code']);
        }

    }
