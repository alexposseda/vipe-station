<?php


namespace common\models;


use Exception;
use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $email;
    public $l_name;
    public $f_name;
    public $phone;
    public $password;
    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['l_name', 'f_name', 'phone', 'email'],
                'trim'
            ],
            [
                ['l_name', 'f_name', 'email', 'phone'],
                'string',
                'min' => 2,
                'max' => 255
            ],
            [
                'email',
                'email'
            ],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This email address has already been taken.'
            ],

            [
                ['email', 'l_name', 'f_name', 'password', 'password_repeat'],
                'required'
            ],
            [
                ['password', 'password_repeat'],
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
     * @return UserIdentity|bool
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new UserIdentity();
        $user->username = $this->f_name . ' ' . $this->l_name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->status = UserIdentity::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();



        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$user->save()) {
                throw new Exception('registration failed (cannot save new user)');
            }
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->id);

            $transaction->commit();
            return $user;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}