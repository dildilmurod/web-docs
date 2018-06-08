<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/26/17
 * Time: 16:35
 */
use yii\helpers\Url;

?>

<aside>
    <div class="a-aside">
        <div class="asideboxes">
            <div class="asidebox">
                <ul>
                    <?php foreach($model as $category):?>
                        <?php if($category->id != 6):?>
                            <a href="<?=Url::to(['article/index?type='.$category->id])?>"><li><?=$category->title?></li></a>
                        <?php endif;?>
                    <?php endforeach;?>

                </ul>
            </div>
            <div class="aside-stat">
                <div class="banner">
                    <a href="#"><img src="public/img/timeline.jpg" alt="banner"></a>
                </div>
            </div>
        </div>
    </div>
</aside>