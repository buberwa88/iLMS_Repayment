<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = "Loan Payments";
$this->params['breadcrumbs'][] = ['label' => 'Loan Payments', 'url' => ['all-payments']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-view">
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
            [
            'label'  => 'Payer',
            'value'  => call_user_func(function ($data) {
			if($data->employer_id !=''){
			return $data->employer->employer_name;
			}else if($data->applicant_id !=''){
			return $data->applicant->user->firstname." ".$data->applicant->user->middlename." ".$data->applicant->user->surname;
                        }else{
                        return 'Treasury';   
                        }
            }, $model),            
        ],	
            'bill_number',		
            'control_number',
			'payment_date',
            'amount',
            'receipt_number',
			[
            'label'  => 'Pay Method',
            'value'  => call_user_func(function ($data) {
			return $data->payMethod->method_desc;
            }, $model),            
        ],
            'date_bill_generated',
            'date_control_received',
            'date_receipt_received',
        ],
    ]) ?>
            <?php								
echo TabsX::widget([
    'items' => [  	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment-detail/view-loanee-under-payment','id'=>$model->loan_repayment_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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
