<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 10:42
 */

namespace backend\widgets;

use Yii;
use yii\bootstrap\Widget;
use common\models\Menu as MenuModel;
use yii\web\User;

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
        $model = MenuModel::find()
            ->orderBy(['order' => SORT_ASC])
            ->where(['parent_id' => $parentId])
            ->all();

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
          SELECT DISTINCT user_menus.menu_id FROM user 
          join user_menus on user_menus.user_id = ".Yii::$app->user->identity->getId()."
          join menu on user_menus.menu_id = menu.id");
        $result = $command->queryAll();

        foreach ($model as $item) {
            /* @var $item MenuModel */
            $item->getLang(Yii::$app->language);
            if (in_array($item->id, $this->fetchQuery($result))) {
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
        }

        return $items;
    }

    private function fetchQuery($res){
        $all = [];
        foreach ($res as $result) {
            /* @var $item MenuModel */
            array_push($all, $result['menu_id']);
        }
        return $all;
    }
}