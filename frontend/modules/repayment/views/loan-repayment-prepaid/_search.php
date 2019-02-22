<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentPrepaidSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-prepaid-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'prepaid_id') ?>

    <?= $form->field($model, 'employer_id') ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'loan_summary_id') ?>

    <?= $form->field($model, 'monthly_amount') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'bill_number') ?>

    <?php // echo $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'receipt_number') ?>

    <?php // echo $form->field($model, 'date_bill_generated') ?>

    <?php // echo $form->field($model, 'date_control_received') ?>

    <?php // echo $form->field($model, 'receipt_date') ?>

    <?php // echo $form->field($model, 'date_receipt_received') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'cancelled_by') ?>

    <?php // echo $form->field($model, 'cancelled_at') ?>

    <?php // echo $form->field($model, 'cancel_reason') ?>

    <?php // echo $form->field($model, 'gepg_cancel_request_status') ?>

    <?php // echo $form->field($model, 'monthly_deduction_status') ?>

    <?php // echo $form->field($model, 'date_deducted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
