<?php

    namespace common\models;

    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%related_products}}".
     *
     * @property integer      $id
     * @property integer      $base_product
     * @property integer      $related_product
     * @property integer      $created_at
     * @property integer      $updated_at
     *
     * @property ProductModel $baseProduct
     * @property ProductModel $relatedProduct
     */
    class RelatedProductModel extends ActiveRecord{

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
            return '{{%related_products}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'base_product',
                        'related_product',
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    ['base_product'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => ProductModel::className(),
                    'targetAttribute' => ['base_product' => 'id']
                ],
                [
                    ['related_product'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => ProductModel::className(),
                    'targetAttribute' => ['related_product' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'              => 'ID',
                'base_product'    => 'Base Product',
                'related_product' => 'Related Product',
                'created_at'      => 'Created At',
                'updated_at'      => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getBaseProduct(){
            return $this->hasOne(ProductModel::className(), ['id' => 'base_product']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRelatedProduct(){
            return $this->hasOne(ProductModel::className(), ['id' => 'related_product']);
        }
    }
