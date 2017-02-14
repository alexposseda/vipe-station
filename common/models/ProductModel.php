<?php

    namespace common\models;

    use common\components\LanguageBehavior;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\behaviors\SluggableBehavior;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    use yii\helpers\Url;

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
     * @property integer                          $brand_id
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
     *
     * @property string                           $cover
     *
     * @property RelatedProductModel[]            $relatedProducts
     * @property RelatedProductModel[]            $relatedProducts0
     */
    class ProductModel extends ActiveRecord{

	    public function afterDelete() {
		    Yii::$app->cache->flush();
	    }
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
                [
                    'class'             => LanguageBehavior::className(),
                    'langModelName'     => ProductLangModel::className(),
                    'relationFieldName' => 'product_id',
                    't_category'        => 'models/product',
                    'attributes'        => [
                        'title',
                        'description'
                    ],
                ],
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
                        'brand_id',
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
                    ['brand_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => BrandModel::className(),
                    'targetAttribute' => ['brand_id' => 'id']
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
                'id'            => 'ID',
                'title'         => Yii::t('models/product', 'Title'),
                'gallery'       => Yii::t('models/product', 'Gallery'),
                'description'   => Yii::t('models/product', 'Description'),
                'base_price'    => Yii::t('models/product', 'Base Price'),
                'base_quantity' => Yii::t('models/product', 'Base Quantity'),
                'slug'          => Yii::t('models', 'Slug'),
                'brand_id'      => Yii::t('models', 'Brand'),
                'sales'         => Yii::t('models/product', 'Sales'),
                'views'         => Yii::t('models/product', 'Views'),
                'cover'         => 'Cover',
                'seo_id'        => 'Seo ID',
                'created_at'    => 'Created At',
                'updated_at'    => 'Updated At',
            ];
        }

        /**
         * @return array|self[]
         */
        public function rProducts(){
            $tmp = [];
            if($this->isBaseProduct()){
                foreach($this->relatedProducts as $rp){
                    $tmp[] = $rp->relatedProduct;
                }
            }else if($this->isRelatedProduct()){
                $baseP = $this->relatedProducts0[0];
                $tmp[] = $baseP->baseProduct;
                foreach($baseP->baseProduct->relatedProducts as $rp){
                    if($rp->relatedProduct->id == $this->id){
                        continue;
                    }
                    $tmp[] = $rp->relatedProduct;
                }
            }

            return $tmp;
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
            return $this->hasOne(BrandModel::className(), ['id' => 'brand_id']);
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

        public function getCover(){
            $cover = ($this->gallery) ? FileManager::getInstance()
                                                 ->getStorageUrl().json_decode($this->gallery)[0] : '';
            if(empty($cover)){
                $cover = Url::to('/images/noPicture.png', true);
            }

            return $cover;
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRelatedProducts(){
            return $this->hasMany(RelatedProductModel::className(), ['base_product' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getRelatedProducts0(){
            return $this->hasMany(RelatedProductModel::className(), ['related_product' => 'id']);
        }

        /**
         * @param integer $c_id
         *
         * @return ProductCharacteristicItemModel|null
         */
        public function characteristicValue($c_id){
            foreach($this->productCharacteristicItems as $productCharacteristicItem){
                if($productCharacteristicItem->characteristic->id == $c_id){
                    return $productCharacteristicItem;
                }
            }

            return null;
        }

        public function isBaseProduct(){
            if(!empty($this->relatedProducts) and empty($this->relatedProducts0)){
                return true;
            }

            return false;
        }

        public function isSingleProduct(){
            if(empty($this->relatedProducts) and empty($this->relatedProducts0)){
                return true;
            }

            return false;
        }

        public function isRelatedProduct(){
            if(empty($this->relatedProducts) and !empty($this->relatedProducts0)){
                return true;
            }

            return false;
        }

        public static function getOptions($model){
            $options = [];

            foreach($model->productCharacteristicItems as $prodCharItem){
                if($prodCharItem->characteristic->isOption){
                    $options[$model->id][] = [
                        'id'    => $prodCharItem->characteristic->id,
                        'itemId' => $prodCharItem->id,
                        'title' => $prodCharItem->characteristic->title,
                        'value' => $prodCharItem->value
                    ];
                }
            }
            foreach($model->rProducts() as $rp){
                foreach($rp->productCharacteristicItems as $prodCharItem){
                    if($prodCharItem->characteristic->isOption){
                        $options[$rp->id][] = [
                            'id'    => $prodCharItem->characteristic->id,
                            'itemId' => $prodCharItem->id,
                            'title' => $prodCharItem->characteristic->title,
                            'value' => $prodCharItem->value
                        ];
                    }
                }
            }

            return $options;
        }
    }
