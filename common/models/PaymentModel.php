<?php

    namespace common\models;

    use common\components\LanguageBehavior;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%payment}}".
     *
     * @property integer      $id
     * @property string       $name
     * @property string       $description
     * @property integer      $created_at
     * @property integer      $updated_at
     *
     * @property OrderModel[] $orders
     */
    class PaymentModel extends ActiveRecord{

	    public function afterDelete() {
		    Yii::$app->cache->flush();
	    }
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
                [
                    'class'             => LanguageBehavior::className(),
                    'langModelName'     => PaymentLangModel::className(),
                    'relationFieldName' => 'payment_id',
                    't_category'        => 'models/payment',
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
            return '{{%payment}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['name'], 'required'],
                [['description'], 'string'],
                [['created_at', 'updated_at'], 'integer'],
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
                'name'        => Yii::t('models/payment', 'Payment Name'),
                'description' => Yii::t('models/payment', 'Payment Description'),
                'created_at'  => Yii::t('models', 'Created'),
                'updated_at'  => Yii::t('models', 'Last Update'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOrders(){
            return $this->hasMany(OrderModel::className(), ['payment_id' => 'id']);
        }
    }
