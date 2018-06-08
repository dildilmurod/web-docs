<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class PublicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        "public/css/bootstrap-grid/bootstrap-grid.css",
        "public/css/fontawesome/font-awesome.min.css",
        "public/css/owl-carousel/owl.carousel.min.css",
        "public/css/owl-carousel/owl.theme.default.min.css",
        "public/css/style.css",
        "public/css/media.css",
    ];
    public $js = [
        "public/js/jquery-3.2.1.min.js",
        "public/js/owl.carousel.min.js",
        "public/js/common.js",
    ];
    public $jsOptions =[
        'position' =>View::POS_HEAD
    ];
    public $cssOptions =[
        'position' =>View::POS_END
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}



