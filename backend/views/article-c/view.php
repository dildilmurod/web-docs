<?php
/* @var $article  \common\models\Article*/
use yii\helpers\Html;

?>
            <div class="one">
             <?php
            $article->getLang(Yii::$app->language);

            ?>
                <div>
                    <p class="title"><?= $article->title?></p>
                    <p class="oneText"><?= $article->content?></p>
                    <p class="date"><?= $article->date?></p><!--Yii::getAlias("@web/uploads/{$article->image}")-->
                    <p><?=\frontend\controllers\ArticleController::getExt($article)?></p>
                    <?php //=\yii\helpers\Html::tag('a', 'Скачать файл', ['href' => Yii::getAlias("@web/uploads/{$article->image}")])?>
                </div>

            </div>

        <div class="clearfix"></div>

        <div class="marger"></div>

