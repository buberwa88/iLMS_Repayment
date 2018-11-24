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
?>
<div class="loan-repayment-index">

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
			[
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('viewPaymentItemsDetailsSelfBeneficiary',['model'=>$model,'applicantID'=>$applicantID]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],

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
            'attribute'=>'amountApplicant',
			'hAlign' => 'right',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->getTotalAmountPaidLoaneeUnderTransaction($model->loan_repayment_id);
            },
            'format'=>['decimal',2],
        ], 
		/*
            [
                'attribute'=>'date_control_received',
                'label'=>'Pay Date',
                'format'=>'raw',
                'value'=>$model->date_control_received,
                'filter'=>'',
            ],  
*/			
        ],
    ]); ?>
</div>
       </div>
</div>
