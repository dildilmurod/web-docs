<?php
use yii\widgets\DetailView;


echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'title',
        //'description:ntext',
        //'content:ntext',
        'date',
        //'image',
        'myfile',
        //'user_id',
        //'status',
        'category_id',
    ],
]); ?>
