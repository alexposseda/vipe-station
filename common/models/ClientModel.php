<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $phones
 * @property integer $birthday
 * @property string $delivery_data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property OrderClientData[] $orderClientDatas
 */
class ClientModel extends ActiveRecord
{

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id', 'birthday', 'created_at', 'updated_at'], 'integer'],
            [['delivery_data'], 'string'],
            [['name', 'phones'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'phones' => 'Phones',
            'birthday' => 'Birthday',
            'delivery_data' => 'Delivery Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderClientDatas()
    {
        return $this->hasMany(OrderClientData::className(), ['client_id' => 'id']);
    }
}
