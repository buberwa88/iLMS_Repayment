<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loans Summaries';
$this->params['breadcrumbs'][] = $this->title;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
<div class="loan-summary-index">
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
			/*
            [
            'attribute'=>'employer_id',
            'header'=>'Employer',
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->employer_id == '')
                {
                    return $model->applicant->user->firstname;
                }
                else
                {   
                    return $model->employer->employer_name;
                }
            },
        ],
		*/
            //'bill_number',
			[
            'attribute'=>'reference_number',
            'label'=>'Loan Summary No.',    
            'value' =>function($model)
            {
                 return $model->reference_number;
            }, 
        ],
        [
            'attribute'=>'amount',			
            'label'=>'Total Amount',    
            'value' =>function($model) use($loan_given_to)
            {
				$date=date("Y-m-d");
                return   \frontend\modules\repayment\models\LoanSummaryDetail::getTotalAmountUnderBillSummary($model->loan_summary_id,$date,$loan_given_to);
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ], 
        [
                'attribute'=>'paid',
                'value'=>function($model) use($loan_given_to)
            {
				$date=date("Y-m-d");
                 return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidunderBill($model->loan_summary_id,$date,$loan_given_to);
            },
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ],
        
        [
                'attribute'=>'outstanding_debt',               
                'value'=>function($model) use($loan_given_to)
            {	
			$date=date("Y-m-d");
             return   \frontend\modules\repayment\models\LoanSummaryDetail::getOustandingAmountUnderLoanSummary($model->loan_summary_id,$date,$loan_given_to);
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
                   return "On Payment";
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
            //['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
			/*
                    ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',                        
			],
			*/
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
                    $url = 'index.php?r=repayment/loan-summary/view&id=' . $model->loan_summary_id;
                    return $url;
                }
            }
			],
                    
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
