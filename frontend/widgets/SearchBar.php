<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 14:24
 */

namespace frontend\widgets;


use common\models\ArticleSearch;
use yii\base\Widget;

class SearchBar extends Widget
{
    public function run()
    {
        $model = new ArticleSearch();

        return $this->render('searchBarView', [
            'model' => $model,
        ]);
    }
}