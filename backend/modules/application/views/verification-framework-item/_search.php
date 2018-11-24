<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFrameworkItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-framework-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'verification_framework_item_id') ?>

    <?= $form->field($model, 'verification_framework_id') ?>

    <?= $form->field($model, 'attachment_definition_id') ?>

    <?= $form->field($model, 'attachment_desc') ?>

    <?= $form->field($model, 'verification_prompt') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
