<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\TreasuryPaymentDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employers Bills';
?>
<div class="treasury-payment-detail-index">
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

            //'treasury_payment_detail_id',
            //'treasury_payment_id',
			[
            'attribute'=>'employer_name',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->employer->employer_name;
            }, 
            ],
			[
            'attribute'=>'bill_number',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->bill_number;
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

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    </div>
</div>
