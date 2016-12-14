<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%cart}}".
     *
     * @property integer      $id
     * @property integer      $user_id
     * @property string       $guest_id
     * @property integer      $product_id
     * @property string       $options
     * @property integer      $quantity
     * @property integer      $created_at
     * @property integer      $updated_at
     *
     * @property ProductModel $product
     * @property User         $user
     */
    class CartModel extends ActiveRecord{
        public static function getCart(){
            $condition = (Yii::$app->user->isGuest) ? ['guest_id' => Yii::$app->request->cookies->get('guest_id')] : ['user_id' => Yii::$app->user->id];

            return self::findAll($condition);
        }

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
            return '{{%cart}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['user_id', 'product_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
                [['product_id', 'quantity'], 'required'],
                [['guest_id', 'options'], 'string', 'max' => 255],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'         => 'ID',
                'user_id'    => 'User ID',
                'guest_id'   => 'Guest ID',
                'product_id' => 'Product ID',
                'options'    => Yii::t('models/cart', 'Options'),
                'quantity'   => Yii::t('models/cart', 'Quantity'),
                'created_at' => Yii::t('models', 'Created'),
                'updated_at' => Yii::t('models', 'Last Update'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getUser(){
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProduct(){
            return $this->hasOne(ProductModel::className(), ['id' => 'product_id']);
        }

        public function getPrice(){
            $price = $this->product->base_price;
            if($this->options){
                foreach(json_decode($this->options) as $option){
                    $price += $option->delta_price;
                }
            }

            return $price;
        }


    }
