<?php
use backend\widgets\multiSelect\MultiSelect;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View
 * @var $model common\models\User
 * @var $link common\models\UserAuthoritiesLink
 * @var $authorities common\models\MyAuthority[]
 * @var $userAuthorities common\models\MyAuthority[]
 */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Ползователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?>

    <div class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this user?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'id'                      ,            
            'username'                ,
            'full_name'                ,
            'email:email'             ,            
            [
                'attribute'=>'status',
                'value' => $model->getStatusName(),
            ],
            [
                'attribute'=>'item_name',
                'value' => $model->getRoleName(),
            ],
			'created_at:date'         ,
            'updated_at:date'         ,
        ],
    ]);
    $this->registerJsFile('/backend/js/multiselect.js');
    ?>

    <?= MultiSelect::widget([
        'widgetNumber' => 1,
        'multiSelectJsPath' => '/js/multiselect.js',
        'valueAttribute' => 'label',
        'keyAttribute' => 'id',
        'leftLabel' => Yii::t('app','Қолган хизматлар'),
        'rightLabel' => Yii::t('app','Рухсат этилган хизматлар'),
        'data'=>\common\models\Menu::find()->where(
            'has_child = 0 AND id NOT IN (SELECT menu_id FROM user_menus WHERE user_id = :userId)',
            ['userId' => $model->id])->all(),
        'selectedData'=>$model->menus,
        'addDataUrl'=>Url::to(['/admin/user/add-menu', 'id' => $model->id]),
        'removeDataUrl'=>Url::to(['/admin/user/remove-menu', 'id' => $model->id]),
        'leftButtonOptions' => ['class'=>'btn-primary'],
        'leftAllButtonOptions' => ['class'=>'btn-primary'],
        'rightButtonOptions' => ['class'=>'btn-primary'],
        'rightAllButtonOptions' => ['class'=>'btn-primary'],
        'listBoxSize' => 25
    ]);?>
</div>


