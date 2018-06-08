<?php use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'label',
        'category_id',
        'link',
        'order',
        'parent_id',
        'has_child',
    ],
]) ?>