<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummarySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-summary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'loan_summary_id') ?>

    <?= $form->field($model, 'employer_id') ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
