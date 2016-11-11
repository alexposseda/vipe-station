<?php
require_once "db.php";
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . $dbSetting['host'] . ';dbname=' . $dbSetting['name'],
            'username' => $dbSetting['user'],
            'password' => $dbSetting['pass'],
            'charset' => 'utf8',
            'tablePrefix' => $dbSetting['tablePrefix'],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
    ],
];
