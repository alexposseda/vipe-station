<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property integer $id
 * @property string $action
 * @property string $action_data
 * @property string $initializer
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class LogModel extends ActiveRecord
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
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_data', 'initializer'], 'string'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['action'], 'string', 'max' => 255],
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
            'action' => Yii::t('models/log', 'Action'),
            'action_data' => Yii::t('models/log', 'Action Data'),
            'initializer' => Yii::t('models/log', 'Initializer'),
            'user_id' => 'User ID',
            'created_at' => Yii::t('models', 'Created'),
            'updated_at' => Yii::t('models', 'Last Update'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
