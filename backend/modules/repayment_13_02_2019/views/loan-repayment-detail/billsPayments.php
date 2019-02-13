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

            //'loan_repayment_id',
            //'employer_id',
            
             /*       
            [
                     'attribute' => 'employer_id',
                      'vAlign' => 'middle',
                       'header'=>'Employer',  
                        'width' => '200px',
                        'value' => function ($model) {
                            if($model->employer_id == '')
                            {
                                return '';
                            }
                            else
                            {   
                                return $model->employer->employer_name;
                            }
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\repayment\models\Employer::find()->asArray()->all(), 'employer_id', 'employer_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
            ],
			*/
                    
            //'applicant_id',
            //'repayment_reference_number',
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
