<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-detail-beneficiary-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'total_loan')->textInput(['value'=>number_format($total_loan,2),'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'amount_paid')->textInput(['value'=>number_format($amount_paid,2),'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'balance')->textInput(['value'=>number_format($balance,2),'readOnly'=>'readOnly']) ?>
    <?php ActiveForm::end(); ?>

</div>
