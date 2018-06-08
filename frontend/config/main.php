<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',

    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => ['user/login'],
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
            'class' => 'codemix\localeurls\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableDefaultLanguageUrlCode' => true,
            'enableLanguageDetection' => true,

            'languages' => ['uz', 'ru', 'en'],
            'ignoreLanguageUrlPatterns' => [
                '#img/#' => '#img/#',
                '#js/#' => '#js/#',
                '#css/#' => '#css/#',
            ],
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rest-article', 'pluralize' => false/*,
                    'extraPatterns' => [
                        'GET rest-article' => 'rest-article', // это значит что будем принимать get
                        //'POST rest-article' => 'rest-article', // это значит, что будем  принимать post
                    ],*/
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rest-menu', 'pluralize' => false],
                '' => '/site/index',
                'page/<name:\w+>' => 'page/view',

                '<controller:\w+>/<id:\d+>/' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],


        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

    ],
    'params' => $params,
];
