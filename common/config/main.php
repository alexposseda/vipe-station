<?php
    return [
        'sourceLanguage' => 'ru',
        'language'       => 'ru',
        'vendorPath'     => dirname(dirname(__DIR__)).'/vendor',
        'bootstrap'      => ['logger'],
        'components'     => [
            'cache'       => [
                'class' => 'yii\caching\FileCache',
            ],
            'authManager' => [
                'class' => 'yii\rbac\DbManager',
            ],
            'db' => [
                'enableSchemaCache' => true,
            ],
            'urlManager'  => [
                'class'           => 'codemix\localeurls\UrlManager',
                'languages'       => [
                    'ru',
                    'ua'
                ],
                'enablePrettyUrl' => true,
                'showScriptName'  => false,
            ],
            'logger'      => [
                'class' => \common\components\logger\LogComponent::className(),
                'a'     => 3
            ],
            'i18n'        => [
                'translations' => [
                    'system*' => [
                        'class'          => 'yii\i18n\PhpMessageSource',
                        'basePath'       => '@common/translations',
                        'sourceLanguage' => 'en',
                        'fileMap'        => [
                            'system'         => 'system/base.php',
                            'system/error'   => 'system/error.php',
                            'system/success' => 'system/success.php',
                            'system/view'    => 'system/view.php',
                        ],
                    ],
                    'logger*' => [
                        'class'          => 'yii\i18n\PhpMessageSource',
                        'basePath'       => '@common/translations',
                        'sourceLanguage' => 'en',
                        'fileMap'        => [
                            'logger' => 'system/logger.php',
                        ],
                    ],
                    'models*' => [
                        'class'          => 'yii\i18n\PhpMessageSource',
                        'basePath'       => '@common/translations',
                        'sourceLanguage' => 'en',
                        'fileMap'        => [
                            'models'           => 'models/base.php',
                            'models/brand'     => 'models/brand.php',
                            'models/authorize' => 'models/authorize.php',
                            'models/client'    => 'models/client.php',
                            'models/seo'       => 'models/seo.php',
                            'models/cart'      => 'models/cart.php',
                            'models/category'  => 'models/category.php',
                            'models/delivery'  => 'models/delivery.php',
                            'models/payment'   => 'models/payment.php',
                            'models/user'      => 'models/user.php',
                        ],
                    ],
                    'shop*'   => [
                        'class'          => 'yii\i18n\PhpMessageSource',
                        'basePath'       => '@common/translations',
                        'sourceLanguage' => 'en',
                        'fileMap'        => [
                            'shop/setting' => 'shop/setting.php',
                        ],
                    ]
                ],
            ],
        ],

    ];
