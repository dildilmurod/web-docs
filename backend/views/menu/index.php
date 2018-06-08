<?php

use kartik\sortable\Sortable;
use yii\helpers\Html;
use yii\grid\GridView;
use himiklab\sortablegrid\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить меню'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= SortableGridView::widget([
    'dataProvider' => $dataProvider,
    'sortableAction' => Url::to(['sort']),//['/bannersuper/sort'],
    'columns' => [
    [
    'class' => 'yii\grid\SerialColumn',
    'contentOptions' => ['class' => 'sortable-handle'],
    ],
            'id',
            'label',
           // 'link',
            'category_id',
            'order',
            'parent_id',
//    [
//    'attribute' => 'sName',
//    ],
        ['class' => 'yii\grid\ActionColumn'],
    ]
    ]); ?>

    <?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'label',
//            'link',
//            'order',
//            'parent_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */?>

</div>
