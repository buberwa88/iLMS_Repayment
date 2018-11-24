<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanRepayment;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
$model = new LoanRepayment();

$controlNumber = '93';
$amount = '864000.00';
$model->updatePaymentAfterGePGconfirmPaymentDoneTreasury($controlNumber, $amount);

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
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('viewOtherDetailsTreasuryPay',['model'=>$model]);  
				  //return $this->render('viewLoanStatement',['model'=>$model]);
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
			
			[
                'attribute'=>'firstname',
				'label'=>'firstname',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->applicant->user->firstname;                    
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
                'attribute'=>'f4indexno',
				'label'=>'f4indexno',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->f4indexno;                    
            },
            ],
                   [
                'attribute'=>'employer_name',
				'label'=>'Employer',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->loanRepayment->employer->employer_name;                    
            },
            ], 
			[
                'attribute'=>'bill_number',
		'label'=>'bill #',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->treasuryPayment->bill_number;                    
            },
            ],			
						
			[
            'attribute'=>'amount',
			'label'=>'Amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
            [
                'attribute'=>'date_receipt_received',
                'label'=>'Pay Date',
                'format'=>'raw',
                'value'=>function($model)
            {
                if($model->treasuryPayment->date_receipt_received==NULL){
                    return '';
                }else{
             return $model->treasuryPayment->date_receipt_received;
                }
            },
            ],
			[
            'attribute'=>'payment_status',
			'label'=>'Status',   
            'value' =>function($model)
            {
                 if($model->payment_status==0){
				 //$status='<p class="btn green"; style="color:red;">Pending</p>';  
                                  return '<span class="label label-danger"> Pending';
				}else{
				 //$status='<p class="btn green"; style="color:green;">Complete</p>'; 
                                 return '<span class="label label-info"> Complete ';
				}
				return $status;
            },
            'format' => 'raw',
            'filter' => [0 => 'Pending', 1 => 'Paid']			
            ], 

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
