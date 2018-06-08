<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
	'modules' => [
        'admin' => [
            'class' => 'common\modules\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'common\modules\admin\controllers\AssignmentController',
                    'userClassName' => 'common\models\User',  // fully qualified class name of your User model
                    // Usually you don't need to specify it explicitly, since the module will detect it automatically
                    'idField' => 'id',                          // id field of your User model that corresponds to Yii::$app->user->id
                    'usernameField' => 'username',              // username field of your User model
                    'searchClass' => 'common\models\UserSearch' // fully qualified class name of your User model for searching
                ],
            ],
            'layout'=>'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
            'menus' => [
                // disable menu
            ],

        ],
	],
];
