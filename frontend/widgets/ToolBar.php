<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/26/17
 * Time: 14:09
 */

namespace frontend\widgets;

use yii\base\Widget;

class ToolBar extends Widget
{
    public function run()
    {
        return $this->render('toolBarView');
    }
}