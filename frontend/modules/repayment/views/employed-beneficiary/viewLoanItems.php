<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\modules\repayment\models\LoanSummaryDetail;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = "Loan Details";
//$this->params['breadcrumbs'][] = ['label' => 'Loan Details', 'url' => ['all-beneficiaries']];
//$this->params['breadcrumbs'][] = $this->title;
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
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return \backend\modules\repayment\models\LoanSummaryDetail::getTotalPrincipleLoanOriginal($data->applicant_id);
            }, $model),
            ],
			[
        		'attribute'=>'penalty',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return \backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($data->applicant_id);
            }, $model),
            ],
			[
        		'attribute'=>'LAF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return \backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($data->applicant_id);
            }, $model),
            ],
            [
        		'attribute'=>'VRF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
					$date=date("Y-m-d");
                return \backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($data->applicant_id,$date);
            }, $model),
            ],			
            [
        		'attribute'=>'totalLoan',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
			    $date=date("Y-m-d");		
                return \backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($data->applicant_id,$date);
            }, $model),
            ],	

            [
        		'attribute'=>'paid',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($data->applicant_id);
            }, $model),
            ],			
            [
        		'attribute'=>'outstanding',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
				$date=date("Y-m-d");	
                return frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($data->applicant_id,$date);
            }, $model),
            ],			
        ],
    ]) ?>

</div>
    </div>
</div>
