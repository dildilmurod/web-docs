<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 14:25
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \common\models\ArticleSearch*/


echo '<div class="searchContent relative">';
$form = ActiveForm::begin([
    'action' => ['site/search'],
    'method' => 'get',
]);

echo $form->field($model, 'title')->textInput([
    'placeholder' => 'Поиск по сайту...',
    'class' => 'searchBox',
])->label(false);

echo Html::submitButton('<i class="glyphicon glyphicon-search"></i>', [
    'class' => 'searchBtn'
]);

ActiveForm::end();
echo '</div>';