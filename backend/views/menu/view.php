<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>



    <?php
    /* @var $tab MenuController*/
    $tabs = [
        [
            'content' => $this->render('_view', ['model' => $model]),
            'label' => 'Main',
            'active' => $tab == 1
        ],
//        [
//            'content' => $this->render('/menu-lang/index', [
//                'menuId' => $model->id,
//                'dataProvider' => $model->getMenuLangsDataProvider()
//            ]),
//            'label' => 'Файлы меню',
//            'active' => $tab == 2
//        ],


    ];
    echo \yii\bootstrap\Tabs::widget([
        'items' => $tabs
    ]);?>



</div>


