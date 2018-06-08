<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/26/17
 * Time: 16:40
 */
use yii\helpers\Url;

?>

<?php
$i =0;
foreach($model as $article): ?>
    <?php $article->getLang(Yii::$app->request)?>
    <?php if($i <= 1): ?>
    <div class="col-md-6">
        <div class="news-main biggest">
            <div class="sliding-color"></div>
            <a href="<?=Url::to(['article/view', 'id' => $article->id])?>">
                <div class="big-image">
                    <?php
                    if(file_exists(Yii::getAlias("@frontend/web/uploads/{$article->image}")) && !is_null($article->image))
                        echo \yii\helpers\Html::tag('img', '', ['src' => Yii::getAlias("@web/uploads/{$article->image}")])
                    ?>
                </div>
            </a>
            <a href="<?=Url::to(['article/view', 'id' => $article->id])?>">
                <div class="content-big">
                    <h2><?= $article->title?></h2>
                    <p><?= $article->description?></p>
                </div>
            </a>
            <div class="particular">
                <div class="views-date">
                    <i class="fa fa-eye"></i><span>12345</span>
                    <span class="date"><?= $article->date?></span>
                </div>
                <div class="link">
                    <a href="<?=Url::to(['article/view', 'id' => $article->id])?>">Подробнее >></a>
                </div>
            </div>
        </div>
    </div>
    <?php $i++; ?>

    <?php elseif($i>=2): ?>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="smallest">
                <div class="sliding-color"></div>
                <a href="<?=Url::to(['article/view', 'id' => $article->id])?>">
                    <div class="small-image">
                        <?php
                        if(file_exists(Yii::getAlias("@frontend/web/uploads/{$article->image}")) && !is_null($article->image))
                            echo \yii\helpers\Html::tag('img', '', ['src' => Yii::getAlias("@web/uploads/{$article->image}")])
                        ?>
                    </div>
                </a>
                <a href="<?=Url::to(['article/view', 'id' => $article->id])?>">
                    <div class="content-small">
                        <h2><?= $article->title?></h2>
                        <p><?= $article->description?></p>
                    </div>
                </a>
                <div class="particular">
                    <div class="views-date">
                        <i class="fa fa-eye"></i><span>12345</span>
                        <span class="date"><?= $article->date?></span>
                    </div>
                    <div class="link">
                        <a href="<?=Url::to(['article/view', 'id' => $article->id])?>">Подробнее >></a>
                    </div>
                </div>
            </div>
        </div>

        <?php endif;?>


<?php endforeach;?>





<!--<div class="col-md-6 col-lg-4 col-xl-3">
    <div class="smallest">
        <div class="sliding-color"></div>
        <a href="#">
            <div class="small-image">
                <img src="img/main.jpg" alt="big main image">
            </div>
        </a>
        <a href="#">
            <div class="content-small">
                <h2>Новость номер один и что то такое и много написано</h2>
                <p>Короче, если ты хочешь стать успешным человеком -
                    просто иди учись, работай, развивайся. Не хочешь?
                    В принципе я тебя не заставляю.
                    Лол, кек, азаза лолипоп, завтра приедем сюда и съедим лорем ипсум...</p>
            </div>
        </a>
        <div class="particular">
            <div class="views-date">
                <i class="fa fa-eye"></i><span>12345</span>
                <span class="date">13.02.2018</span>
            </div>
            <div class="link">
                <a href="#">Подробнее >></a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-lg-4 col-xl-3">
    <div class="smallest">
        <div class="sliding-color"></div>
        <a href="#">
            <div class="small-image">
                <img src="img/main.jpg" alt="big main image">
            </div>
        </a>
        <a href="#">
            <div class="content-small">
                <h2>Новость номер один и что то такое и много написано</h2>
                <p>Короче, если ты хочешь стать успешным человеком -
                    просто иди учись, работай, развивайся. Не хочешь?
                    В принципе я тебя не заставляю.
                    Лол, кек, азаза лолипоп, завтра приедем сюда и съедим лорем ипсум...</p>
            </div>
        </a>
        <div class="particular">
            <div class="views-date">
                <i class="fa fa-eye"></i><span>12345</span>
                <span class="date">13.02.2018</span>
            </div>
            <div class="link">
                <a href="#">Подробнее >></a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-lg-4 col-xl-3">
    <div class="smallest">
        <div class="sliding-color"></div>
        <a href="#">
            <div class="small-image">
                <img src="img/main.jpg" alt="big main image">
            </div>
        </a>
        <a href="#">
            <div class="content-small">
                <h2>Новость номер один и что то такое и много написано</h2>
                <p>Короче, если ты хочешь стать успешным человеком -
                    просто иди учись, работай, развивайся. Не хочешь?
                    В принципе я тебя не заставляю.
                    Лол, кек, азаза лолипоп, завтра приедем сюда и съедим лорем ипсум...</p>
            </div>
        </a>
        <div class="particular">
            <div class="views-date">
                <i class="fa fa-eye"></i><span>12345</span>
                <span class="date">13.02.2018</span>
            </div>
            <div class="link">
                <a href="#">Подробнее >></a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-lg-4 col-xl-3">
    <div class="smallest">
        <div class="sliding-color"></div>
        <a href="#">
            <div class="small-image">
                <img src="img/main.jpg" alt="big main image">
            </div>
        </a>
        <a href="#">
            <div class="content-small">
                <h2>Новость номер один и что то такое и много написано</h2>
                <p>Короче, если ты хочешь стать успешным человеком -
                    просто иди учись, работай, развивайся. Не хочешь?
                    В принципе я тебя не заставляю.
                    Лол, кек, азаза лолипоп, завтра приедем сюда и съедим лорем ипсум...</p>
            </div>
        </a>
        <div class="particular">
            <div class="views-date">
                <i class="fa fa-eye"></i><span>12345</span>
                <span class="date">13.02.2018</span>
            </div>
            <div class="link">
                <a href="#">Подробнее >></a>
            </div>
        </div>
    </div>
</div>
-->























