<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\User;
use yii\helpers\Html;
//use app\assets\AppAsset;
use backend\assets\AdminLteAsset;

//AppAsset::register($this);
$asset      = AdminLteAsset::register($this);
$baseUrl    = $asset->baseUrl;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
    <?= $this->render('header.php', ['baserUrl' => $baseUrl, 'title'=>Yii::$app->name]) ?>
    <?php if(!Yii::$app->user->isGuest): ?>
    <?= $this->render('leftside.php', ['baserUrl' => $baseUrl]) ?>
    <?php endif; ?>
    <?php if(!Yii::$app->user->isGuest && User::find()->where(['id' => Yii::$app->user->id, 'isAdmin' =>1 /*User::ROLE_ADMIN*/])->exists()): ?>
    <?= $this->render('leftadmin.php', ['baserUrl' => $baseUrl]) ?>
    <?php endif; ?>
    <?= $this->render('content.php', ['content' => $content]) ?>
    <?= $this->render('footer.php', ['baserUrl' => $baseUrl]) ?>
    <?= $this->render('rightside.php', ['baserUrl' => $baseUrl]) ?>

</div>

<!--footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?//= date('Y') ?></p>

        <p class="pull-right"><?//= Yii::powered() ?></p>
    </div>
</footer-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
