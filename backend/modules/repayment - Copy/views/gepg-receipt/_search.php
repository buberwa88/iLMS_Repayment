<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgReceiptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gepg-receipt-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'response_message') ?>

    <?= $form->field($model, 'retrieved') ?>

    <?= $form->field($model, 'trans_id') ?>

    <?php // echo $form->field($model, 'payer_ref_id') ?>

    <?php // echo $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'bill_amount') ?>

    <?php // echo $form->field($model, 'paid_amount') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'trans_date') ?>

    <?php // echo $form->field($model, 'payer_phone') ?>

    <?php // echo $form->field($model, 'payer_name') ?>

    <?php // echo $form->field($model, 'receipt_number') ?>

    <?php // echo $form->field($model, 'account_number') ?>

    <?php // echo $form->field($model, 'reconciliation_status') ?>

    <?php // echo $form->field($model, 'amount_diff') ?>

    <?php // echo $form->field($model, 'recon_master_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
