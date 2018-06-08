<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use common\rbac\models\Role;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $full_name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Menu[] $menus
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
	const STATUS_ACTIVE = 10;
	public $item_name;
	public $password;
	
	/**
     * @param boolean $insert whether this method called while inserting a record.
     * If false, it means the method is called while updating a record.
     * @return boolean whether the insertion or updating should continue.
     * If false, the insertion or updating will be cancelled.     *
     */
    public function beforeSave($insert)
    {

        if($this->isNewRecord){
            $this->created_at = date("Y.m.d H:i:s");            
        }

        $this->updated_at = date("Y.m.d H:i:s");
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'email', 'status'], 'required'],
            [['username','full_name'], 'string', 'min' => 2, 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
			// password field is required on 'create' scenario
            ['password', 'required', 'on' => 'create'],
			
        ];
    }
	
	
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
	
	/**
     * Relation with Role model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        // User has_one Role via Role.user_id -> id
        return $this->hasOne(Role::className(), ['user_id' => 'id']);
    }


    /**
     * @return array
     */
    public function getRoleNames()
    {
        return ArrayHelper::getColumn($this->roles,'item_name');
    }

    /**
     * @return array
     */
    public function getAllRoles()
    {
        $roles = $this->roles;
        foreach ($this->roles as $role)
        {
            $roles = ArrayHelper::merge($role->children,$roles);
        }
        return $roles;
    }
	
	/**
     * Returns the user status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status ;

        if ($status === self::STATUS_DELETED)
        {
            return "Deleted";
        }
        elseif ($status === self::STATUS_NOT_ACTIVE)
        {
            return "Inactive";
        }
        else
        {
            return "Active";
        }
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_ACTIVE     => 'Active',
            self::STATUS_NOT_ACTIVE => 'Inactive',
            self::STATUS_DELETED    => 'Deleted'
        ];

        return $statusArray;
    }

    /**
     * Returns the role name ( item_name )
     *
     * @return string
     */
    public function getRoleName()
    {
        if(!isset($this->role->item_name))
            return false;
        return $this->role->item_name;
    }
	
	/**
     * Relation with Role models.
     *
     * @return \yii\db\ActiveQuery[]
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['user_id' => 'id']);
    }

    /**
     * @param array $roles
     * @param null|integer $user_id
     */
    public function removeRoles($roles = [],$exceptionRoles = [], $user_id = null)
    {
        if(!empty($user_id))
            $condition = " user_id = ".$user_id;
        else
            $condition = " user_id = ".$this->id;

        if(!empty($roles) && is_array($roles))
            $condition .= " AND item_name IN ('".implode("','",$roles)."')";

        if(!empty($exceptionRoles) && is_array($exceptionRoles))
            $condition .= " AND item_name NOT IN ('".implode("','",$exceptionRoles)."')";

        Role::deleteAll($condition);
    }

    /**
     * Relation with Role models.
     *
     * @return \yii\db\ActiveQuery[]
     */
    public function getMenuLinks()
    {
        return $this->hasMany(UserMenus::className(), ['user_id' => 'id']);
    }

    /**
     * Relation with Role models.
     *
     * @return \yii\db\ActiveQuery[]
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id' => 'menu_id'])->via('menuLinks');
    }

}
