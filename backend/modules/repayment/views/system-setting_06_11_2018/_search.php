<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'system_setting_id') ?>

    <?= $form->field($model, 'academic_year_id') ?>

    <?= $form->field($model, 'currency_id') ?>

    <?= $form->field($model, 'waiting_days_for_uncollected_disbursement_return') ?>

    <?= $form->field($model, 'application_open_date') ?>

    <?php // echo $form->field($model, 'application_close_date') ?>

    <?php // echo $form->field($model, 'minimum_loanable_amount') ?>

    <?php // echo $form->field($model, 'loan_repayment_grace_period_days') ?>

    <?php // echo $form->field($model, 'employee_monthly_loan_repayment_percent') ?>

    <?php // echo $form->field($model, 'self_employed_monthly_loan_repayment_amount') ?>

    <?php // echo $form->field($model, 'previous_loan_repayment_for_new_loan') ?>

    <?php // echo $form->field($model, 'total_budget') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
