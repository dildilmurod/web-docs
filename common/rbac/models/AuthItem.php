<?php
namespace common\rbac\models;

use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string  $name
 * @property integer $type
 * @property string  $description
 * @property string  $rule_name
 * @property string  $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthItemChild  $childrenLinks
 * @property AuthItem[]     $children
 * @property Role           $assignment
 * @property Role[]         $childAssignments
 */
class AuthItem extends ActiveRecord
{
    /**
     * Declares the name of the database table associated with this AR class.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * Return roles.
     * NOTE: used for updating user role (user/update).
     *
     * @param string $condition
     * @param array $conditionParams
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRoles($condition = "",$conditionParams = [])
    {
        // we make sure that only You can see theCreator role in drop down list
        if (Yii::$app->user->can('theCreator')) 
        {
            $query = static::find()
                ->select('name')
                ->where(['type' => 1]);
        }
        // admin can not see theCreator role in drop down list
        else
        {
            $query = static::find()
                ->select('name')
                ->where(['type' => 1])
                ->andWhere(['!=', 'name', 'theCreator']);
        }

        if(!empty($condition))
            $query->andWhere($condition,$conditionParams);
        return $query->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildrenLinks()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->via('childrenLinks');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignment()
    {
        return $this->hasOne(Role::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildAssignments()
    {
        return $this->hasMany(Role::className(), ['item_name' => 'name'])->via('children');
    }


}
