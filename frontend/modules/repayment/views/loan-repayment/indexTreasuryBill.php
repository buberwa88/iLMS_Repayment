<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\modules\repayment\models\LoanRepayment;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bill';
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
            if($loan_repayment_id !=0){
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
                'attribute'=>'payment_date',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->payment_date;                    
            },
            ],
			[
                'attribute'=>'date_bill_generated',
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
                'label' => 'Payment Status',
				'format' => 'raw',
//                'vAlign' => 'middle',
//                'width' => ' ',
                'value' => function($model) {
                    if (($model->payment_status == 1)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-info"> Paid ';
                    }


                    if (($model->payment_status == 0)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-danger"> Pending';
                    }                    
                },                
                'filter' => [1 => 'Paid', 0 => 'Pending']
            ],
			
			
			['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    if($model->payment_status == 0){
                    return Html::a('Pay Bill', $url, ['class' => 'btn btn-success',
                                'title' => Yii::t('app', 'view'),
                    ]);
                    }
                },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'index.php?r=repayment/loan-repayment/confirm-payment-treasury&id=' . $model->loan_repayment_id;
                    return $url;
                }
            }                        
			],
			
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
                    
            <?php } 
			//end for incomplete bill
			?>                
    <?php  
//View bills
            if($loan_repayment_id ==0){
			
?>
<h3>Bills List</h3>
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
                'attribute'=>'date_bill_generated',
                'format'=>'raw',
                'value'=>function($model)
            {
             return $model->date_bill_generated;                    
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
                'label' => 'Payment Status',
				'format' => 'raw',
//                'vAlign' => 'middle',
//                'width' => ' ',
                'value' => function($model) {
                    if (($model->payment_status == 1)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-info"> Paid ';
                    }


                    if (($model->payment_status == 0)) {
                        //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                        return '<span class="label label-danger"> Pending';
                    }                    
                },                
                'filter' => [1 => 'Paid', 0 => 'Pending']
            ],
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
                    $url = 'index.php?r=repayment/loan-repayment/view-treasury&id=' . $model->loan_repayment_id;
                    return $url;
                }
            }
			],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
	<?php
}
//end view bills

	
            //}
    ?>
</div>
       </div>
</div>
