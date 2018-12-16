<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;

$loggedin=Yii::$app->user->identity->user_id;
$employer2=\frontend\modules\repayment\models\EmployerSearch::getEmployer($loggedin);
$employerID=$employer2->employer_id;

$resultsCount=\frontend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_repayment_id,loan_repayment_detail.amount FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE loan_repayment.payment_status IS NULL AND loan_repayment_detail.loan_given_to='$loan_given_to'  AND loan_repayment.employer_id='$employerID' GROUP BY loan_repayment_detail.loan_repayment_id")->count();

$resultsCountExistsNotPaid=\frontend\modules\repayment\models\LoanSummaryDetail::findBySql("SELECT loan_summary_detail.loan_summary_id,loan_summary_detail.amount FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE loan_summary_detail.is_full_paid='0' AND loan_summary_detail.loan_given_to='$loan_given_to'  AND loan_summary.employer_id='$employerID' GROUP BY loan_summary_detail.loan_summary_id")->count();

?>
<div class="loan-summary-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						
                        </div>
                        <div class="panel-body">
						<?php  if($resultsCount ==0){
                        if($resultsCountExistsNotPaid > 0){
						?>
						    <p>
        <?= Html::a('Generate Bill', ['loan-repayment/generate-billscholarship'], ['class' => 'btn btn-success','onclick'=>'return  checkBillStatus()']) ?>
        
    </p>
						<?php } ?>
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
				return \backend\modules\repayment\models\LoanSummaryDetail::getLoaneeTotalLoanInLoanSummary($model->applicant_id,$model->loan_summary_id,$loan_given_to);
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
				 return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidunderBillIndividualEmployee($model->applicant_id,$model->loan_summary_id,$loan_given_to);
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
			 return \backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($model->applicant_id,$model->loan_summary_id,$loan_given_to);
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
						<?php } ?>
	<?php
			// if there is incomplete bill
            if($resultsCount !=0){
			?>
<?= GridView::widget([
        'dataProvider' => $dataProviderBill,
        'filterModel' => $searchModelBill,
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
                'attribute'=>'payment_date',
				'label'=>'Bill Date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->payment_date;                    
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
                    $url = 'index.php?r=repayment/loan-repayment/confirm-payment-scholarship&id=' . $model->loan_repayment_id;
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
	
</div>
       </div>
</div>
