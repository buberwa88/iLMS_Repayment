<script type="text/javascript">
	function checkBillStatus() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
</script>
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//create loan summary
		\frontend\modules\repayment\models\LoanSummary::createLoanSummaryIndividual($applicantID,$loan_given_to);
		//end
$this->title = 'Bill';
$this->params['breadcrumbs'][] = $this->title;           
            $results1=$model->checkControlNumberStatusLoanee($applicantID);
            $results_bill_number=(count($results1) == 0) ? '0' : $results1->loan_repayment_id;
            $control_number=$results1->control_number;
            $payment_status=(count($results1) == 0) ? '0' : $results1->payment_status;
            $ActiveBill=$modelBill->getActiveBillLoanee($applicantID,$loan_given_to);
            $billID=(count($ActiveBill) == 0) ? '0' : $ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            $totalAmount=number_format($results1->amount,2);
			
			$outstanding_debt=\backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($applicantID,$ActiveBill->loan_summary_id,$loan_given_to);			
			//$amountRemainedUnpaid=frontend\modules\repayment\models\LoanSummary::getLoanSummaryBalance($ActiveBill->loan_summary_id);
			$date=date("Y-m-d");
            $amountRemainedUnpaid=frontend\modules\repayment\models\LoanSummaryDetail::getOustandingAmountUnderLoanSummary($billID,$date,$loan_given_to);
			if($amountRemainedUnpaid < 1){
			frontend\modules\repayment\models\LoanSummary::updateCompletePaidLoanSummary($ActiveBill->loan_summary_id,$loan_given_to);
			}
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
					  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
            <?php
			// if there is incomplete bill
            if($loan_repayment_id !=0){
			?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute'=>'bill_number',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->bill_number;                    
            },
            ],
            [
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
			
			['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('Pay Bill', $url, ['class' => 'btn btn-success',
                                'title' => Yii::t('app', 'view'),
                    ]);
                },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'index.php?r=repayment/loan-repayment/confirm-paymentbeneficiary&id=' . $model->loan_repayment_id;
                    return $url;
                }
            }                        
			],
           		
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
                    
            <?php } 
			// end for if there is incomplete bill
			?>                 
                            
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    
    if($results_bill_number ==0 && $billID !=0 && $outstanding_debt > 1){
        
    ?>
<div class="block" id="hidden">
    <p>
        <?= Html::a('Generate Bill', ['generate-billbeneficiary'], ['class' => 'btn btn-success','onclick'=>'return  checkBillStatus()']) ?>
        
    </p>
	</div>
	<p>
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
<br/><br/><br/>
</p>
    <?php }            
			
    ?>
	
	<?php
            if($loan_repayment_id ==0){
			?>
<?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute'=>'bill_number',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->bill_number;                    
            },
            ],
            [
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],		
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
                    
            <?php } ?>
</div>
       </div>
</div>
