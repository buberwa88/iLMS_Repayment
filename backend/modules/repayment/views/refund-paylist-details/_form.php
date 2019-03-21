<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-paylist-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'refund_paylist_id')->textInput() ?>

    <?= $form->field($model, 'refund_application_reference_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_claimant_id')->textInput() ?>

    <?= $form->field($model, 'refund_application_id')->textInput() ?>

    <?= $form->field($model, 'claimant_f4indexno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'claimant_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_claimant_amount')->textInput() ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'academic_year_id')->textInput() ?>

    <?= $form->field($model, 'financial_year_id')->textInput() ?>

    <?= $form->field($model, 'payment_bank_account_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_bank_account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
