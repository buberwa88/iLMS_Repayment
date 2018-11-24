<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'loan_repayment_id') ?>

    <?= $form->field($model, 'employer_id') ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'repayment_reference_number') ?>

    <?= $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'receipt_number') ?>

    <?php // echo $form->field($model, 'pay_method_id') ?>

    <?php // echo $form->field($model, 'pay_phone_number') ?>

    <?php // echo $form->field($model, 'date_bill_generated') ?>

    <?php // echo $form->field($model, 'date_control_received') ?>

    <?php // echo $form->field($model, 'date_receipt_received') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
