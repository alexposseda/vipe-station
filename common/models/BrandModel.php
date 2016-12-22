<?php

    namespace common\models;

    use common\components\LanguageBehavior;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\behaviors\SluggableBehavior;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%brand}}".
     *
     * @property integer        $id
     * @property string         $title
     * @property string         $cover
     * @property string         $description
     * @property string         $slug
     * @property integer        $seo_id
     * @property integer        $created_at
     * @property integer        $updated_at
     *
     * @property SeoModel       $seo
     * @property ProductModel[] $products
     * @property mixed          logo
     */
    class BrandModel extends ActiveRecord{

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
                    'langModelName' => BrandLangModel::className(),
                    'relationFieldName' => 'brand_id',
                    't_category' => 'models/brand',
                    'attributes'    => [
                        'title',
                        'description'
                    ],
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%brand}}';
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
                    ['description'],
                    'string'
                ],
                [
                    [
                        'seo_id',
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    [
                        'title',
                        'cover',
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
                'id'          => 'ID',
                'title'       => 'Brand Title',
                'cover'       => 'Logo',
                'description' => 'Brand Description',
                'slug'        => 'Slug',
                'seo_id'      => 'Seo ID',
                'created_at'  => 'Created',
                'updated_at'  => 'Last Update',
            ];
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
        public function getProducts(){
            return $this->hasMany(ProductModel::className(), ['brand_id' => 'id']);
        }

        /**
         * @return string
         */
        public function getLogo(){
            if(!empty($this->cover)){
                return FileManager::getInstance()
                                  ->getStorageUrl().json_decode($this->cover)[0];
            }

            return null;
        }

        public function beforeDelete(){
            if($this->seo){
                $this->seo->delete();
            }

            if(!empty($this->cover)){
                FileManager::getInstance()->removeFile(json_decode($this->cover)[0]);
            }

            return true;
        }
    }
