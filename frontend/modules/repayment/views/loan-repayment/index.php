<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanRepayment;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$this->title = 'Bill';
$this->params['breadcrumbs'][] = $this->title;

            //$resultsAfterCheck=$model->checkWaitingConfirmationFromGePG($employerID);            
            $results1=$model->checkControlNumberStatus($employerID,$loan_given_to);
			$results_bill_number=(count($results1) == 0) ? '0' : $results1->loan_repayment_id;
            $ActiveBill=$modelBill->getActiveBill($employerID,$loan_given_to);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
            $totalAmount=number_format($results1->amount,2);
            //$loan_repayment_id=$results1->loan_repayment_id;
            $totalEmployees=$model->getAllEmployeesUnderBillunderEmployer($loan_repayment_id,$loan_given_to);
			//$amountRemainedUnpaid=frontend\modules\repayment\models\LoanSummary::getLoanSummaryBalance($billID);
			$date=date("Y-m-d");
            $amountRemainedUnpaid=frontend\modules\repayment\models\LoanSummaryDetail::getOustandingAmountUnderLoanSummary($billID,$date,$loan_given_to);
			if($amountRemainedUnpaid < 1){
			frontend\modules\repayment\models\LoanSummary::updateCompletePaidLoanSummary($billID,$loan_given_to);
			}
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
					  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
						
						<?php
						//here for incomplete bills
            if($loan_repayment_id !=0){
			?>
<?= GridView::widget([
        'dataProvider' => $dataProviderIncompleteBills,
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
                'attribute'=>'payment_date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->payment_date;                    
            },
            ],
			[
                'attribute'=>'date_bill_generated',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->date_bill_generated;                    
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
			
			[
            'attribute'=>'payment_status',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 if($resultsBatch->payment_status==0){
				 //$status="Pending";
                                 //$status='<p class="btn green"; style="color:red;">Pending</p>';
                                 return '<span class="label label-danger"> Pending';
				}else{
				 //$status="Complete"; 
                                 //$status='<p class="btn green"; style="color:green;">Complete</p>';
                                 return '<span class="label label-info"> Complete ';
				}
				//return $status;
            },             
            ],
			
			['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
				    if($model->employer->salary_source !=1){
                    return Html::a('Pay Bill', $url, ['class' => 'btn btn-success',
                                'title' => Yii::t('app', 'view'),
                    ]);
					}else{
		    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                    ]);			
					}
                },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'index.php?r=repayment/loan-repayment/confirm-payment&id=' . $model->loan_repayment_id;
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
			//end for incomplete bill
			?>                
    <?php  
//View bills
            if($loan_repayment_id ==0){
			
?>
<h3>Bills List</h3>
<?= GridView::widget([
        'dataProvider' => $dataProviderBills,
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
                'attribute'=>'control_number',
                'format'=>'raw',
                'value'=>function($model)
            {
            if($model->control_number==''){
             return '<p class="btn green"; style="color:red;">Waiting!</p>';
            }else{
             return $model->control_number;    
            }                 
            },
            ],
			[
            'attribute'=>'payment_status',
			'label'=>'Status',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 if($model->payment_status==0){
				 $status='<p class="btn green"; style="color:red;">Pending</p>';   
				}else{
				 $status='<p class="btn green"; style="color:green;">Complete</p>'; 
				}
				return $status;
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
			 'template'=>'{view}',
			 'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                    ]);
                },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'index.php?r=repayment/loan-repayment-detail/view&id=' . $model->loan_repayment_id;
                    return $url;
                }
            }
			],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
	<?php
}
//end view bills

	
            //}
    ?>
</div>
       </div>
</div>
