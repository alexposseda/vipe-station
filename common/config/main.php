<?php
    return [
        'sourceLanguage' => 'en',
        'language' => 'ru',
        'vendorPath' => dirname(dirname(__DIR__)).'/vendor',
        'components' => [
            'cache'       => [
                'class' => 'yii\caching\FileCache',

            ],
            'authManager' => [
                'class' => 'yii\rbac\DbManager',
            ],
            'urlManager' => [
                'class' => 'codemix\localeurls\UrlManager',
                'languages' => ['en', 'ru', 'ua'],
                'enablePrettyUrl' => true,
                'showScriptName' => false,
            ],
            'i18n' => [
                'translations' => [
                    'system*' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'basePath' => '@common/translations',
                        'sourceLanguage' => 'en',
                        'fileMap' => [
                            'system'       => 'system/base.php',
                            'system/error' => 'system/error.php',
                            'system/success' => 'system/success.php',
                        ],
                    ],
                    'shop*'=>[
                        'class'          => 'yii\i18n\PhpMessageSource',
                        'basePath'       => '@common/translations',
                        'sourceLanguage' => 'en',
                        'fileMap'        => [
                            'shop/setting'        => 'shop/setting.php',
                        ],
                    ]
                ],
            ],
        ],

    ];
