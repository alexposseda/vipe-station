<?php

    namespace common\models;

    use common\models\forms\PasswordResetRequestForm;
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%user}}".
     *
     * @property integer     $id
     * @property string      $auth_key
     * @property string      $password_hash
     * @property string      $password_reset_token
     * @property string      $email
     * @property integer     $status
     * @property integer     $created_at
     * @property integer     $updated_at
     *
     * @property ClientModel $client
     * @property CartModel[] $carts
     * @property LogModel[]  $logs
     */
    class User extends ActiveRecord{

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
            return '{{%user}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['auth_key', 'password_hash', 'email'], 'required'],
                [['status', 'created_at', 'updated_at'], 'integer'],
                [['auth_key'], 'string', 'max' => 32],
                [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
                [['email'], 'unique'],
                [['password_reset_token'], 'unique'],
                //temp
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'                   => 'ID',
                'auth_key'             => 'Auth Key',
                'password_hash'        => 'Password Hash',
                'password_reset_token' => 'Password Reset Token',
                'email'                => Yii::t('models/user', 'Email'),
                'role'                 => Yii::t('models/user', 'Role'),
                'status'               => Yii::t('models/user', 'Status'),
                'created_at'           => Yii::t('models', 'Created'),
                'updated_at'           => Yii::t('models', 'Last Update'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getClient(){
            return $this->hasOne(ClientModel::className(), ['user_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCarts(){
            return $this->hasMany(CartModel::className(), ['user_id' => 'id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getLogs(){
            return $this->hasMany(LogModel::className(), ['user_id' => 'id']);
        }

    }
