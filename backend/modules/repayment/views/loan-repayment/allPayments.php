<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute'=>'employer_id',
				'label'=>'Payer',
                'format'=>'raw',
                'value'=>function($model)
            {
			if($model->employer_id !=''){
			return $model->employer->employer_name;
			}else if($model->applicant_id !=''){
			return $model->applicant->user->firstname." ".$model->applicant->user->middlename." ".$model->applicant->user->surname;
                        }else{
                        return 'Treasury';   
                        }                   
            },
            ],
            /*        
            [
                'attribute'=>'applicant_id',
				'label'=>'Payer-Beneficiary',
                'format'=>'raw',
                'value'=>function($model)
            {
             if($model->applicant_id !=''){
			 return $model->applicant->user->firstname." ".$model->applicant->user->middlename." ".$model->applicant->user->surname;			
			}else{
			return '';
			}                   
            },
            ],
             * 
             */
            [
                'attribute'=>'control_number',
		'label'=>'Control #',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->control_number;                    
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
                        //'vAlign' => 'middle',
                        'label'=>"Status",
                        'width' => '200px',
                        'value' => function ($model) {
                           if($model->payment_status==0){
							 $status='<p class="btn green"; style="color:red;">Pending</p>';   
							}else{
							 $status='<p class="btn green"; style="color:green;">Complete</p>'; 
							}
							return $status;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Pending',1=>'Complete'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],

            
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
