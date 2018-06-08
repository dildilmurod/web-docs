<?php

namespace common\modules\admin\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $parent
 * @property string $roles
 * @property string $name
 * @property string $route
 * @property string $link
 * @property string $data
 * @property string $image
 * @property integer $order
 * @property integer $enabled
 */
class Menu extends \yii\db\ActiveRecord
{

    public $parent_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent'], 'filterParent'],
            [['parent'], 'in',
                'range' => static::find()->select(['id'])->column(),
                'message' => 'Menu "{value}" not found.'],
            [[ 'route', 'data', 'order','roles'], 'default'],
            [['route'], 'in', 'range' => static::getSavedRoutes(), 'message' => 'Route "{value}" not found.'],
            [['parent', 'order', 'enabled'], 'integer'],
            [['name', 'route', 'link', 'data'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 50],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => Yii::t('rbac-admin','Parent'),
            'name' =>Yii::t('rbac-admin', 'Name'),
            'route' => Yii::t('rbac-admin','Route'),
            'link' =>Yii::t('rbac-admin', 'Link'),
            'data' =>Yii::t('rbac-admin', 'Data'),
            'image' => Yii::t('rbac-admin','Image'),
            'order' => Yii::t('rbac-admin','Order'),
            'enabled' => Yii::t('rbac-admin','Enabled'),
        ];
    }

    /**
     * Get menu parent
     * @return \yii\db\ActiveQuery
     */
    public function getMenuParent()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent']);
    }

    /**
     * Get menu children
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parent' => 'id']);
    }

    /**
     * Get saved routes.
     * @return array
     */
    public static function getSavedRoutes()
    {
        $result = [];
        foreach (Yii::$app->getAuthManager()->getPermissions() as $name => $value) {
            if ($name[0] === '/' && substr($name, -1) != '*') {
                $result[$name] = $name;
            }
        }

        return $result;
    }

    /**
     * Use to loop detected.
     */
    public function filterParent()
    {
        $value = $this->parent;
        $parent = self::findOne($value);
        if ($parent) {
            $id = $this->id;
            $parent_id = $parent->id;
            while ($parent) {
                if ($parent->id == $id) {
                    $this->addError('parent', 'Привязка к меню невозможно');

                    return;
                }
                $parent = $parent->menuParent;
            }
            $this->parent = $parent_id;
        }
    }

}
