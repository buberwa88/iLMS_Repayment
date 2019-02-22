<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Employer Bills';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('viewPaymentDetails',['model'=>$model]);				  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
					
			[
                        'attribute' => 'payment_category',
						'label'=>'Payer',
                        'value' => function ($model) {
                           if($model->loanRepayment->payment_category==0){
							 $status='Employer';   
							}else{
							 $status='Treasury'; 
							}
							return $status;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Employer',1=>'Treasury'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],
			
			
			[
                'attribute'=>'employer_id',
				'label'=>'Employer',
                'format'=>'raw',
                'value'=>function($model)
            {
			if($model->loanRepayment->employer_id !=''){
			return $model->loanRepayment->employer->employer_name;
			}                  
            },
            ],
            
            [
                'attribute'=>'f4indexno',
				'label'=>'f4indexno',
                'format'=>'raw',
                'value'=>function($model)
            {
	
			return $model->applicant->f4indexno;
                                          
            },
            ],
                    
            [
                'attribute'=>'firstname',
				'label'=>'First Name',
                'format'=>'raw',
                'value'=>function($model)
            {
			 return $model->applicant->user->firstname;                  
            },
            ],
			[
                'attribute'=>'middlename',
				'label'=>'Middle Name',
                'format'=>'raw',
                'value'=>function($model)
            {
			 return $model->applicant->user->middlename;                  
            },
            ],
			[
                'attribute'=>'surname',
				'label'=>'Last Name',
                'format'=>'raw',
                'value'=>function($model)
            {
			 return $model->applicant->user->surname;			                   
            },
            ],
             
             
            [
                'attribute'=>'control_number',
				'label'=>'Control #',
                'format'=>'raw',
                'value'=>function($model)
            {
            if($model->loanRepayment->control_number==''){
             return '<p class="btn green"; style="color:red;">Waiting!</p>';
            }else{
             return $model->loanRepayment->control_number;    
            }                 
            },
            ],
                    /*
            [
                'attribute'=>'receipt_number',
		'label'=>'Receipt #',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->receipt_number;                    
            },
            ],
                     * 
                     */        
			[
                'attribute'=>'date_bill_generated',
				'label'=>'Pay Date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return date("Y-m-d",strtotime($model->loanRepayment->date_bill_generated));                    
            },
            ],
			
            [
            'attribute'=>'amount',
			'label'=>'Amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 //return $model->amount;
				 return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidByIndividualLoaneeUnderLoanRepayment($model->applicant_id,$model->loan_repayment_id);
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],            
            [
                        'attribute' => 'payment_status',
						'label'=>'Status',
                        'value' => function ($model) {
                           if($model->loanRepayment->payment_status==0){
							 $status='<p class="btn green"; style="color:red;">Pending</p>';   
							}else{
							 $status='<p class="btn green"; style="color:green;">Paid</p>'; 
							}
							return $status;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Pending',1=>'Paid'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],

            
                    
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
