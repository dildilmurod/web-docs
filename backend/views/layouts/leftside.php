<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
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
        <?=

//        $menuItems = [
//
//            ['label' => 'Tag', 'url' => ['/tag/index']],
//            ['label' => 'Menu', 'url' => ['/menu/index']],
//            ['label' => 'Pages', 'url' => ['/pages/index']],
//
//
//        ];
        Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        ['label' => 'Меню', 'options' => ['class' => 'header']],
                        ['label' => 'Главная', 'icon' => 'fa fa-dashboard',
                            'url' => ['/'], 'active' => $this->context->route == 'site/index'
                        ],
                        ['label' => 'Добавление и удаление файлов', 'icon' => 'fa fa-file-code-o', 'url' => ['/article/index'],],
                    ],
                ]
        )
        ?>
        <?= \backend\widgets\Menu::widget();
        ?>


    </section>
    <!-- /.sidebar -->
</aside>
