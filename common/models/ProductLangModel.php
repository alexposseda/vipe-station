<?php

    namespace common\models;

    use common\components\LangModelsBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%product_lang}}".
     *
     * @property integer       $id
     * @property integer       $product_id
     * @property string        $language
     * @property string        $title
     * @property string        $description
     * @property integer       $created_at
     * @property integer       $updated_at
     *
     * @property LanguageModel $language0
     * @property ProductModel  $product
     */
    class ProductLangModel extends ActiveRecord{

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
            return '{{%product_lang}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['product_id', 'language'], 'required'],
                [['product_id', 'created_at', 'updated_at'], 'integer'],
                [['description', 'language'], 'string'],
                [['title'], 'string', 'max' => 255],
                [
                    ['language'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => LanguageModel::className(),
                    'targetAttribute' => ['language' => 'code']
                ],
                [
                    ['product_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => ProductModel::className(),
                    'targetAttribute' => ['product_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'          => 'ID',
                'product_id'  => 'Product ID',
                'language'    => 'Language',
                'title'       => 'Title',
                'description' => 'Description',
                'created_at'  => 'Created At',
                'updated_at'  => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getLanguage0(){
            return $this->hasOne(LanguageModel::className(), ['id' => 'language']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProduct(){
            return $this->hasOne(ProductModel::className(), ['id' => 'product_id']);
        }
    }
