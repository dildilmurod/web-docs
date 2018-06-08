<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/18/17
 * Time: 15:48
 */

namespace common\models\AccessControl;


use backend\controllers\Controller;
use common\models\User;
use Yii;
use yii\base\Behavior;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

class AdminAccessControl extends Behavior
{

    public $rules;
    public  function events(){
        return[
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        if(Yii::$app->user->isGuest || !User::find()->where(['id' => Yii::$app->user->id, 'isAdmin' =>1 /*User::ROLE_ADMIN*/])->exists())
            throw new ForbiddenHttpException('You don\'t have access to this page. Please login or go to the main page');
    }
}