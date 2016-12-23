<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%order}}".
     *
     * @property integer                $id
     * @property string                 $comment
     * @property string                 $status
     * @property integer                $delivery_id
     * @property string                 $delivery_data
     * @property integer                $payment_id
     * @property double                 $total_cost
     * @property integer                $created_at
     * @property integer                $updated_at
     *
     * @property DeliveryModel          $delivery
     * @property PaymentModel           $payment
     * @property OrderClientDataModel[] $orderClientDatas
     * @property OrderDataModel[]       $orderDatas
     */
    class OrderModel extends ActiveRecord{
        const ORDER_STATUS_ACTIVE    = 'active';
        const ORDER_STATUS_DELETED   = 'deleted';
        const ORDER_STATUS_ABORTED   = 'aborted';
        const ORDER_STATUS_SENT      = 'sent';
        const ORDER_STATUS_CONFIRMED = 'confirmed';
        const ORDER_STATUS_FINISHED  = 'finished';
        const ORDER_STATUS_PAID      = 'paid';

        public function afterFind(){
            $this->total_cost = $this->getOrderDatas()
                                     ->sum('price') + $this->delivery->price;
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
            return '{{%order}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['comment', 'status', 'delivery_data'], 'string'],
                [['delivery_id', 'payment_id', 'created_at', 'updated_at'], 'integer'],
                [['delivery_data'], 'required'],
                [['total_cost'], 'number'],
                [
                    ['delivery_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => DeliveryModel::className(),
                    'targetAttribute' => ['delivery_id' => 'id']
                ],
                [
                    ['payment_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => PaymentModel::className(),
                    'targetAttribute' => ['payment_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'            => 'ID',
                'comment'       => 'Comment',
                'status'        => 'Status',
                'delivery_id'   => 'Delivery ID',
                'delivery_data' => 'Delivery Data',
                'payment_id'    => 'Payment ID',
                'total_cost'    => 'Total Cost',
                'created_at'    => 'Created At',
                'updated_at'    => 'Updated At',
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
        public function getPayment(){
            return $this->hasOne(PaymentModel::className(), ['id' => 'payment_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOrderClientDatas(){
            return $this->hasMany(OrderClientDataModel::className(), ['order_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOrderDatas(){
            return $this->hasMany(OrderDataModel::className(), ['order_id' => 'id']);
        }
    }
