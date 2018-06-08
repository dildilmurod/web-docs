<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\ArticleLang;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property integer $user_id
 * @property integer $status
 * @property integer $category_id
 *
 * @property ArticleLang[] $articleLangs
 * @property ArticleTag[] $articleTags
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;

    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['description'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['file'], 'file', 'extensions'=> 'jpg, png, gif, jpeg, pdf, doc, docx, txt, ppt, pps, pptx, xls, xlsx, zip, rar, xml'],
            [['title'], 'string', 'max' => 100],
            [['myfile'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 150]
        ];
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'date' => Yii::t('app', 'Date'),
            'image' => Yii::t('app', 'Image'),
            'user_id' => Yii::t('app', 'User ID'),
            'status' => Yii::t('app', 'Status'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function getImage()
    {
        if ($this->image) {
            return '/uploads/' . $this->image;
        }
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);

        if ($category != null) {
            $this->link('category', $category);
            return true;
        }
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function  getSelectedTags()
    {
        $selectedTags = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedTags, 'id');

    }

    public function saveTags($tags)
    {

        if (is_array($tags)) {
            ArticleTag::deleteAll(['article_id' => $this->id]);
            foreach ($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleLangs()
    {
        return $this->hasMany(ArticleLang::className(), ['article_id' => 'id']);

    }

    public function getArticleLangsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->hasMany(ArticleLang::className(), ['article_id' => 'id']),
        ]);
    }


    /**
     * @return array|null|ArticleLang
     */
    public function getLangData($column)
    {
        $data = $this->getArticleLangs()->andWhere(['lang' => Yii::$app->language])->one();
        if ($data) {
            return $data->$column;
        }
        return $this->$column;
    }

    public function getLang($lang)
    {
        if ($lang == 'ru')
            return false;

        /* @var $data ArticleLang*/
        $data = $this->getArticleLangs()->andWhere(['lang' => Yii::$app->language])->one();
        if ($data) {
            $this->title = $data->title;
            $this->description = $data->description;

            return true;
        }

        return false;
    }

    public function getFolder(){

        return Yii::getAlias('@backend').'/web/uploads/';
    }

}
