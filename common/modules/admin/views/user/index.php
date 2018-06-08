<?php
use common\helpers\CssHelper;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>

    <?= Html::encode($this->title) ?>

    <span class="pull-right">
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </span>         

    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'email:email',
            [
                'attribute'=>'full_name',
                'filter' =>Html::textInput('UserSearch[first_name]',Yii::$app->request->get('UserSearch',['first_name'=>null])['first_name'],['class'=>'form-control']),
            ],
            
            // status
            [
                'attribute'=>'status',
                'header'=>'Статус',
                'filter' => $searchModel->statusList,
                'value' => function ($data) {
                    return $data->statusName;
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::statusCss($model->statusName)];
                }
            ],
            // role
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
                'attribute'=>'created_at',
                'filter' =>Html::textInput('UserSearch[created_at]',Yii::$app->request->get('UserSearch',['created_at'=>null])['created_at'],['class'=>'form-control']),
                'value'=>function($model)
                {
                  return date('Y-m-d H:i:s',$model->created_at);
                }
            ],
            [
                'attribute'=>'updated_at',
                'filter' => Html::textInput('UserSearch[updated_at]',Yii::$app->request->get('UserSearch',['updated_at'=>null])['updated_at'],['class'=>'form-control']),
                'value'=>function($model)
                {
                    return date('Y-m-d H:i:s',$model->updated_at);
                }
            ],
            // buttons
            ['class' => 'yii\grid\ActionColumn',
            'header' => "Menu",
            'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>'View user', 
                            'class'=>'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>'Manage user', 
                            'class'=>'glyphicon glyphicon-user']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', $url, 
                        ['title'=>'Delete user', 
                            'class'=>'glyphicon glyphicon-trash',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this user?',
                                'method' => 'post']
                        ]);
                    }
                ]
            ], // ActionColumn
        ], // columns
    ]); ?>

</div>
