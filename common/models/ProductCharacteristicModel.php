<?php

    namespace common\models;

    use common\components\LanguageBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%product_characteristic}}".
     *
     * @property integer                          $id
     * @property integer                          $category_id
     * @property string                           $title
     * @property integer                          $created_at
     * @property integer                          $updated_at
     * @property integer                          $isOption
     *
     * @property CategoryModel                    $category
     * @property ProductCharacteristicItemModel[] $productCharacteristicItems
     * @property ProductOptionModel[]             $productOptions
     */
    class ProductCharacteristicModel extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
                [
                    'class'             => LanguageBehavior::className(),
                    'langModelName'     => ProductCharacteristicLangModel::className(),
                    'relationFieldName' => 'product_characteristic_id',
                    't_category'        => 'models/characteristic',
                    'attributes'        => [
                        'title',
                    ],
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%product_characteristic}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'category_id',
                        'title'
                    ],
                    'required'
                ],
                [
                    [
                        'category_id',
                        'created_at',
                        'updated_at',
                        'isOption'
                    ],
                    'integer'
                ],
                [
                    ['isOption'],
                    'default',
                    'value' => 0
                ],
                [
                    ['title'],
                    'string',
                    'max' => 255
                ],
                [
                    ['category_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => CategoryModel::className(),
                    'targetAttribute' => ['category_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'          => 'ID',
                'category_id' => 'Category ID',
                'title'       => Yii::t('models/characteristic', 'Title'),
                'created_at'  => Yii::t('models', 'Created'),
                'updated_at'  => Yii::t('models', 'Last Update'),
                'isOption'    => 'Is Option',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategory(){
            return $this->hasOne(CategoryModel::className(), ['id' => 'category_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductCharacteristicItems(){
            return $this->hasMany(ProductCharacteristicItemModel::className(), ['characteristic_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProductOptions(){
            return $this->hasMany(ProductOptionModel::className(), ['characteristic_id' => 'id']);
        }


    }
