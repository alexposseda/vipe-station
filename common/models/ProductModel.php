<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\SluggableBehavior;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%product}}".
     *
     * @property integer                          $id
     * @property string                           $title
     * @property string                           $gallery
     * @property string                           $description
     * @property double                           $base_price
     * @property integer                          $base_quantity
     * @property string                           $slug
     * @property integer                          $manufacturer_id
     * @property integer                          $sales
     * @property integer                          $views
     * @property integer                          $seo_id
     * @property integer                          $created_at
     * @property integer                          $updated_at
     *
     * @property OrderDataModel[]                 $orderDatas
     * @property BrandModel                       $brand
     * @property SeoModel                         $seo
     * @property ProductCharacteristicItemModel[] $productCharacteristicItems
     * @property ProductInCategoryModel[]         $productInCategories
     * @property CategoryModel[]                  $categories
     * @property ProductInStockModel[]            $productInStocks
     * @property StockModel[]                     $stocks
     * @property ProductOptionModel[]             $productOptions
     */
    class ProductModel extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                [
                    'class'         => SluggableBehavior::className(),
                    'attribute'     => 'title',
                    'slugAttribute' => 'slug',
                ],
                TimestampBehavior::className(),
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%product}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'title',
                        'description',
                        'slug'
                    ],
                    'required'
                ],
                [
                    [
                        'gallery',
                        'description'
                    ],
                    'string'
                ],
                [
                    ['base_price'],
                    'number'
                ],
                [
                    [
                        'base_quantity',
                        'manufacturer_id',
                        'sales',
                        'views',
                        'seo_id',
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    [
                        'title',
                        'slug'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    ['title'],
                    'unique'
                ],
                [
                    ['slug'],
                    'unique'
                ],
                [
                    ['manufacturer_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => BrandModel::className(),
                    'targetAttribute' => ['manufacturer_id' => 'id']
                ],
                [
                    ['seo_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => SeoModel::className(),
                    'targetAttribute' => ['seo_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'              => 'ID',
                'title'           => 'Title',
                'gallery'         => 'Gallery',
                'description'     => 'Description',
                'base_price'      => 'Base Price',
                'base_quantity'   => 'Base Quantity',
                'slug'            => 'Slug',
                'manufacturer_id' => 'Manufacturer ID',
                'sales'           => 'Sales',
                'views'           => 'Views',
                'seo_id'          => 'Seo ID',
                'created_at'      => 'Created At',
                'updated_at'      => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOrderDatas(){
            return $this->hasMany(OrderDataModel::className(), ['product_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getBrand(){
            return $this->hasOne(BrandModel::className(), ['id' => 'manufacturer_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getSeo(){
            return $this->hasOne(SeoModel::className(), ['id' => 'seo_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductCharacteristicItems(){
            return $this->hasMany(ProductCharacteristicItemModel::className(), ['product_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductInCategories(){
            return $this->hasMany(ProductInCategoryModel::className(), ['product_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategories(){
            return $this->hasMany(CategoryModel::className(), ['id' => 'category_id'])
                        ->viaTable('{{%product_in_category}}', ['product_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductInStocks(){
            return $this->hasMany(ProductInStockModel::className(), ['product_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getStocks(){
            return $this->hasMany(StockModel::className(), ['id' => 'stock_id'])
                        ->viaTable('{{%product_in_stock}}', ['product_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductOptions(){
            return $this->hasMany(ProductOptionModel::className(), ['product_id' => 'id']);
        }
    }
