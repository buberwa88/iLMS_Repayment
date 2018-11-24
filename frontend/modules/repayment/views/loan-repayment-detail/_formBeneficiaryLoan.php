<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-detail-beneficiary-form">
    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'principal')->textInput(['value'=>number_format($principal,2),'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'penalty')->textInput(['value'=>number_format($penalty,2),'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'LAF')->textInput(['value'=>number_format($LAF,2),'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'vrf')->textInput(['value'=>number_format($vrf,2),'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'total_loan')->textInput(['value'=>number_format($total_loan,2),'readOnly'=>'readOnly']) ?>
    <?php ActiveForm::end(); ?>

</div>
