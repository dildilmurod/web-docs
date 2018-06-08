<?php
/**
 * Created by PhpStorm.
 * User: a_isokov
 * Date: 28.10.2016
 * Time: 16:54
 */

namespace backend\widgets\multiSelect;

use yii\web\AssetBundle;

/**
 * MultiSelectAsset
 *
 * @author Abbosxon Isoqov <abbosxon.isoqov@gmail.com>
 */
class MultiSelectAsset extends AssetBundle
{
    public $js = [
        'multiselect.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}
