<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'loan_repayment_detail_id') ?>

    <?= $form->field($model, 'loan_repayment_id') ?>

    <?= $form->field($model, 'applicant_id') ?>

    <?= $form->field($model, 'loan_repayment_item_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'loan_summary_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
