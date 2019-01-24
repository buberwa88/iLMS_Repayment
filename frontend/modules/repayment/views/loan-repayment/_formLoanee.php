<script type="text/javascript">
    function checkvalidation() {
	    var autstandingAmount1 = document.getElementById("outstandingAmount_id").value;
		var amount_adjusted1 = document.getElementById("amount_adjusted_id").value.trim();
		var amountApplicant1 = document.getElementById("amountApplicant_id").value;

		var autstandingAmount = autstandingAmount1.replace(",", "");
		var amount_adjusted = amount_adjusted1.replace(",", "");
		var amountApplicant = amountApplicant1.replace(",", "");
		var checkZero="0";
		//alert(autstandingAmount);
		if(amount_adjusted !==''){
		if(parseFloat(amount_adjusted) >= parseFloat(amountApplicant)){	
		if((parseFloat(autstandingAmount) >= parseFloat(amount_adjusted)) && (parseFloat(amount_adjusted) > parseFloat(checkZero))){
       //if((parseFloat(autstandingAmount) >= parseFloat(amount_adjusted))){			
		return check_status();
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
use yii\widgets\ActiveForm;
use \backend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\LoanRepayment;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$results=LoanRepayment::getDetailsUsingRepaymentID($model->loan_repayment_id);
$date=date("Y-m-d");
$outstandingDebt=number_format(frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($results->applicant_id,$date,$loan_given_to),2);
$amountApplicant=\frontend\modules\repayment\models\EmployedBeneficiary::MINIMUM_AMOUNT_FOR_SELF_BENEFICIARY;
//echo $loan_repayment_id;


$bill_number=$model->bill_number;
$outstandingDebt=$outstandingDebt;
$outstandingDebt22=\frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($results->applicant_id,$date,$loan_given_to);
$testingLocal=\frontend\modules\repayment\models\LoanRepayment::TESTING_REPAYMENT_LOCAL;
			//GePG LIVE
			if($testingLocal=='N'){
$controlNumber=null;
$date=null;
			}
			if($testingLocal=='T'){
$controlNumber=mt_rand (10,100);
$date=date("Y-m-d H:i:s");
			}
?>
<script>
  function check_status() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("hidden2").style.display = "none";
   document.getElementById("hiddenAdjust").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
</script>
<style>
.row {
  width: 70%;
  /*margin: 0 auto;*/
    text-align: center;
}
.block {
  width: 100px;
  /*float: left;*/
    display: inline-block;
    zoom: 1;
}
</style>
<div class="loan-repayment-form">


<?php
    $attributes = [            

			[
                'columns' => [

                    [
                        'label' => 'Bill Number',
                        'value'  => call_user_func(function ($data) use($bill_number) {
                 return $bill_number;
            }, $model),
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ], 
                 [
                        'label' => 'Outstanding Amount',
                        'value'  => call_user_func(function ($data) use($outstandingDebt) {
							if($outstandingDebt==''){
							return 0;	
							}else{
                return $outstandingDebt;
							}
            }, $model),
                        'labelColOptions'=>['style'=>'width:12%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],					
                ],
            ],	
        ];
		echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);

	?>

	
	<?php $loan_repayment_id=$model->loan_repayment_id; ?>
	<?php $loan_summary_id=$results->loan_summary_id; ?>
	<?php //$amountApplicant=$model->amount; ?>
	<div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
              <h4><strong>Pay Bill</strong></h4>      
              </div>
	 <div class="row">	 
	 <div class="block"><button type="button" class="btn"><?php echo "Pay Amount: ".number_format($model->amount,2); ?></button></div>
<div class="block"></div>	 
	 <div class="block" id="hiddenAdjust">  
  
  <?php
                Modal::begin([
                    'header' => '<h4>Adjust Pay Amount</h4>',
                    'toggleButton' =>   ['label' => 'Adjust Amount', 'style'=>'margin-left:4px', 'class' => 'btn btn-primary'],
                ]);
            ?>
                <div class="panel-body">
                    <?= Html::beginForm("index.php?r=repayment/loan-repayment/adjust-amount-beneficiary"); ?>
					<div class="profile-info-name">
          <label>Outstanding Amount:</label>
        </div>
		<div class="profile-info-value">
    <div class="col-sm-12">
<?= 
Html::textInput('outstandingAmount', $outstandingDebt22, ['size'=>20,'class'=>'form-control','readOnly'=>'readOnly','id'=>'outstandingAmount_id','options'=>['size'=>'20']]) 
?>
<?= 
Html::hiddenInput('loan_repayment_id', $loan_repayment_id,['class'=>'form-control'])?>
<?=Html::hiddenInput('loan_summary_id', $loan_summary_id,['class'=>'form-control'])?>
<?=Html::hiddenInput('amountApplicant', $amountApplicant,['class'=>'form-control','id'=>'amountApplicant_id']) 
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
</div>
    </div>			
<div class="text-right" >
       <?php //if($model->hasErrors()){ ?>
	   <?= Html::submitButton('Submit', ['class'=>'btn btn-primary','onclick'=>'return  checkvalidation()']) ?>
	   <?php //} ?>
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['loan-repayment/confirm-paymentbeneficiary','id'=>$loan_repayment_id], ['class' => 'btn btn-warning']);
?>
    </div>					
                    <?= Html::endForm(); ?>     
                </div>
            <?php
                Modal::end();
                
            ?>  
  
  </div>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	 <div class="block">	 
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'payment_status')->label(false)->hiddenInput(['value'=>0,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'control_number')->label(false)->hiddenInput(['value'=>$controlNumber,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'date_control_received')->label(false)->hiddenInput(['value'=>$date,'readOnly'=>'readOnly']) ?>
		<div class="block" id="hidden"><?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','onclick'=>'return  check_status()']) ?></div>
		</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="block"></div>
		<div class="block">
       <div class="block" id="hidden2"><?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['cancel-bill-beneficiary','id'=>$model->loan_repayment_id], ['class' => 'btn btn-warning']); ?></div>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
	<br/><br/>
</div>
        </div>
		<p>
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
</p>
</div>
