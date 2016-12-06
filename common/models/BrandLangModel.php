<?php

    namespace common\models;

    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%brand_lang}}".
     *
     * @property integer       $id
     * @property integer       $brand_id
     * @property integer       $language
     * @property string        $title
     * @property string        $description
     * @property integer       $created_at
     * @property integer       $updated_at
     *
     * @property LanguageModel $language0
     * @property BrandModel    $brand
     */
    class BrandLangModel extends ActiveRecord{
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
                        'language'
                    ],
                    'required'
                ],
                [
                    [
                        'brand_id',
                        'language',
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    ['description'],
                    'string'
                ],
                [
                    ['title'],
                    'string',
                    'max' => 255
                ],
                [
                    ['language'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => LanguageModel::className(),
                    'targetAttribute' => ['language' => 'id']
                ],
                [
                    ['brand_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => BrandModel::className(),
                    'targetAttribute' => ['brand_id' => 'id']
                ],
            ];
        }


        /**
         * @return \yii\db\ActiveQuery
         */
        public function getLanguage0()
        {
            return $this->hasOne(LanguageModel::className(), ['id' => 'language']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getBrand()
        {
            return $this->hasOne(BrandModel::className(), ['id' => 'brand_id']);
        }
    }