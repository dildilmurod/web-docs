<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 10:43
 */


use yii\widgets\Menu;

/* @var $items Menu*/

echo \adminlte\widgets\Menu::widget([
        'options' => ['class' => 'sidebar-menu'],
        'items' => $items,/*[
            ['label' => 'Menu', 'options' => ['class' => 'header']],
            ['label' => 'Dashboard', 'icon' => 'fa fa-dashboard',
                'url' => ['/'], 'active' => $this->context->route == 'site/index'
            ],
            [
                'label' => 'Users',
                'icon' => 'fa fa-users',
                'url' => '/admin',
                'items' => [
                    [
                        'label' => 'Регистрация нового пользователя',
                        'icon' => 'fa fa-users',
                        'url' => '/admin/user/signup',
                        'active' => $this->context->route == 'master1/index'
                    ],
                ]
            ],
            ['label' => 'Article', 'icon' => 'fa fa-file-code-o', 'url' => ['/article/index'],],
            ['label' => 'Category', 'icon' => 'fa fa-dashboard', 'url' => ['/category/index'],],
            ['label' => 'Menu', 'icon' => 'fa fa-file-code-o', 'url' => ['/menu/index'],],
            ['label' => 'Pages', 'icon' => 'fa fa-dashboard', 'url' => ['/category/index'],],
        ],*/
    ]
);


//echo Menu::widget([
//    'items' => $items,
//    //'submenuTemplate' => "\n<ul class='dropdown-menu'>\n{items}\n</ul>\n",
//    'options' => [
//        /*'class' => 'menu',*/
//    ]
//]);



