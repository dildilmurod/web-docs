<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'aliases' => [
        '@adminlte/widgets'=>'@vendor/adminlte/yii2-widgets'
        ],
    'bootstrap' => ['log'],
    'modules' => [
        /*'admin' => [
            'class' => 'mdm\admin\Module',
        ],*/
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
        ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
    ],
    'language' => 'ru',
    'components' => [
//        'view' => [
//            'theme' => [
//            'pathMap' => [
//            '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//                     ],
//                ],
//            ],
        'request' => [
            'csrfParam' => '_csrf-backend',

        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'loginUrl' => ['/site/login'],
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'user', 'pluralize' => false],
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'rest-article', 'pluralize' => false],
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'rest-menu', 'pluralize' => false],
            ],
        ],

//        'request' => [
//            'parsers' => [
//                'application/json' => 'yii\web\JsonParser',
//            ]
//        ],

    ],
    /*'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            //'admin/*',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],*/
    'params' => $params,
];
