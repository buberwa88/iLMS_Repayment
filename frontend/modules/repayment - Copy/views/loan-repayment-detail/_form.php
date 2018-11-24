<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \backend\modules\repayment\models\EmployedBeneficiary;
/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetail */
/* @var $form yii\widgets\ActiveForm */
$outstandingDebt=number_format(\backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($model->applicant_id,$model->loan_summary_id),2);
$amountRequiredForPayment=$model->getAmountRequiredForPaymentIndividualLoanee($model->applicant_id,$model->loan_repayment_id);
$amountRequiredForPaymentq=$model->getAmountRequiredTobepaidPermonth($model->applicant_id,$model->loan_summary_id);
?>

<div class="loan-repayment-detail-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'applicant_id')->label(false)->hiddenInput(['readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'loan_summary_id')->label(false)->hiddenInput(['readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'loan_repayment_id')->label(false)->hiddenInput(['readOnly'=>'readOnly']) ?>	
	<?= $form->field($model, 'outstandingDebt')->label('Outstanding Debt')->textInput(['value'=>$outstandingDebt,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amount1')->label(false)->hiddenInput(['value'=>$amountRequiredForPaymentq,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amountx1')->label(false)->hiddenInput(['value'=>$amountRequiredForPayment,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amount')->label('Pay Amount')->textInput(['value'=>$amountRequiredForPayment]) ?>
	
    <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['view-loaneeinbill-payment','id'=>$model->loan_repayment_id], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>
	</div>
