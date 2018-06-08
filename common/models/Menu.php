<?php

namespace common\models;

use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $label
 * @property string $link
 * @property integer $order
 * @property integer $parent_id
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }



    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'order'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'parent_id', 'category_id', 'has_child'], 'integer'],
            [['label', 'link'], 'string', 'max' => 255],
            //[['link'], 'default', 'value' => 'article/index?type='],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
            'category_id' => Yii::t('app', 'Category ID'),
            'link' => Yii::t('app', 'Link'),
            'order' => Yii::t('app', 'Order'),
            'parent_id' => Yii::t('app', 'Parent ID'),

        ];
    }

    public function beforeSave($insert)
    {
        if(!empty($this->category_id)) {
            $this->link = URL::to(['/article-c/index', 'type' => $this->category_id]);
            return parent::beforeSave($insert);
        }
        else{
            return 1;
        }

    }

    public static function fetchData()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'label');
    }

    public static function fetchCategory()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'title');
    }

    public function getMenuLangsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->hasMany(MenuLang::className(), ['menu_id' => 'id']),
        ]);
    }

    public function getMenuLangs()
    {
        return $this->hasMany(MenuLang::className(), ['menu_id'=>'id']);

    }


    public function getLang($lang)
    {
        if ($lang == 'ru')
            return false;

        /* @var $data MenuLang*/
        $data = $this->getMenuLangs()->andWhere(['lang' => Yii::$app->language])->one();
        if ($data) {
            $this->label = $data->label;

            return true;
        }

        return false;
    }
}
