<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundApplicationOperation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-application-operation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'refund_application_id')->textInput() ?>

    <?= $form->field($model, 'refund_internal_operational_id')->textInput() ?>

    <?= $form->field($model, 'access_role')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'refund_status_reason_setting_id')->textInput() ?>

    <?= $form->field($model, 'narration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'assignee')->textInput() ?>

    <?= $form->field($model, 'assigned_at')->textInput() ?>

    <?= $form->field($model, 'assigned_by')->textInput() ?>

    <?= $form->field($model, 'last_verified_by')->textInput() ?>

    <?= $form->field($model, 'is_current_stage')->textInput() ?>

    <?= $form->field($model, 'date_verified')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
