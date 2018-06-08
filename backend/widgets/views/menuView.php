<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 10:43
 */


use yii\widgets\Menu;

/* @var $items Menu*/

//echo "<pre>";
//print_r($items);

echo \adminlte\widgets\Menu::widget([
        'options' => ['class' => 'sidebar-menu'],
        'items' => $items,
    ]
);





