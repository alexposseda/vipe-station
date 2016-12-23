<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%order_client_data}}".
     *
     * @property integer     $id
     * @property integer     $client_id
     * @property integer     $order_id
     * @property string      $name
     * @property string      $email
     * @property string      $phone
     * @property integer     $created_at
     * @property integer     $updated_at
     *
     * @property ClientModel $client
     * @property OrderModel  $order
     */
    class OrderClientDataModel extends ActiveRecord{

        public function init(){
            parent::init();
            if(!Yii::$app->user->isGuest){
                $this->client_id = UserIdentity::findOne(Yii::$app->user->id)->client->id;
                if($this->client){
                    $this->email = $this->client->email;
                    $this->name = $this->client->name;
                    $this->phone = $this->client->phones_arr[0];
                }
            }
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
            return '{{%order_client_data}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['client_id', 'order_id', 'created_at', 'updated_at'], 'integer'],
                [['order_id', 'name', 'phone'], 'required'],
                [['name', 'email', 'phone'], 'string', 'max' => 255],
                [
                    ['client_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => ClientModel::className(),
                    'targetAttribute' => ['client_id' => 'id']
                ],
                [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderModel::className(), 'targetAttribute' => ['order_id' => 'id']],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'         => 'ID',
                'client_id'  => 'Client ID',
                'order_id'   => 'Order ID',
                'name'       => 'Name',
                'email'      => 'Email',
                'phone'      => 'Phone',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getClient(){
            return $this->hasOne(ClientModel::className(), ['id' => 'client_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOrder(){
            return $this->hasOne(OrderModel::className(), ['id' => 'order_id']);
        }
    }
