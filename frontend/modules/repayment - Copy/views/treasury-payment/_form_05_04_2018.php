<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="treasury-payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'control_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receipt_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_method_id')->textInput() ?>

    <?= $form->field($model, 'pay_phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_date')->textInput() ?>

    <?= $form->field($model, 'date_bill_generated')->textInput() ?>

    <?= $form->field($model, 'date_control_received')->textInput() ?>

    <?= $form->field($model, 'date_receipt_received')->textInput() ?>

    <?= $form->field($model, 'payment_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
