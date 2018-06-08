<?php

namespace backend\controllers;

use common\models\Category;
use common\models\ImageUpload;
use common\models\Tag;
use Yii;
use common\models\Article;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */


    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find(),
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $tab = 1)
    {
        return $this->render('view', [
            'tab' => $tab,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {

            $imgName = md5(uniqid($model->file->baseName)).$model->date;
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs($model->getFolder().$imgName.'.'.$model->file->extension);

            $model->myfile = $imgName.'.'.$model->file->extension;
            $model->save(false);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function actionSetImage($id){
        $model = new ImageUpload;

        if(Yii::$app->request->isPost)
        {
            $article = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'image');

            if($article->saveImage($model->uploadFile($file, $article->image)))
            {
                return $this->redirect(['view', 'id'=>$article->id]);
            }
        }
        return $this->render('image', ['model'=>$model]);
    }



    public function actionSetCategory($id)
    {
        $article = $this->findModel($id);
        $selectedCategory = (!is_null($article->category)) ? $article->category->id : null;
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');

        if(Yii::$app->request->isPost)
        {
            $category = Yii::$app->request->post('category');
            if($article->saveCategory($category))
            {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }



        return $this->render('category',[
            'article'=>$article,
            'selectedCategory'=>$selectedCategory,
            'categories'=> $categories,
        ]);

    }

    public function actionSetTags($id){
        $article = $this->findModel($id);
        $selectedTags = $article->getSelectedTags();
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');

        if(Yii::$app->request->isPost)
        {
            $tags = Yii::$app->request->post('tags');

            $article->saveTags($tags);
                return $this->redirect(['view', 'id' => $article->id]);

        }


        return $this->render('tags', [
            'selectedTags'=>$selectedTags,
            'tags'=>$tags,
        ]);

    }

    public static function getExt($data){
        $img = $data->myfile;
        $ext = substr($img, strpos($img, '.'), strlen($img)-strpos($img, '.'));
        /* @var $data \common\models\Article*/
        if(!empty($img)) {
            if ($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png') {
                return Html::a(Html::tag('img', '', ['src' => Yii::getAlias('@web/uploads/image.png'), 'width'=>100]),"@web/uploads/{$img}");
               // return Html::a("<i class=\"fa fa-file-image-o\"></i> " . 'Скачать', "@web/uploads/{$img}", $options = ['class' => 'btn btn-default']);
            } elseif ($ext == '.doc' || $ext == '.docx' || $ext == '.txt') {
                return Html::a(Html::tag('img', '', ['src' => Yii::getAlias('@web/uploads/word.png'), 'width'=>100]),"@web/uploads/{$img}");
            } elseif ($ext == '.pdf') {
                return Html::a(Html::tag('img', '', ['src' => Yii::getAlias('@web/uploads/pdf.png'), 'width'=>100]),"@web/uploads/{$img}");
            } elseif ($ext == '.xls' || $ext == '.xlsx' || $ext == '.xlsm' || $ext == '.xlsb') {
                return Html::a(Html::tag('img', '', ['src' => Yii::getAlias('@web/uploads/excel.png'), 'width'=>100]),"@web/uploads/{$img}");
            } elseif ($ext == '.ppt' || $ext == '.pptx' || $ext == '.ppts') {
                return Html::a(Html::tag('img', '', ['src' => Yii::getAlias('@web/uploads/powerpoint.png'), 'width'=>100]),"@web/uploads/{$img}");
            } elseif ($ext == '.zip' || $ext == '.rar' || $ext == '.gzip' || $ext == '.7z') {
                return Html::a(Html::tag('img', '', ['src' => Yii::getAlias('@web/uploads/zip.png'), 'width'=>100]),"@web/uploads/{$img}");
            } else
                return Html::a('Скачать', "@web/uploads/{$img}", $options = ['class' => 'btn btn-default']);
        }
        return 'Нет файла';
    }
}
