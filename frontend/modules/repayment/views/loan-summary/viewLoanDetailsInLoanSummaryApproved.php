<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\modules\repayment\models\LoanSummaryDetail;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */
$this->title = 'Loan Details';
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
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
                'value'=>call_user_func(function ($data) use($loan_given_to) {
                return $data->getIndividualEmployeesPrincipalLoan($data->applicant_id,$data->loan_summary_id,$loan_given_to);
            }, $model),
            ],
			[
        		'attribute'=>'penalty',
				'label'=>'Penalty',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) use($loan_given_to) {
                return $data->getIndividualEmployeesPenalty($data->applicant_id,$data->loan_summary_id,$loan_given_to);
            }, $model),
            ],
			[
        		'attribute'=>'LAF',
				'label'=>'LAF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) use($loan_given_to) {
                return $data->getIndividualEmployeesLAF($data->applicant_id,$data->loan_summary_id,$loan_given_to);
            }, $model),
            ],
			[
        		'attribute'=>'vrf',
				'label'=>'VRF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) use($loan_given_to) {
               return $data->getIndividualEmployeesVRF($data->applicant_id,$data->loan_summary_id,$loan_given_to);
            }, $model),
            ],
			[
        		'attribute'=>'totalLoan',
				'label'=>'Total',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) use($loan_given_to) {
                return $data->getIndividualEmployeesTotalLoan($data->applicant_id,$data->loan_summary_id,$loan_given_to);
            }, $model),
            ],
			[
        		'attribute'=>'paid',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) use($loan_given_to) {
                return \backend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoaneeUnderLoanSummary($data->applicant_id,$data->loan_summary_id,$loan_given_to);
            }, $model),
            ],
			[
        		'attribute'=>'outstandingDebt',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) use($loan_given_to) {
               //return $data->getIndividualEmployeesOutstandingDebt($data->applicant_id,$data->loan_summary_id);
			   return \backend\modules\repayment\models\LoanSummaryDetail::getLoaneeOutstandingDebtUnderLoanSummary($data->applicant_id,$data->loan_summary_id,$loan_given_to);
            }, $model),
            ],
						
        ],
    ]) ?>

</div>
    </div>
</div>
