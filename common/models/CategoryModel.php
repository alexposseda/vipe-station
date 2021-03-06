<?php

    namespace common\models;

    use common\components\LanguageBehavior;
    use Yii;
    use yii\behaviors\SluggableBehavior;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%category}}".
     *
     * @property integer                      $id
     * @property string                       $title
     * @property integer                      $parent
     * @property string                       $slug
     * @property integer                      $seo_id
     * @property integer                      $created_at
     * @property integer                      $updated_at
     *
     * @property CategoryModel                $parent0
     * @property CategoryModel[]              $categoryModels
     * @property SeoModel                     $seo
     * @property ProductCharacteristicModel[] $productCharacteristics
     * @property ProductInCategoryModel[]     $productInCategories
     * @property ProductModel[]               $products
     */
    class CategoryModel extends ActiveRecord{
        public $allCharacteristics = [];

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
                    'class'         => LanguageBehavior::className(),
                    'langModelName' => CategoryLangModel::className(),
                    'relationFieldName' => 'category_id',
                    't_category' => 'models/category',
                    'attributes'    => [
                        'title',
                    ],
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%category}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'title',
                        'slug'
                    ],
                    'required'
                ],
                [
                    [
                        'parent',
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
                    ['parent'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => CategoryModel::className(),
                    'targetAttribute' => ['parent' => 'id']
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
                'id'         => 'ID',
                'title'      => Yii::t('models/category', 'Category Title'),
                'parent'     => Yii::t('models/category', 'Parent'),
                'slug'       => Yii::t('models', 'Slug'),
                'seo_id'     => 'SeoModel ID',
                'created_at' => Yii::t('models', 'Created'),
                'updated_at' => Yii::t('models', 'Last Update'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getParent0(){
            return $this->hasOne(CategoryModel::className(), ['id' => 'parent']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategoryModels(){
            return $this->hasMany(CategoryModel::className(), ['parent' => 'id']);
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
        public function getProductCharacteristics(){
            return $this->hasMany(ProductCharacteristicModel::className(), ['category_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductInCategories(){
            return $this->hasMany(ProductInCategoryModel::className(), ['category_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProducts(){
            return $this->hasMany(ProductModel::className(), ['id' => 'product_id'])
                        ->viaTable('{{%product_in_category}}', ['category_id' => 'id']);
        }

        public static function allCharacteristics($id, &$characteristics = []){
            $model = CategoryModel::findOne($id);
            foreach($model->productCharacteristics as $productCharacteristic){
                $characteristics[] = $productCharacteristic;
            }

            if(!is_null($model->parent0)){
                return CategoryModel::allCharacteristics($model->parent0->id, $characteristics);
            }

            return $characteristics;

        }

        public static function allChildren($id, &$children = []){
            $models = CategoryModel::findAll(['parent' => $id]);
            if(!empty($models)) {
                foreach ($models as $model) {
                    $children[] = $model;
                    self::allChildren($model->id, $children);

                }
            }

            if(empty($children)){
                $source = CategoryModel::findOne($id);
                if($source->parent0){
                    self::allChildren($source->parent0->id,$children);
                }
            }
            return $children;
        }

	    public function afterDelete() {
		    Yii::$app->cache->flush();
	    }
    }
