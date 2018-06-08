<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/18/17
 * Time: 14:21
 */

namespace backend\controllers;

use common\models\AccessControl\AdminAccessControl;
use common\models\User;
use Yii;


class Controller extends \yii\web\Controller
{
    /* * @param integer $id*/

//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AdminAccessControl::className(),
////                'rules' => [
////                    [
////                        'actions' => ['login', 'error'],
////                        'allow' => true,
////                        'roles' => ['?'],
////                    ],
////                    [
////                        'allow' => true,
////                        'roles' => ['@'],
////                    ],
////                ],
//            ],
////            'verbs' => [
////                'class' => VerbFilter::className(),
////                'actions' => [
////                    'logout' => ['post'],
////                ],
////            ],
//        ];
//
//    }
}
