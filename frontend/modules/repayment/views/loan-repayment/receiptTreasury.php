<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanRepayment;
use kartik\tabs\TabsX;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receipt';
$this->params['breadcrumbs'][] = $this->title;         
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
					  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
						
						<?php
						//here for incomplete bills
            //if($treasury_payment_id !=0){
			?>
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
             return $model->control_number;                    
            },
            ],
                    [
                'attribute'=>'receipt_number',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->receipt_number;                    
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
                'attribute'=>'date_receipt_received',
                'label'=>'Pay Date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->date_receipt_received;                    
            },
            ],			
                        /*
			['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {				    
                    return Html::a('Print', $url, ['class' => 'btn btn-success',
                                'title' => Yii::t('app', 'view'),
                    ]);
                },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'index.php?r=repayment/loan-repayment/print-receipt&id=' . $model->loan_repayment_id;
                    return $url;
                }
            }                        
			],
                                */
                    /*
                    [
    'attribute' => 'print',
    'format' => 'raw',
    'label'=>'Action',                    
    'value' => function ($model) {
        $student_username = 'Print';
        return Html::a('Print', '',
            ['onclick' => "window.open ('".Url::toRoute(['loan-repayment/print-receipt', 'id' => $model->loan_repayment_id])."'); return false", 
             'class' => 'btn btn-success center-block']);
    },
                    ],
                     * 
                     */
                    [
        'attribute' => 'print',
        'format' => 'raw',
		'label'=>'Action',
        'value' => function ($model) {
            return Html::a('Print', Url::toRoute(['loan-repayment/print-receipt', 'id' => $model->loan_repayment_id]),
                ['target' => '_blank', 'class' => 'btn btn-success center-block']);
        },
    ]
			
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
                    
            <?php //} 
			//end for incomplete bill
			?>
</div>
       </div>
</div>
