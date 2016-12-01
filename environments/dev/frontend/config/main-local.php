<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache', //todo Поменять потом на реальное кеширование
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [ //here
                          'model' => [
                              'class' => 'yii\gii\generators\model\Generator', // generator class
                              'templates' => [
                                  'Time_Model' => '@common/gii/modeltsb', // template name => path to template
                                  'Time&Slug_Model' => '@common/gii/modelslug', // template name => path to template
                              ]
                          ]
        ],
    ];
}

return $config;
