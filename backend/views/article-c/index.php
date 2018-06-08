<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 16:16
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
//    'options' => [
//        'class' => ''
//    ],
    'layout' => "{items}\n{pager}",
    'showHeader' => 'true',
//    'tableOptions' => [
//        'class' => ''
//    ],
//    'rowOptions' => [
//        'class' => 'col-md-12'
//    ],
    'columns' => [
        [
            'format' => 'raw',
            'value' => function ($data) {

                return "                   
                    <a href='" . Url::to(['article-c/view', 'id' => $data->id]) . "'>
                            <h3>" . $data->title . "</h3>                            
                    </a>
                            <p>" . $data->description . "</p>
                            <span class='date'>" . $data->date . "</span>    
                                          
                ";
            },
        ],
        [
            'format' => 'html',
            'value' => function ($data) {

                return \backend\controllers\ArticleController::getExt($data);
            },
        ],

        ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}',],
    ],
]); ?>





















