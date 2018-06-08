<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Menu as MenuModel;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= Html::img('@web/img/user2-160x160.jpg', ['class' => 'img-circle', 'alt' => 'User Image']) ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username?></p>

            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?= Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Главная', 'icon' => 'fa fa-dashboard',
                        'url' => ['/'], 'active' => $this->context->route == 'site/index'
                    ],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'fa fa-users',
                        'url' => '/admin',
                        /*'items' => [
                            [
                                'label' => 'Регистрация нового пользователя',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/user/signup',
                                'active' => $this->context->route == 'master1/index'
                            ],
                            [
                                'label' => 'Пользователи',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/user',
                                'active' => $this->context->route == 'master1/index'
                            ],
                            [
                                'label' => 'Назначение',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/assignment',
                                'active' => $this->context->route == 'master2/index'
                            ],
                            [
                                'label' => 'Роли',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/role',
                                'active' => $this->context->route == 'master2/index'
                            ],
                            [
                                'label' => 'Разрешения',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/permission',
                                'active' => $this->context->route == 'master2/index'
                            ],
                            [
                                'label' => 'Маршруты',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/route',
                                'active' => $this->context->route == 'master2/index'
                            ],
                            [
                                'label' => 'Правила',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/rule',
                                'active' => $this->context->route == 'master2/index'
                            ],
                            [
                                'label' => 'Меню',
                                'icon' => 'fa fa-users',
                                'url' => '/admin/menu',
                                'active' => $this->context->route == 'master2/index'
                            ],
                        ]*/
                    ],
                    ['label' => 'Файлы', 'icon' => 'fa fa-file-code-o', 'url' => ['/article/index'],],
                    ['label' => 'Категории', 'icon' => 'fa fa-dashboard', 'url' => ['/category/index'],],
                    ['label' => 'Меню', 'icon' => 'fa fa-file-code-o', 'url' => ['/menu/index'],],
                ],
            ]
        ) ?>
        <?= \backend\widgets\Menu::widget();
        ?>


    </section>
    <!-- /.sidebar -->
</aside>
