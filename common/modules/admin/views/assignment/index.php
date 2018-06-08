<?php

use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\modules\admin\models\searchs\Assignment */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php
    Pjax::begin([
        'enablePushState'=>false,
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => $usernameField,
            ],
            [                
                'attribute' => 'full_name',
            ],            
            [
                'attribute'=>'item_name',
                'filter' => $searchModel->rolesList,
                'header'=>'Роль',
                'value' => function ($data) {
                    return $data->roleName;
                },
                'contentOptions'=>function($model, $key, $index, $column) {

                    return ['class'=>CssHelper::roleCss($model->roleName)];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}'
            ],
        ],
    ]);
    Pjax::end();
    ?>

</div>
