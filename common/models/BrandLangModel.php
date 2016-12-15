<?php

    namespace common\models;

    use common\components\LangModelsBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%brand_lang}}".
     *
     * @property integer       $id
     * @property integer       $brand_id
     * @property string        $language
     * @property string        $title
     * @property string        $description
     * @property integer       $created_at
     * @property integer       $updated_at
     *
     * @property BrandModel    $brand
     * @property LanguageModel $language0
     */
    class BrandLangModel extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
                [
                    'class'      => LangModelsBehavior::class,
                    'attributes' => ['description', 'title']
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%brand_lang}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'brand_id',
                        'language',
                    ],
                    'required'
                ],
                [
                    [
                        'brand_id',
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    ['language'],
                    'string',
                    'max' => 4
                ],
                [
                    ['description'],
                    'string'
                ],
                [
                    [
                        'title',
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    ['brand_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => BrandModel::className(),
                    'targetAttribute' => ['brand_id' => 'id']
                ],
                [
                    ['language'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => LanguageModel::className(),
                    'targetAttribute' => ['language' => 'code']
                ],
            ];
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
        public function getLanguage0(){
            return $this->hasOne(LanguageModel::className(), ['code' => 'language']);
        }
    }
