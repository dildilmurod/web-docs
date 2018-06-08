<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/26/17
 * Time: 16:39
 */
namespace frontend\widgets;

use common\models\Article;
use yii\base\Widget;

class Articles extends Widget
{
    public function run()
    {

        $model = Article::find()->where(['category_id' => 2])->orderBy('date desc')->limit(6)->all();
        return $this->render('articlesView', [
            'model' => $model,
        ]);
    }
}

