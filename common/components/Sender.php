<?php

    namespace common\components;

    use Yii;
    use yii\base\Exception;
    use yii\base\Object;

    class Sender extends Object{
        private $_mailer;
        private $_charset       = "utf-8";
        private $_senderEmail;
        private $_viewDirectory = "@common/mail/templates/";
        private $_errors = [];

        public function __construct(array $config){
            $this->_mailer = Yii::$app->mailer;
            $this->_senderEmail = Yii::$app->params['robotEmail'];
            parent::__construct($config);
        }

        public function init(){
            parent::init();
            $this->registerTranslations();
        }

        public function sendMail($recipient, $subject, $template, array $params = []){
            $mail = $this->createEmail($recipient, $subject, $template, $params);
            return $this->tryToSend($mail);
        }

        public function getErrors(){
            return $this->_errors;
        }

        private function createEmail($recipient, $subject, $template, array $params){
            return $this->_mailer->compose([
                                               'html' => $this->_viewDirectory.'html/'.$template.'.php',
                                               'text' => $this->_viewDirectory.'html/'.$template.'.php'
                                           ], $params)
                                 ->setCharset($this->_charset)
                                 ->setFrom([$this->_senderEmail => 'Robot of '.Yii::$app->name])
                                 ->setTo($recipient)
                                 ->setSubject($subject);
        }

        private function tryToSend($mail){
            $isMailSend = false;
            try{
                if($mail->send()){
                    $isMailSend = true;
                }
            }catch(Exception $e){
                if(YII_ENV == 'dev'){
                    $this->_errors[] = $e->getMessage();
                }else{
                    $this->_errors[] = Yii::t('errors', 'Sorry, We cannot to send email...send email...');
                }
            }

            return $isMailSend;
        }

        private function registerTranslations(){
            $i18n = Yii::$app->i18n;
            $i18n->translations['mailer*'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath'       => '@common/mail/translations',
                'fileMap'        => [
                    'mailer/messages' => 'messages.php',
                    'mailer/errors' => 'errors.php',
                ],
            ];
        }
    }