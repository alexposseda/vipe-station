<?php

    namespace common\models;

    use common\models\forms\DeliveryAddressForm;
    use common\models\forms\PasswordResetRequestForm;
    use common\models\forms\SignupForm;
    use Yii;
    use yii\base\Model;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;

    /**
     * This is the model class for table "{{%client}}".
     *
     * @property integer                $id
     * @property integer                $user_id
     * @property string                 $name
     * @property string                 $phones
     * @property integer                $birthday
     * @property string                 $delivery_data
     * @property integer                $created_at
     * @property integer                $updated_at
     *
     * @property User                   $user
     * @property OrderClientDataModel[] $orderClientDatas
     * @property DeliveryAddressForm [] $deliveryData
     */
    class ClientModel extends ActiveRecord{
        public $f_name;
        public $l_name;
        public $phones_arr = [];
        public $email;
        public $deliveryData = [];


        public static function clientExists($email){
            if($user = UserIdentity::findByEmail($email)){
                return self::find()
                           ->where(['user_id' => $user->id])
                           ->exists();
            }

            return false;
        }

	    public function afterDelete(  ) {
		    Yii::$app->cache->flush();
	    }

        public function afterFind(){
            $tmp = explode(' ', trim($this->name));
            $this->f_name = $tmp[0];
            $this->l_name = $tmp[1];
            if(!empty($this->phones)){
                $temp =  json_decode($this->phones);
                foreach($temp as $key => $t){
                    $this->phones_arr[$key] = $t;
                }

            }
            $this->email = $this->user->email;
            if(!empty($this->delivery_data)){
                $this->delivery_data = json_decode($this->delivery_data);
                foreach($this->delivery_data as $index => $delivery){
                    $this->deliveryData[] = new DeliveryAddressForm($delivery);
                    $this->deliveryData[$index]['email'] = $this->email;
                }
            }
        }

        public function beforeValidate(){
            if(!empty($this->f_name) || !empty($this->l_name)){
                $this->name = $this->f_name.' '.$this->l_name;
            }

            /*$this->phones_arr = [];
            $client = (Yii::$app->request->post('ClientModel'));
            $leng_phon = count($client['phones_arr']);
            if($leng_phon >0){
                $keys_phone = array_keys($client['phones_arr']);
                for($i = 0; $i < $leng_phon; $i++){
                    $this->phones_arr[$keys_phone[$i]] = $client['phones_arr'][$keys_phone[$i]];
                }
            }*/


            if(!empty($this->phones_arr)){
                $this->phones = json_encode($this->phones_arr);
            }

            $this->deliveryData = [];
            $leng = count(Yii::$app->request->post('DeliveryAddressForm'));
            if($leng > 0){
                $keys = array_keys(Yii::$app->request->post('DeliveryAddressForm'));
                for($i = 0; $i < $leng; $i++){
                    $this->deliveryData[$keys[$i]] = new DeliveryAddressForm();
                }
                if(!Model::loadMultiple($this->deliveryData, Yii::$app->request->post()) && !Model::validateMultiple($this->deliveryData)){
                    return false;
                }

            }
            $this->delivery_data = json_encode($this->deliveryData);

            return parent::beforeValidate();
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
            return '{{%client}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    ['name'],
                    'required'
                ],
                [
                    [
                        'user_id',
                        'birthday',
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    ['email'],
                    'string'
                ],
                [
                    [
                        'name',
                        'phones'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    [
                        'phones_arr',
                        'deliveryData',
                    ],
                    'safe'
                ],
                [
                    ['user_id'],
                    'unique'
                ],
                [
                    ['user_id'],
                    'exist',
                    'skipOnError'     => true,
                    'targetClass'     => User::className(),
                    'targetAttribute' => ['user_id' => 'id']
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'            => 'ID',
                'user_id'       => 'User ID',
                'name'          => Yii::t('models/client', 'Name'),
                'email'         => Yii::t('models/client', 'Email'),
                'phones'        => Yii::t('models/client', 'Phones'),
                'birthday'      => Yii::t('models/client', 'Birthday'),
                'delivery_data' => Yii::t('models/client', 'Delivery data'),
                'created_at'    => 'Created At',
                'updated_at'    => 'Updated At',
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
        public function getOrderClientDatas(){
            return $this->hasMany(OrderClientDataModel::className(), ['client_id' => 'id']);
        }

        public function beforeSave($insert){
            if($user = UserIdentity::findByEmail($this->email)){
                $this->user_id = $user->id;

                return parent::beforeSave($insert);
            }else{
                if($user = $this->signClient()){
                    $this->user_id = $user->id;

                    return parent::beforeSave($insert);
                }
            }

            return false;
        }

        /**
         * @return bool|UserIdentity
         */
        protected function signClient(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $user = UserIdentity::findByEmail($this->email);
                $user = $user ? $user : new UserIdentity();

                $user->email = $this->email;
                $user->setPassword(Yii::$app->security->generateRandomString(8));
                $user->status = UserIdentity::STATUS_ACTIVE;
                $user->generateAuthKey();

                if(!$user->save()){
                    throw new \Exception('error save user');
                }
                $resets = new PasswordResetRequestForm(['email' => $this->email]);
                if(!$resets->sendEmail()){
                    throw new \Exception('error send mail');
                }

                $auth = Yii::$app->authManager;
                $role = $auth->getRole('user');
                $auth->assign($role, $user->id);

                $transaction->commit();

                return $user;
            }catch(\Exception $e){
                $transaction->rollBack();

                return false;
            }
        }
    }
