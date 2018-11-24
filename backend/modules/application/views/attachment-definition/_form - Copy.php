<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\AttachmentDefinition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attachment-definition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'attachment_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_size_MB')->textInput() ?>

    <?= $form->field($model, 'require_verification')->textInput() ?>

    <?= $form->field($model, 'verification_prompt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
