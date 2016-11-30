<?php

    namespace common\models;

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
                'title'       => Yii::t('models/brand', 'Brand Title'),
                'cover'       => Yii::t('models/brand', 'Logo'),
                'description' => Yii::t('models/brand', 'Brand Description'),
                'slug'        => Yii::t('models', 'Slug'),
                'seo_id'      => 'Seo ID',
                'created_at'  => Yii::t('models', 'Created'),
                'updated_at'  => Yii::t('models', 'Last Update'),
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
            return FileManager::getInstance()->getStorageUrl().json_decode($this->cover)[0];
        }
    }
