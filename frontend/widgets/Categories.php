<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2/25/2018
 * Time: 3:31 PM
 */

namespace frontend\widgets;

use common\models\Article;
use common\models\Category;
use yii\base\Widget;

class Categories extends Widget
{
    public function run()
    {
        $model = Category::find()->orderBy('id asc')->all();
        return $this->render('categoryView', [
            'model' => $model,
        ]);
    }
}