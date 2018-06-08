<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Set Category'), ['set-category', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?php //Html::a(Yii::t('app', 'Set Tags'), ['set-tags', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    $tabs = [
        [
            'content' => $this->render('_view', ['model' => $model]),
            'label' => 'Main data',
            'active' => $tab == 1
        ],
//        [
//            'content' => $this->render('/article-lang/index', [
//                'articleId' => $model->id,
//                'dataProvider' => $model->getArticleLangsDataProvider()
//            ]),
//            'label' => 'Languages',
//            'active' => $tab == 2
//        ],


    ];


    echo \yii\bootstrap\Tabs::widget([
        'items' => $tabs
    ]);


    ?>


</div>
