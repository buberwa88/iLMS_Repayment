<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanRepayment;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Payments';
$this->params['breadcrumbs'][] = $this->title;
$model = new LoanRepayment();
/*
$controlNumber = '82';
$amount = '100000.00';
$model->updatePaymentAfterGePGconfirmPaymentDone($controlNumber, $amount);
*/
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
			],
            [
                'attribute' => 'print',
                'format' => 'raw',
                'label'=>'Action',
                'value' => function ($model) {
                    return Html::a('Print Receipt', Url::toRoute(['loan-repayment/print-receipt', 'id' => $model->loan_repayment_id]),
                        ['target' => '_blank', 'class' => 'btn btn-success center-block']);
                },
            ]
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
