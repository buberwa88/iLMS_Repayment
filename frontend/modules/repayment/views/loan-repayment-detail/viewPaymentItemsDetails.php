<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\modules\repayment\models\LoanSummaryDetail;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */
$this->title = 'Loan Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-view">
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
        		'attribute'=>'principal',
				'label'=>'Principal',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
					if($data->applicant_id !=''){
                return $data->getPrincipalLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
					}else{
				return	$data->amount;	
					}
            }, $model),
            ],
			[
        		'attribute'=>'penalty',
				'label'=>'Penalty',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return $data->getPenaltyLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
            }, $model),
            ],
			[
        		'attribute'=>'LAF',
				'label'=>'LAF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return $data->getLAFLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
            }, $model),
            ],
			[
        		'attribute'=>'vrf',
				'label'=>'VRF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
               return $data->getVRFLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
            }, $model),
            ],		
        ],
    ]) ?>

</div>
    </div>
</div>
