<script type="text/javascript">
    function checkvalidation() {
	    var autstandingAmount1 = document.getElementById("outstandingAmount_id").value;
		var amount_adjusted1 = document.getElementById("amount_adjusted_id").value.trim();

		var autstandingAmount = autstandingAmount1.replace(",", "");
		var amount_adjusted = amount_adjusted1.replace(",", "");
		var checkZero="0";
		//alert(autstandingAmount);
		if(amount_adjusted !==''){
		if((parseFloat(autstandingAmount) >= parseFloat(amount_adjusted)) && (parseFloat(amount_adjusted) > parseFloat(checkZero))){			
		return check_status();
        }else{
		var smsalert="Pay Amount must be less than or equal to outstanding amount";	
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

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenaltyPayment */
/* @var $form yii\widgets\ActiveForm */
$totalAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmount($employerID);
$paidAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmountPaid($employerID);
$outstandingAmount=$totalAmount-$paidAmount;
$outstandingAmount1=number_format($outstandingAmount,2);
$getExists=\frontend\modules\repayment\models\EmployerPenaltyPayment::find()->where(['employer_id'=>$employerID,'payment_status'=>0])->count();
$amountPendingUnconfirmedPayment=frontend\modules\repayment\models\EmployerPenaltyPayment::getAmountPendingPaymentPNTNotConfirmed($employerID);
if($amountPendingUnconfirmedPayment > 0){
$amountToPayDisplay=number_format($amountPendingUnconfirmedPayment,2);
$amountSa=$amountPendingUnconfirmedPayment;	
}else{
// this is due to restriction if there are amount not yet confirmed
$amountToPayDisplay=$outstandingAmount1;
$amountSa=$outstandingAmount;		
}
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
frontend\modules\repayment\models\EmployerPenaltyPayment::getPenaltyToEmployer($loan_given_to);
frontend\modules\repayment\models\EmployerPenaltyPayment::getPenaltyToEmployerIndividualMonths($loan_given_to);
/*
    $todate=date("Y-m-d");
	$dateCreated=date_create($todate);
	$duration=2;
	$duration_type="months";
	$dateDurationAndType=$duration." ".$duration_type;
	date_sub($dateCreated,date_interval_create_from_date_string($dateDurationAndType));
	$firstDayPreviousMonth1=date_format($dateCreated,"Y-m-d");
	echo $firstDayPreviousMonth2=date("Y-m-d",strtotime($firstDayPreviousMonth1));
	//echo $firstDayPreviousMonth=$firstDayPreviousMonth2."-01";

=========date difference=====	
$date=date("Y-m-d");
$payment_date="2018-10-01";
$lastPaydate = date_create($payment_date);
$todate = date_create($date);
$interval = date_diff($lastPaydate, $todate);
echo $dateDifferenceInDays=$interval->format('%a');
*/
?>
<script>
  function check_status() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("hiddenAdjust").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
</script>
<style>
.row {
  width: 60%;
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
<div class="employer-penalty-payment-form">

    
	
	<?php
    $attributes = [            

			[
                'columns' => [

                    [
                        'label' => 'Total Amount',
                        'value'  => call_user_func(function ($data) use($totalAmount) {
                 return $totalAmount;
            }, $model),
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ], 
                 [
                        'label' => 'Amount Paid',
                        'value'  => call_user_func(function ($data) use($paidAmount) {
							if($paidAmount==''){
							return 0;	
							}else{
                return $paidAmount;
							}
            }, $model),
                        'labelColOptions'=>['style'=>'width:12%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
                    ],					
                ],
            ],
			[
                'columns' => [

                    [
                        'label' => 'Outstanding Amount',
                        'value'  => call_user_func(function ($data) use($outstandingAmount) {
                return $outstandingAmount;
            }, $model),
                        'labelColOptions'=>['style'=>'width:5%'],
                        'valueColOptions'=>['style'=>'width:30%'],
						'format'=>['decimal',2],
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
	
	<?php if($getExists==0){ ?>
	<?php if($outstandingAmount > 0){ ?>
	
	<div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
              <h4><strong>Penalty Payment</strong></h4>      
              </div>
	<div class="row">        
  <div class="block"><button type="button" class="btn"><?php echo "Pay Amount: ".$amountToPayDisplay; ?></button></div>
  <div class="block"></div>
  <div class="block" id="hiddenAdjust">
  
  
  <?php
                Modal::begin([
                    'header' => '<h4>Adjust Pay Amount</h4>',
                    'toggleButton' =>   ['label' => 'Adjust Amount', 'style'=>'margin-left:4px', 'class' => 'btn btn-primary'],
                ]);
            ?>
                <div class="panel-body">
                    <?= Html::beginForm("index.php?r=repayment/employer-penalty-payment/adjust-amount-penalty"); ?>
					<div class="profile-info-name">
          <label>Outstanding Amount:</label>
        </div>
		<div class="profile-info-value">
    <div class="col-sm-12">
<?= 
Html::textInput('outstandingAmount', number_format($outstandingAmount,2), ['size'=>20,'class'=>'form-control','readOnly'=>'readOnly','id'=>'outstandingAmount_id','options'=>['size'=>'20']]) 
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
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['employer-penalty-payment/create'], ['class' => 'btn btn-warning']);
?>
    </div>					
                    <?= Html::endForm(); ?>     
                </div>
            <?php
                Modal::end();
                
            ?>  
  
  </div>        
		<div class="block">
		<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
		<?= $form->field($model, 'amount')->label(false)->hiddenInput(['value'=>$amountSa,'readOnly'=>'readOnly']) ?></div>
		<div class="block" id="hidden"><?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick'=>'return  check_status()']) ?>
		</div>
<br/><br/><br/>		
    </div>
	<?php ActiveForm::end(); ?>
	
    </div>
        </div>			
	<?php } ?>
<?php }else{
?>
<div class="alert alert-info alert-dismissible">
Pending Payment!
</div>
<?php	
} ?>
<p>
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
</p>
</div>
<?php
Modal::begin([
    'id' => 'adjustAmountPenalty',
    'header' => '<h4 class="modal-title">...</h4>',
]);
 
//echo '...';
 
Modal::end();
?>
<?php
    $this->registerJs("
    $('#adjustAmountPenalty').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
?>
