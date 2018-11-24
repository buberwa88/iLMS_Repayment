<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPayment */

//$this->title = $model->treasury_payment_id;
$this->title = 'Bill';
$this->params['breadcrumbs'][] = ['label' => 'Treasury Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasury-payment-view">
<div class="panel panel-info">
                        <div class="panel-heading">
					  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => [
            //'treasury_payment_id',
            'bill_number',
            'control_number',
			[
            'label'  => 'Amount',
            'value'  => call_user_func(function ($data) {
			return $data->amount;
            }, $model),
            'format'=>['decimal',2], 			
        ],
            'receipt_number',
            //'pay_method_id',
            //'pay_phone_number',
            'payment_date',
            'date_bill_generated',
            'date_control_received',
            'date_receipt_received',
			[
            'label'  => 'Payment Status',
			'format'=>'raw',
            'value'  => call_user_func(function ($data) {
			if($data->payment_status==0){
			return "<span class='label label-danger'>".Pending."</span>";
			}else if($data->payment_status==1){
			return "<span class='label label-success'>".Paid."</span>";
			}
            }, $model),            
        ],
        ],
    ]) ?>

					<br/>
					   <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/view-loanee-paymenttreasury','id'=>$model->treasury_payment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
        [
            'label' => 'Employers Bills',
            'content' => '<iframe src="' . yii\helpers\Url::to(['treasury-payment-detail/employers-bills','id'=>$model->treasury_payment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
</div>
       </div>
</div>
