<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 10:42
 */

namespace frontend\widgets;

use Yii;
use yii\bootstrap\Widget;
use common\models\Menu as MenuModel;

class Menu extends Widget
{
    private $hasParents = true;

    public function run()
    {
        $items = $this->collectMenuItem();

        return $this->render('menuView', [
            'items' => $items,
        ]);
    }

    private function collectMenuItem($parentId = null)
    {
        $items = [];
        $model = MenuModel::find()->orderBy(['order' => SORT_ASC])->where(['parent_id' => $parentId])->all();


        foreach ($model as $item) {
            /* @var $item MenuModel */
            $item->getLang(Yii::$app->language);

            $items[] = [
                'label' => $item->label,
                'url' => [$item->link],
                'items' => $this->collectMenuItem($item->id),
                'options' => [
//                    'class' =>
//                        'header',
                ]
            ];
        }



        return $items;

    }
}