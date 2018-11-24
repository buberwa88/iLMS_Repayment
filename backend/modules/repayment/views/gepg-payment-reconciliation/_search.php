<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgPaymentReconciliationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-payment-reconciliation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'trans_id') ?>

    <?= $form->field($model, 'trans_date') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'receipt_number') ?>

    <?php // echo $form->field($model, 'paid_amount') ?>

    <?php // echo $form->field($model, 'payment_channel') ?>

    <?php // echo $form->field($model, 'account_number') ?>

    <?php // echo $form->field($model, 'Remarks') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
