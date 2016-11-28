<?php

    namespace common\components\sender;

    use Swift_Plugins_Loggers_ArrayLogger;
    use Yii;
    use yii\base\Object;
    use yii\mail\MessageInterface;

    /**
     * Class Sender
     * @package common\components
     *
     * @property \yii\mail\MailerInterface              $_mailer
     * @property string                                 $_charset
     * @property string                                 $_senderEmail
     * @property string                                 $_viewDirectory
     * @property array                                  $_errors
     * @property null|Swift_Plugins_Loggers_ArrayLogger $_logger
     */
    class Sender extends Object{
        private $_mailer;
        private $_charset       = "utf-8";
        private $_senderEmail;
        private $_viewDirectory = "@common/components/sender/views/";
        private $_errors        = [];
        private $_logger        = null;

        /**
         * Sender constructor.
         *
         * @param array $config
         */
        public function __construct(array $config = []){
            $this->_mailer = Yii::$app->mailer;
            $this->_mailer->htmlLayout = $this->_viewDirectory.'layouts/html.php';
            $this->_mailer->textLayout = $this->_viewDirectory.'layouts/text.php';
            $this->_senderEmail = Yii::$app->params['robotEmail'];

            if(YII_ENV == 'dev'){
                $this->_logger = new Swift_Plugins_Loggers_ArrayLogger();
                $this->_mailer->getSwiftMailer()
                              ->registerPlugin(new \Swift_Plugins_LoggerPlugin($this->_logger));
            }
            parent::__construct($config);
        }

        /**
         * Sender init
         * register translation here
         */
        public function init(){
            parent::init();
            $this->registerTranslations();
        }

        /**
         * @param string $recipient
         * @param string $subject
         * @param string $template
         * @param array  $params
         *
         * @return bool
         */
        public function sendMail($recipient, $subject, $template, array $params = []){
            $mail = $this->createEmail($recipient, $subject, $template, $params);
            return $this->tryToSend($mail);
        }

        /**
         * @return array
         */
        public function getErrors(){
            return $this->_errors;
        }

        /**
         * @param string $recipient
         * @param string $subject
         * @param string $template
         * @param array  $params
         *
         * @return MessageInterface
         */
        private function createEmail($recipient, $subject, $template, array $params){
            return $this->_mailer->compose([
                                               'html' => $this->_viewDirectory.'templates/html/'.$template.'.php',
                                               'text' => $this->_viewDirectory.'templates/text/'.$template.'.php'
                                           ], $params)
                                 ->setCharset($this->_charset)
                                 ->setFrom([$this->_senderEmail => 'Robot of '.Yii::$app->name])
                                 ->setTo($recipient)
                                 ->setSubject($subject);
        }

        /**
         * @param MessageInterface $mail
         *
         * @return bool
         */
        private function tryToSend($mail){
            $isMailSend = false;
            try{
                if($mail->send()){
                    $isMailSend = true;
                }
            }catch(\Exception $e){
                if(!is_null($this->_logger)){
                    $this->_errors[] = $this->_logger->dump();
                }else{
                    $this->_errors[] = Yii::t('mailer/errors', 'Sorry, We cannot to send email...send email...');
                }
            }

            return $isMailSend;
        }

        /**
         * translations configuration
         */
        private function registerTranslations(){
            $i18n = Yii::$app->i18n;
            $i18n->translations['mailer*'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath'       => '@common/components/sender/translations',
                'fileMap'        => [
                    'mailer/messages' => 'messages.php',
                    'mailer/errors'   => 'errors.php',
                ],
            ];
        }
    }