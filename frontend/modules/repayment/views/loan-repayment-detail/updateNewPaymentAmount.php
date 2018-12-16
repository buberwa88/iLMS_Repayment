<script type="text/javascript">
function check_status_employedBeneficiary() {
   document.getElementById("hiddenAdjust_employedBeneficiary").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
function checkvalidation_employedBeneficiary() {
	var autstandingAmount1 = document.getElementById("outstandingAmount_id").value;
	var amount_adjusted1 = document.getElementById("amount_adjusted_id").value.trim();
	var amountApplicant1 = document.getElementById("amountApplicant_id").value;
	
	var autstandingAmount = autstandingAmount1.replace(",", "");
	var amount_adjusted = amount_adjusted1.replace(",", "");
	var amountApplicant = amountApplicant1.replace(",", "");
    var checkZero="0";	
    if(amount_adjusted !==''){
		if(parseFloat(amount_adjusted) >= parseFloat(amountApplicant)){	
		if((parseFloat(autstandingAmount) >= parseFloat(amount_adjusted)) && (parseFloat(amount_adjusted) > parseFloat(checkZero))){
        return check_status_employedBeneficiary();
        }else{
		var smsalert="Pay Amount must be less than or equal to outstanding amount";	
		alert (smsalert);
        return false;	
		}
        }else{
		var smsalert="Pay Amount must not be less than "+amountApplicant1;	
		alert (smsalert);
		return false;	
		}		
		}else{
		var smsalert="Pay Amount must be numerical";	
		alert (smsalert);
		return false;
		}
}
</script>
<?php 
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$outstandingDebt=number_format(\backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($model->applicant_id,$model->loan_summary_id,$loan_given_to),2);
//$amountRequiredForPayment=number_format($model->getAmountRequiredForPaymentIndividualLoanee($model->applicant_id,$model->loan_repayment_id),2);
$amountRequiredForPaymentq=number_format($model->getAmountRequiredTobepaidPermonth($model->applicant_id,$model->loan_summary_id,$loan_given_to),2);	
$amount1=$amountRequiredForPaymentq;
$amountx1=number_format(\frontend\modules\repayment\models\EmployerPenaltyPayment::getAmountTobePaidemployedBeneficiary($model->loan_summary_id,$model->applicant_id,$loan_given_to),2);
$loan_summary_id=$model->loan_summary_id;
$loan_repayment_id=$model->loan_repayment_id;
$applicantID=$model->applicant_id;
 ?>  
 <div class="block" id="hiddenAdjust_employedBeneficiary">
                <div class="panel-body">				 
                    <?= Html::beginForm(["/repayment/loan-repayment-detail/update-new-payment-amount",'id'=>$model->loan_repayment_id]); ?>
					<div class="profile-info-name">
          <label>Outstanding Amount:</label>
        </div>
		<div class="profile-info-value">
    <div class="col-sm-12">
<?= 
Html::textInput('outstandingAmount', $outstandingDebt, ['size'=>20,'class'=>'form-control','readOnly'=>'readOnly','id'=>'outstandingAmount_id','options'=>['size'=>'20']]) 
?>
</div>
    </div>
	<br/>
                <div class="profile-info-name">
          <label>Pay Amount:</label>
        </div>
		<div class="profile-info-value">
    <div class="col-sm-12">
<?= 
Html::textInput('amount', null, ['size'=>20,'class'=>'form-control','id'=>'amount_adjusted_id','options'=>['size'=>'20']]) 
                        ?>
<?= 
Html::hiddenInput('amountx1', $amountx1, ['size'=>20,'class'=>'form-control','id'=>'amountApplicant_id','options'=>['size'=>'20']]) 
?>	
<?= 
Html::hiddenInput('loan_summary_id', $loan_summary_id, ['size'=>20,'class'=>'form-control','options'=>['size'=>'20']]) 
?>
<?= 
Html::hiddenInput('loan_repayment_id', $loan_repayment_id, ['size'=>20,'class'=>'form-control','options'=>['size'=>'20']]) 
?>
<?= 
Html::hiddenInput('applicant_id', $applicantID, ['size'=>20,'class'=>'form-control','options'=>['size'=>'20']]) 
?>
</div>
    </div>			
<div class="text-right" >
	   <?= Html::submitButton('Submit', ['class'=>'btn btn-primary','onclick'=>'return  check_status_employedBeneficiary()']) ?>
	     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['loan-repayment/confirm-payment','id'=>$model->loan_repayment_id], ['class' => 'btn btn-warning']);
?>
    </div>					
                    <?= Html::endForm(); ?>  
					</div>					
                </div>			
