<?php
use common\rbac\models\AuthItem;
use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $role common\rbac\models\Role; */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>

<!--    --><?php //echo $form->errorSummary($user);?>
<!--    --><?php //echo $form->errorSummary($role);?>


        <?= $form->field($user, 'username') ?>        

        <?= $form->field($user, 'full_name') ?>

        <?= $form->field($user, 'email') ?>

       <?= $form->field($user, 'password')->passwordInput(['placeholder' => 'New pwd ( if you want to change it )'])
       ?>


    <div class="row">
    <div class="col-lg-6">

        <?= $form->field($user, 'status')->dropDownList($user->statusList) ?>

        <?php foreach (AuthItem::getRoles() as $item_name): ?>
            <?php $roles[$item_name->name] = $item_name->name ?>
        <?php endforeach ?>


        <? echo $form->field($role,'item_name')->widget(Select2::classname(),[
            'data' => $roles,
            'options' => [
                'multiple'=>true,
                'placeholder' => 'Выберите роль',
                'empty' => 'Выберите роль'
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
		<div class="form-group">
			<?= Html::submitButton($user->isNewRecord ? 'Create'
				: 'Редактировать', ['class' => $user->isNewRecord
				? 'btn btn-success' : 'btn btn-primary']) ?>

			<?= Html::a('Cancel', ['user/index'], ['class' => 'btn btn-default']) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>
