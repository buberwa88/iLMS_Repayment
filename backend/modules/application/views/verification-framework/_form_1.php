<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFramework */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-framework-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'verification_framework_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verification_framework_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verification_framework_stage')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'confirmed_by')->textInput() ?>

    <?= $form->field($model, 'confirmed_at')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
