<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerPenaltyPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Penalties Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-payment-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
			'attribute'=>'employer_id',
            'label'=>'Employer',
            'format'=>'raw',    
            'value' => function($model)
            {   
                   
                    return $model->employer->employer_name;

            },
        ],
			'control_number',
            //'amount',
			'payment_date',
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
			
			

            [
                'label' => ' ',
               'value' => function ($model) {
                if ((($model->payment_status == 0 || $model->payment_status == ''))) {
                        return Html::a('<span class="label label-danger">Cancel</span>', Yii::$app->urlManager->createUrl(['/repayment/loan-repayment/cancel-bill-repayment', 'id' => $model->employer_penalty_payment_id,'identity'=>'EPNT']), [
                                    'title' => Yii::t('yii', 'Cancel'),
                                    'data' => ['confirm' => 'Are you sure you want to cancel this Bill?'],
                        ]);
                    } else {
                        return ' ';
                    }
                },
                        'format' => 'raw',
                    ],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
