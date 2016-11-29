<?php
    namespace common\models\forms;

    use common\components\sender\Sender;
    use Yii;
    use yii\base\Model;
    use common\models\UserIdentity;

    /**
     * Password reset request form
     */
    class PasswordResetRequestForm extends Model{
        public $email;


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
                    'exist',
                    'targetClass' => '\common\models\UserIdentity',
                    'filter'      => ['status' => UserIdentity::STATUS_ACTIVE],
                    'message'     => Yii::t('system/error', 'no user with email')
                ],
            ];
        }

        /**
         * Sends an email with a link, for resetting the password.
         *
         * @return bool whether the email was send
         */
        public function sendEmail(){
            /* @var $user UserIdentity */
            $user = UserIdentity::findOne([
                                              'status' => UserIdentity::STATUS_ACTIVE,
                                              'email'  => $this->email,
                                          ]);

            if(!$user){
                return false;
            }

            if(!UserIdentity::isPasswordResetTokenValid($user->password_reset_token)){
                $user->generatePasswordResetToken();
                if(!$user->save()){
                    return false;
                }
            }
            $mailer = new Sender();

            return $mailer->sendMail($this->email, 'Password reset for '.Yii::$app->name, 'passwordResetToken', ['user' => $user]);
        }
    }
