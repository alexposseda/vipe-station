<?php

    namespace common\models;

    use common\components\LangModelsBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%delivery_lang}}".
     *
     * @property integer       $id
     * @property integer       $delivery_id
     * @property string        $language
     * @property string        $name
     * @property string        $description
     * @property integer       $created_at
     * @property integer       $updated_at
     *
     * @property DeliveryModel $delivery
     * @property LanguageModel $language0
     */
    class DeliveryLangModel extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
                [
                    'class'      => LangModelsBehavior::class,
                    'attributes' => ['description', 'name']
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%delivery_lang}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['delivery_id', 'language'], 'required'],
                [['delivery_id', 'created_at', 'updated_at'], 'integer'],
                [['language', 'description'], 'string'],
                [['name'], 'string', 'max' => 255],
                [
                    ['delivery_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => DeliveryModel::className(),
                    'targetAttribute' => ['delivery_id' => 'id']
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
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'          => 'ID',
                'delivery_id' => 'Delivery ID',
                'language'    => 'Language',
                'name'        => 'Name',
                'description' => 'Description',
                'created_at'  => 'Created At',
                'updated_at'  => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getDelivery(){
            return $this->hasOne(DeliveryModel::className(), ['id' => 'delivery_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getLanguage0(){
            return $this->hasOne(LanguageModel::className(), ['id' => 'language']);
        }
    }
