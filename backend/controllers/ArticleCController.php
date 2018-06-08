<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/27/17
 * Time: 15:43
 */

namespace backend\controllers;


use common\models\Article;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleCController extends Controller
{
    public function actionIndex($type)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find(),
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        try {
            $dataProvider = new ActiveDataProvider([
                'query' => Article::find()->where(['category_id' => $type])->orderBy('date desc'),
                'pagination' => [
                    'pageSize' => 4,
                ],
            ]);
        } catch (Exception $ex) {
            throw new NotFoundHttpException('Nothing found!');
        };

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionDownload(){
//
//        //$model = new Download;
//        $name	= $_GET['file'];
//        $upload_path = Yii::app()->params['uploadPath'];
//
//        if( file_exists( $upload_path.$name ) ){
//            Yii::app()->getRequest()->sendFile( $name , file_get_contents( $upload_path.$name ) );
//        }
//        else{
//            $this->render('download404');
//        }
//
//    }

    public function actionView($id){
        $article = Article::findOne($id);

        return $this->render('view', [
            'article'=> $article,
        ]);
    }
    public static function getExt($data){
        $img = $data->image;
        $ext = substr($img, strpos($img, '.'), strlen($img)-strpos($img, '.'));
        /* @var $data \common\models\Article*/
        if(!empty($img)) {
            if ($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png') {
                return Html::a("<i class=\"fa fa-file-image-o\"></i> " . 'Скачать', "http://web-docs/uploads/{$img}", $options = ['class' => 'btn btn-default']);
            } elseif ($ext == '.doc' || $ext == '.docx' || $ext == '.txt') {
                return Html::a("<i class=\" fa fa-file-word-o\"></i> " . 'Скачать', "http://web-docs/uploads/{$img}", $options = ['class' => 'btn btn-default']);
            } elseif ($ext == '.pdf') {
                return Html::a("<i class=\" fa a-file-pdf-o\"></i> " . 'Скачать', "http://web-docs/uploads/{$img}", $options = ['class' => 'btn btn-default']);
            } elseif ($ext == '.xls' || $ext == '.xlsx' || $ext == '.xlsm' || $ext == '.xlsb') {
                return Html::a("<i class=\" fa a-file-excel-o\"></i> " . 'Скачать', "http://web-docs/uploads/{$img}", $options = ['class' => 'btn btn-default']);
            } elseif ($ext == '.ppt' || $ext == '.pptx' || $ext == '.ppts') {
                return Html::a("<i class=\" fa a-file-powerpoint-o\"></i> " . 'Скачать', "http://web-docs/uploads/{$img}", $options = ['class' => 'btn btn-default']);
            } elseif ($ext == '.zip' || $ext == '.rar' || $ext == '.gzip' || $ext == '.7z') {
                return Html::a("<i class=\" fa a-file-powerpoint-o\"></i> " . 'Скачать', "http://web-docs/uploads/{$img}", $options = ['class' => 'btn btn-default']);
            } else
                return Html::a('Скачать', "http://web-docs/uploads/{$img}", $options = ['class' => 'btn btn-default']);
        }
        return 'Нет файла';
    }


}