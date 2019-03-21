<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerPenaltyPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penalties Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-payment-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'employer_penalty_payment_id',
            //'employer_id',
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
            [
                'attribute' => 'print',
                'format' => 'raw',
                'label'=>'Action',
                'value' => function ($model) {
                    return Html::a('Print Receipt', Url::toRoute(['employer-penalty-payment/print-receipt', 'id' => $model->employer_penalty_payment_id]),
                        ['target' => '_blank', 'class' => 'btn btn-success center-block']);
                },
            ],
			
			

            //['class' => 'yii\grid\ActionColumn'],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
