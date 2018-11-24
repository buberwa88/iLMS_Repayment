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
                'attribute'=>'f4indexno',
				'label'=>'Payer ID',
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
            if($model->control_number==''){
             return '<p class="btn green"; style="color:red;">Waiting!</p>';
            }else{
             return $model->control_number;    
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
                'attribute'=>'payment_date',
				'label'=>'Bill Date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->payment_date;                    
            },
            ],
			[
                'attribute'=>'date_bill_generated',
				'label'=>'Payment Date',
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
                        'attribute' => 'payment_status',
						'label'=>'Payment Status',
                        'value' => function ($model) {
                           if($model->payment_status==0){
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
