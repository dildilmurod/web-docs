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
    'options' => [
        'class' => ''
    ],
    'layout' => "{items}\n{pager}",
    'showHeader' => 'true',
    'tableOptions' => [
        'class' => ''
    ],
    'rowOptions' => [
        'class' => 'col-md-12'
    ],
    'columns' => [
        [
            'format' => 'raw',
            'value' => function ($data) {
                $img = '';
                if (file_exists(Yii::getAlias('@frontend/web/uploads/{$article->image}')) && !is_null($data->image))
                    $img = "<div class='big-image'>" . \yii\helpers\Html::tag('img', '', ['src' => Yii::getAlias("@web/uploads/{$data->image}")]) . " </div>";


                return "
<div class=\"news-main\">
                    <div class='sliding-color'></div>
                    <a href='" . Url::to(['article/view', 'id' => $data->id]) . "'>
                        $img                
                    </a>
                    
                    <a href='" . Url::to(['article/view', 'id' => $data->id]) . "'>
                        <div class='content-big'>
                            <h2>" . $data->title . "</h2>
                            <p>" . $data->description . "</p>
                            </div>
                    </a>
                    <div class='particular'>
                        <div class='views-date'>
                            <span class='date'>" . $data->date . "</span>
                        </div>
                    </div>
                    </div>
                ";
            },
        ]

    ],
]); ?>





















