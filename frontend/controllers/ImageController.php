<?php

namespace backend\controllers;

use yii\rest\ActiveController;

class ImageController extends ActiveController
{
    public $modelClass = 'common\models\ImageUpload';
}