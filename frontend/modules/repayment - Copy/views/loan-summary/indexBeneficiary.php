<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanSummary;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Summary';
//$this->params['breadcrumbs'][] = ['label' => 'List of Notifications', 'url' => ['/repayment/default/notification']];
$this->params['breadcrumbs'][] = $this->title;

//echo $employer_id;
$LoanSummaryModel=new LoanSummary();
$billFoundResults=$LoanSummaryModel->getBillRequestedPending($applicantID);

            $results1=\backend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicantID);
            //$totalLoan=$BillDetailModel->getTotalLoanBeneficiaryOriginal($applicantID);
			$totalLoan=\backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($applicantID);
			$balance=$totalLoan-$results1;
?>
<div class="loan-summary-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                            <?php if($billFoundResults !=0){ ?>
    <p>
        Loan summary requests pending!
        
    </p>
                            <?php }else{?>
							<?= Html::encode($this->title) ?>
							<?php } ?>
                        </div>
                        <div class="panel-body">
                            <?php if($billFoundResults==0){
                            if($loanSummaryExist ==0){
							if($balance > 1){
							?>
    <p>
        <?= Html::a('Request Loan Summary', ['create-bill-request-applicant'], ['class' => 'btn btn-success']) ?>
		
    </p>
                            <?php }}} ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
            'attribute'=>'reference_number',
            'label'=>'Loan Summary No.',    
            'value' =>function($model)
            {
                 return $model->reference_number;
            }, 
        ],
		[
                'attribute' => 'amount',
				'label'=>"Total Amount",
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
				return \backend\modules\repayment\models\LoanSummaryDetail::getLoaneeTotalLoanInLoanSummary($model->applicant_id,$model->loan_summary_id);
        },
            ],
        [
                'attribute'=>'paid',
                'value'=>function($model)
            {
                 return frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidunderBillIndividualEmployee($model->applicant_id,$model->loan_summary_id);
            },
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ],
        
        [
                'attribute'=>'outstanding_debt',               
                'value'=>function($model)
            {
             return \backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($model->applicant_id,$model->loan_summary_id);
            },
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ],

            [
            'attribute'=>'status',
			'label'=>'Loan Status',
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->status == '0')
                {
                    return "Posted";
                }
                else if($model->status == '1')
                {
                $outstandingAmount=\backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($model->applicant_id,$model->loan_summary_id);	
                if($outstandingAmount < 1){				
                   return "Paid";
				   }else{
				   return "On Payment";
				   }
                }else if($model->status == '2')
                {   
                   return "Paid";
                }else if($model->status == '3')
                {   
                   return "Cancelled";
                }else if($model->status == '4')
                {   
                   return "Ceased";
                }else if($model->status == '5')
                {   
                   return "Ceased";
                }
            },
        ],            
                    
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
