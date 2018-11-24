<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\modules\repayment\models\LoanSummaryDetail;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
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
                return $data->getIndividualEmployeesPrincipalLoan($data->applicant_id,$data->loan_summary_id);
            }, $model),
            ],
			[
        		'attribute'=>'penalty',
				'label'=>'Penalty',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return $data->getIndividualEmployeesPenalty($data->applicant_id,$data->loan_summary_id);
            }, $model),
            ],
			[
        		'attribute'=>'LAF',
				'label'=>'LAF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return $data->getIndividualEmployeesLAF($data->applicant_id,$data->loan_summary_id);
            }, $model),
            ],
			[
        		'attribute'=>'vrf',
				'label'=>'VRF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
               return $data->getIndividualEmployeesVRF($data->applicant_id,$data->loan_summary_id);
            }, $model),
            ],
			[
        		'attribute'=>'totalLoan',
				'label'=>'Total',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return $data->getIndividualEmployeesTotalLoan($data->applicant_id,$data->loan_summary_id);
            }, $model),
            ],
			[
        		'attribute'=>'paid',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return \backend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoaneeUnderLoanSummary($data->applicant_id,$data->loan_summary_id);
            }, $model),
            ],
			[
        		'attribute'=>'outstandingDebt',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
               return $data->getIndividualEmployeesOutstandingDebt($data->applicant_id,$data->loan_summary_id);
            }, $model),
            ],
						
        ],
    ]) ?>

</div>
    </div>
</div>
