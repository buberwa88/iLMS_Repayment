<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LawsonMonthlyDeductionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lawson-monthly-deduction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'lawson_monthly_deduction_id') ?>

    <?= $form->field($model, 'ActualBalanceAmount') ?>

    <?= $form->field($model, 'CheckDate') ?>

    <?= $form->field($model, 'CheckNumber') ?>

    <?= $form->field($model, 'DateHired') ?>

    <?php // echo $form->field($model, 'DeductionAmount') ?>

    <?php // echo $form->field($model, 'DeductionCode') ?>

    <?php // echo $form->field($model, 'DeductionDesc') ?>

    <?php // echo $form->field($model, 'DeptName') ?>

    <?php // echo $form->field($model, 'FirstName') ?>

    <?php // echo $form->field($model, 'LastName') ?>

    <?php // echo $form->field($model, 'MiddleName') ?>

    <?php // echo $form->field($model, 'NationalId') ?>

    <?php // echo $form->field($model, 'Sex') ?>

    <?php // echo $form->field($model, 'VoteName') ?>

    <?php // echo $form->field($model, 'Votecode') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
