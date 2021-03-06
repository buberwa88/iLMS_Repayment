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
	  function check_status() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("hiddenAdjust").style.display = "none";
   document.getElementById("loader").style.display = "block";
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
Modal::begin([
    'id' => 'adjustAmount',
    'header' => '<h4 class="modal-title">...</h4>',
]);
 
//echo '...';
 
Modal::end();
?>


<?php
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
?>