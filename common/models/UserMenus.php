<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "link_request_persecution".
 *
 * @property integer $user_id
 * @property integer $menu_id
 * @property string $created_at
 *
 * @property User $user
 * @property Menu $menu
 */
class UserMenus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_menus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'menu_id'], 'required'],
            [['user_id', 'menu_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id','menu_id'], 'unique', 'targetAttribute' => ['menu_id','user_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'Фойдаланувчи',
            'menu_id' => 'Меню',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
}
