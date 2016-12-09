<?php

    namespace common\models;

    use common\components\LanguageBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%delivery}}".
     *
     * @property integer      $id
     * @property string       $name
     * @property string       $description
     * @property integer      $price
     * @property integer      $created_at
     * @property integer      $updated_at
     *
     * @property OrderModel[] $orders
     */
    class DeliveryModel extends ActiveRecord{

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
                [
                    'class'             => LanguageBehavior::className(),
                    'langModelName'     => DeliveryLangModel::className(),
                    'relationFieldName' => 'delivery_id',
                    't_category'        => 'models/delivery',
                    'attributes'        => [
                        'name',
                        'description'
                    ],
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%delivery}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['name', 'description', 'price'], 'required'],
                [['description'], 'string'],
                [['price', 'created_at', 'updated_at'], 'integer'],
                [['name'], 'string', 'max' => 255],
                [['name'], 'unique'],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'          => 'ID',
                'name'        => Yii::t('models/delivery', 'Delivery Name'),
                'description' => Yii::t('models/delivery', 'Delivery Description'),
                'price'       => Yii::t('models/delivery', 'Price'),
                'created_at'  => Yii::t('models', 'Created'),
                'updated_at'  => Yii::t('models', 'Last Update'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOrders(){
            return $this->hasMany(OrderModel::className(), ['delivery_id' => 'id']);
        }
    }
