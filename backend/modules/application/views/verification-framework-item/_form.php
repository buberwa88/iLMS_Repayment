<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationFrameworkItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-framework-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'verification_framework_id')->textInput() ?>

    <?= $form->field($model, 'attachment_definition_id')->textInput() ?>

    <?= $form->field($model, 'attachment_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verification_prompt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
