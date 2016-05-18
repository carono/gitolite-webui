<?php
if (!file_exists($db = __DIR__ . '/db.php')) {
    copy($db . '.example', $db);
}

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'name'       => 'Gitolite Web UI',
    'bootstrap'  => ['log'],
    'components' => [
        'request'      => [
            'cookieValidationKey' => 'u0gEVZ6UUJqqUXO-Qv2Xy01JxGkBeuhL',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__ . '/db.php'),
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => [
                '/'                                          => 'site/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>'              => '<controller>/<action>',
                '<action:\w+>'                               => ''
            ],
        ],
    ],
    'params'     => require(__DIR__ . '/params.php'),
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
