<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%seo}}".
     *
     * @property integer         $id
     * @property string          $title
     * @property string          $keywords
     * @property string          $description
     * @property string          $seo_block
     * @property integer         $created_at
     * @property integer         $updated_at
     *
     * @property CategoryModel[] $categories
     * @property ProductModel[]  $products
     * @property BrandModel[]    $brands
     */
    class SeoModel extends ActiveRecord{

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
            return '{{%seo}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    ['seo_block'],
                    'string'
                ],
                [
                    [
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    [
                        'title',
                        'keywords'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    ['description'],
                    'string',
                    'max' => 500
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'          => 'ID',
                'title'       => 'Title',
                'keywords'    => 'Keywords',
                'description' => 'Description',
                'seo_block'   => 'Seo Block',
                'created_at'  => 'Created At',
                'updated_at'  => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategories(){
            return $this->hasMany(CategoryModel::className(), ['seo_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProducts(){
            return $this->hasMany(ProductModel::className(), ['seo_id' => 'id']);
        }
        /**
         * @return \yii\db\ActiveQuery
         */
        public function getBrands(){
            return $this->hasMany(BrandModel::className(), ['seo_id' => 'id']);
        }

        public function canSave(){
            if(!empty($this->title) or !empty($this->keywords) or !empty($this->description) or !empty($this->seo_block)){
                return true;
            }

            return false;
        }
    }
