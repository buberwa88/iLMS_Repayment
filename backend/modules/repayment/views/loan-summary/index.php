<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\EmployerSearch;
use frontend\modules\application\models\Applicant;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loans Summaries';
$this->params['breadcrumbs'][] = $this->title;
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
			
            [
            'attribute'=>'employer_name',
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
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ], 
        [
                'attribute'=>'paid',
                'value'=>function($model)
            {
                 return $model->getTotalPaidunderBill($model->loan_summary_id);
            },
            'format'=>['decimal',2],
			'hAlign' => 'right',
        ],
        
        [
                'attribute'=>'outstanding_debt',               
                'value'=>function($model)
            {
             return   ($model->amount + $model->vrf_accumulated)-$model->getTotalPaidunderBill($model->loan_summary_id);
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
                    ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',                        
			],
                    
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
