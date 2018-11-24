<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="treasury-payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'treasury_payment_id') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'control_number') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'receipt_number') ?>

    <?php // echo $form->field($model, 'pay_method_id') ?>

    <?php // echo $form->field($model, 'pay_phone_number') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'date_bill_generated') ?>

    <?php // echo $form->field($model, 'date_control_received') ?>

    <?php // echo $form->field($model, 'date_receipt_received') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
