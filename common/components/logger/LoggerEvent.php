<?php

    namespace common\components\logger;

    use yii\base\Event;

    class LoggerEvent extends Event{
        public $user_id;
        public $message;
    }