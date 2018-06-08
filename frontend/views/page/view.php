<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/26/17
 * Time: 18:56
 */

/* @var $this \yii\web\View */
/* @var $model \common\models\Pages*/

use yii\helpers\Html;

$this->title = $model->title;

echo Html::tag('p', $model->title, ['class' => 'title']);

echo Html::tag('p', $model->date);

echo Html::tag('p', $model->content);