<?php
    namespace common\models;

    use common\models\forms\PasswordResetRequestForm;
    use Yii;
    use yii\base\NotSupportedException;
    use yii\helpers\ArrayHelper;
    use yii\web\IdentityInterface;

    class UserIdentity extends User implements IdentityInterface{
        const STATUS_DELETED = 0;
        const STATUS_ACTIVE  = 10;

        public $role;

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                ['email', 'email'],
                ['role', 'string'],
                ['status', 'default', 'value' => self::STATUS_ACTIVE],
                ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ];
        }

        /**
         * @inheritdoc
         */
        public static function findIdentity($id){
            return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }

        /**
         * @inheritdoc
         */
        public static function findIdentityByAccessToken($token, $type = null){
            throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }

        /**
         * Finds user by username
         *
         * @param string $username
         *
         * @return static|null
         */
        public static function findByUsername($username){
            return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        }

        /**
         * Finds user by email
         *
         * @param string $email
         *
         * @return static|null
         */
        public static function findByEmail($email){
            return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
        }

        /**
         * Finds user by password reset token
         *
         * @param string $token password reset token
         *
         * @return static|null
         */
        public static function findByPasswordResetToken($token){
            if(!static::isPasswordResetTokenValid($token)){
                return null;
            }

            return static::findOne([
                                       'password_reset_token' => $token,
                                       'status'               => self::STATUS_ACTIVE,
                                   ]);
        }

        /**
         * Finds out if password reset token is valid
         *
         * @param string $token password reset token
         *
         * @return bool
         */
        public static function isPasswordResetTokenValid($token){
            if(empty($token)){
                return false;
            }

            $timestamp = (int)substr($token, strrpos($token, '_') + 1);
            $expire = Yii::$app->params['user.passwordResetTokenExpire'];

            return $timestamp + $expire >= time();
        }

        /**
         * @inheritdoc
         */
        public function getId(){
            return $this->getPrimaryKey();
        }

        /**
         * @inheritdoc
         */
        public function getAuthKey(){
            return $this->auth_key;
        }

        /**
         * @inheritdoc
         */
        public function validateAuthKey($authKey){
            return $this->getAuthKey() === $authKey;
        }

        /**
         * Validates password
         *
         * @param string $password password to validate
         *
         * @return bool if password provided is valid for current user
         */
        public function validatePassword($password){
            return Yii::$app->security->validatePassword($password, $this->password_hash);
        }

        /**
         * Generates password hash from password and sets it to the model
         *
         * @param string $password
         */
        public function setPassword($password){
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }

        /**
         * Generates "remember me" authentication key
         */
        public function generateAuthKey(){
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        /**
         * Generates new password reset token
         */
        public function generatePasswordResetToken(){
            $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
        }

        /**
         * Removes password reset token
         */
        public function removePasswordResetToken(){
            $this->password_reset_token = null;
        }

        public function setUserRole($role_name){
            $userRole = Yii::$app->authManager->getRole($role_name);
            $current_role = current(Yii::$app->authManager->getRolesByUser($this->id));
            if(!empty($current_role)){
                if($current_role->name == $role_name){
                    return true;
                }
                if(!Yii::$app->authManager->revoke($current_role, $this->id)){
                    throw new \Exception('error revoke role');
                }
            }
            if(Yii::$app->authManager->assign($userRole, $this->id)){
                return true;
            }

            return false;
        }

        public function saveUser(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$this->save()){
                    throw new \Exception('error save user');
                }
                if(!$this->setUserRole($this->role)){
                    throw  new \Exception('error assign role');
                }
                if(empty($this->password_reset_token)){
                    $resets = new PasswordResetRequestForm(['email' => $this->email]);
                    if(!$resets->sendEmail()){
                        throw new \Exception('error send mail');
                    }
                }

                $transaction->commit();

                return true;
            }catch(\Exception $e){
                $transaction->rollBack();

                return false;
            }
        }

        public function afterFind(){
            $this->role = $this->isNewRecord ? '' : current(Yii::$app->authManager->getRolesByUser($this->id))->name;
        }
    }
