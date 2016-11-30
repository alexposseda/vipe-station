<?php
    namespace common\models\forms;

    use common\components\sender\Sender;
    use common\models\UserIdentity;
    use Yii;
    use yii\base\Model;
    use common\models\User;

    /**
     * Signup form
     */
    class SignupForm extends Model{
        public $email;
        public $password;
        public $password_repeat;

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    'email',
                    'trim'
                ],
                [
                    'email',
                    'required'
                ],
                [
                    'email',
                    'email'
                ],
                [
                    'email',
                    'string',
                    'max' => 255
                ],
                [
                    'email',
                    'unique',
                    'targetClass' => '\common\models\User',
                    'message'     => 'This email address has already been taken.'
                ],

                [
                    [
                        'password',
                        'password_repeat'
                    ],
                    'required'
                ],
                [
                    'password',
                    'string',
                    'min' => 6
                ],
                [
                    'password',
                    'compare'
                ]
            ];
        }

        /**
         * Signs user up.
         *
         * @return User|bool the saved model or null if saving fails
         */
        public function signup(){
            if(!$this->validate()){
                return false;
            }
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $user = new UserIdentity();
                $user->email = $this->email;
                $user->setPassword($this->password);
                $user->status = UserIdentity::STATUS_ACTIVE;
                $user->generateAuthKey();

                if(!$user->save()){
                    throw new \Exception('error save user');
                }
                $mailer = new Sender();
                if(!$mailer->sendMail($this->email, 'Registration', '_registration')){
                    throw new \Exception('error send message');
                }

                $auth = Yii::$app->authManager;
                $role = $auth->getRole('user');
                $auth->assign($role, $user->id);

                $transaction->commit();

                return true;
            }catch(\Exception $e){
                $transaction->rollBack();

                return false;
            }
        }
    }
