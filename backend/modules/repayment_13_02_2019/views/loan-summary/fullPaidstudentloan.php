<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
<div class="loan-summary-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						
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
			
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],			
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
            'attribute'=>'amount',			
            'label'=>'Total Amount',    
            'value' =>function($model) use($loan_given_to)
            {
				$date=date("Y-m-d");
                //return   \frontend\modules\repayment\models\LoanSummaryDetail::getTotalAmountUnderBillSummary($model->loan_summary_id,$date,$loan_given_to);
				return \backend\modules\repayment\models\LoanSummaryDetail::getTotalLoan($model->applicant_id,$loan_given_to);
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ], 
        [
                'attribute'=>'paid',
                'value'=>function($model) use($loan_given_to)
            {
				$date=date("Y-m-d");
                 //return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidunderBill($model->loan_summary_id,$date,$loan_given_to);
				 return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountFullPaid($model->applicant_id,$loan_given_to);
            },
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ],
        
        [
                'attribute'=>'outstandingDebt',               
                'value'=>function($model) use($loan_given_to)
            {	
			$date=date("Y-m-d");
             //return   \frontend\modules\repayment\models\LoanSummaryDetail::getOustandingAmountUnderLoanSummary($model->loan_summary_id,$date,$loan_given_to);
			 return \frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingFullPaid($model->applicant_id,$loan_given_to);
            },
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ],
            //['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
			/*
                    ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',                        
			],
			*/
                   
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
