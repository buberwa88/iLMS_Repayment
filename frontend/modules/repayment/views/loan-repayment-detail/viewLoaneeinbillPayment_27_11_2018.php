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
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
//use backend\modules\repayment\models\LoanSummaryDetailSearch;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */
$this->title = "Beneficiaries";
?>
<div class="loan-summary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			/*
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			*/
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],
			[
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
            ],            
            [
                'attribute' => 'outstanding',
				'label'=>'Outstanding',
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
                //return \backend\modules\repayment\models\EmployedBeneficiary::getBeneficiaryOutstandingLoan($model->applicant_id);
				return \backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($model->applicant_id,$model->loan_summary_id);
        },
            ],
			[
            'attribute'=>'amount',
			'hAlign' => 'right',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->getAmountRequiredForPaymentIndividualLoanee($model->applicant_id,$model->loan_repayment_id);
            },
            'format'=>['decimal',2],
        ],
             [
            'header' => 'Actions',  
            'format'=>'raw',
            'value' => function ($data){
                    return  Html::a('Adjust Amount',['loan-repayment-detail/update-new-payment-amount','id'=>$data->loan_repayment_detail_id],['data-toggle'=>"modal",'data-target'=>"#adjustAmount",'data-title'=>"Adjust Amount",'class' => 'btn btn-success',]
                );
                }
        ],
          			
        ],
    ]); ?>
</div>
    </div>
</div>



<?php
/*
Modal::begin([
    'id' => 'adjustAmount',
    'header' => '<h4 class="modal-title">...</h4>',
]);
 
//echo '...';
 
Modal::end();
*/
?>


<?php
/*
    $this->registerJs("
    $('#adjustAmount').on('show.bs.modal', function (event) {
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
*/
?>
<div class="block" id="hiddenAdjust">  
  
  <?php
                Modal::begin([
                    'header' => '<h4>Adjust Pay Amount</h4>',
					'id' => 'adjustAmount',
                    //'toggleButton' =>   ['label' => false,],
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
Html::textInput('outstandingAmount', $outstandingDebt, ['size'=>20,'class'=>'form-control','readOnly'=>'readOnly','id'=>'outstandingAmount_id','options'=>['size'=>'20']]) 
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
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['view-loaneeinbill-payment','id'=>$loan_repayment_id], ['class' => 'btn btn-warning']);
?>
    </div>					
                    <?= Html::endForm(); ?>     
                </div>
            <?php
                Modal::end();
                
            ?>  
  
  </div>