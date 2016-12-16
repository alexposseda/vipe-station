<?php

    namespace frontend\models;

    use common\components\sender\Sender;
    use Yii;
    use yii\base\Model;

    class SendMailForm extends Model{
        public $buy_name;
        public $buy_email;
        public $buy_phone;

        public function rules(){
            return [
                [['buy_name', 'buy_email', 'buy_phone',], 'required'],
                ['buy_email', 'email'],
                [['buy_name', 'buy_phone'], 'string'],
            ];
        }

        public function attributeLabels(){
            return [
                'buy_name'  => Yii::t('models/client', 'First name'),
                'buy_email' => Yii::t('models/client', 'Email'),
                'buy_phone' => Yii::t('models/client', 'Phone'),
            ];
        }

        public function send(){
            $sender = new Sender();
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$sender->sendMail($this->buy_email, Yii::t('system/view', 'Test buy'), 'mail-template-customer', ['model'=>$this])){
                    throw new \Exception('error send customer email');
                }
                if(!$sender->sendMail(Yii::$app->params['robotEmail'], Yii::t('system/view', 'Test buy'), 'mail-template-manager', ['model'=>$this])){
                    throw new \Exception('error send customer email');
                }

                $transaction->commit();
                return true;
            }catch(\Exception $e){
                $transaction->rollBack();
                return false;
            }
        }
    }