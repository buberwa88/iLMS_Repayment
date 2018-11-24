<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgReceipt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-receipt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'response_message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'retrieved')->textInput() ?>

    <?= $form->field($model, 'trans_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_ref_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_amount')->textInput() ?>

    <?= $form->field($model, 'paid_amount')->textInput() ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trans_date')->textInput() ?>

    <?= $form->field($model, 'payer_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receipt_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reconciliation_status')->textInput() ?>

    <?= $form->field($model, 'amount_diff')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recon_master_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
