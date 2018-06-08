<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 14:40
 */

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => ''
    ],
    'layout' => "{items}\n{pager}",
    'showHeader' => 'true',
    'tableOptions' => [
        'class' => ''
    ],
    'columns' => [
        [
            'format' => 'raw',
            'value' => function ($data){
              return '
                <p class="listTitle"><a href="'.Yii::$app->getUrlManager()->createUrl(['article/view', 'id' => $data->id]).'">'.$data->title.'</a></p>
                    <p class="listText" style="font-size: 14px;">'.$data->content.'</p>
                    <p class="date" style="font-size: 14px;">'.$data->date.'</p>
              ';
            },
        ],
    ],
]);