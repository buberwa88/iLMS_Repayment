<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgPaymentReconciliation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-payment-reconciliation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'trans_id')->textInput() ?>

    <?= $form->field($model, 'trans_date')->textInput() ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receipt_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paid_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_channel')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
