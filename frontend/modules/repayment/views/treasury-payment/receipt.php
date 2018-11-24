<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanRepayment;
use kartik\tabs\TabsX;

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
                'attribute'=>'payment_date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->payment_date;                    
            },
            ],			
            
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
                    $url = 'index.php?r=repayment/treasury-payment/confirm-payment&id=' . $model->treasury_payment_id;
                    return $url;
                }
            }                        
			],
			
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
