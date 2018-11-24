<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenaltyPayment */
/* @var $form yii\widgets\ActiveForm */
$totalAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmount($employerID);
$paidAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmountPaid($employerID);
$outstandingAmount=$totalAmount-$paidAmount;
?>

<div class="employer-penalty-payment-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'totalAmount')->textInput(['value'=>number_format($totalAmount,2),'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'paidAmount')->textInput(['value'=>number_format($paidAmount,2),'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'outstandingAmount')->textInput(['value'=>number_format($outstandingAmount,2),'readOnly'=>'readOnly']) ?>
	<?php if($outstandingAmount > 0){ ?>
    <?= $form->field($model, 'amount')->textInput(['value'=>$outstandingAmount,'maxlength' => true]) ?>
	
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
