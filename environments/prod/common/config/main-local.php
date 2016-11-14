<?php
return [
    'name' => $appSettings['name'],
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
            'useFileTransport' => $mailSetting['fileTransport'],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $mailSetting['host'],
                'username' => $mailSetting['user'],
                'password' => $mailSetting['pass'],
                'port' => $mailSetting['port'],
                'encryption' => $mailSetting['encryption'] ? true : false,
            ],
        ],
    ],
];
