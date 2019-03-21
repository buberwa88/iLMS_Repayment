<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="refund-paylist-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'refund_paylist_details_id') ?>

    <?= $form->field($model, 'refund_paylist_id') ?>

    <?= $form->field($model, 'refund_application_reference_number') ?>

    <?= $form->field($model, 'refund_claimant_id') ?>

    <?= $form->field($model, 'refund_application_id') ?>

    <?php // echo $form->field($model, 'claimant_f4indexno') ?>

    <?php // echo $form->field($model, 'claimant_name') ?>

    <?php // echo $form->field($model, 'refund_claimant_amount') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'email_address') ?>

    <?php // echo $form->field($model, 'academic_year_id') ?>

    <?php // echo $form->field($model, 'financial_year_id') ?>

    <?php // echo $form->field($model, 'payment_bank_account_name') ?>

    <?php // echo $form->field($model, 'payment_bank_account_number') ?>

    <?php // echo $form->field($model, 'payment_bank_name') ?>

    <?php // echo $form->field($model, 'payment_bank_branch') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
