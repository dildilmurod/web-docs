<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/26/17
 * Time: 14:11
 */

?>

<div class="toolBar">
    <div class="container">
        <ul class="toolBarList">
            <li class="col-md-4">
                <a href="#">
                    <img src="<?=Yii::getAlias('@web')?>/public/img/clock.png">
                    <p><?= Yii::t('app', 'Вирутальная приёмная');?></p>
                    <span><?= Yii::t('app', 'Интерактивная услуга');?></span>
                </a>
            </li>
            <li class="col-md-4">
                <a href="#">
                    <img src="<?=Yii::getAlias('@web')?>/public/img/building.png">
                    <p><?= Yii::t('app', 'Написать обращение');?></p>
                    <span><?= Yii::t('app', 'Интерактивная услуга');?></span>
                </a>
            </li>
            <li class="col-md-4">
                <a href="#">
                    <img src="<?=Yii::getAlias('@web')?>/public/img/folder.png">
                    <p><?= Yii::t('app', 'Открытые данные');?></p>
                    <span><?= Yii::t('app', 'Наборы открытых данных');?></span>
                </a>
            </li>
        </ul>
    </div>
</div>
