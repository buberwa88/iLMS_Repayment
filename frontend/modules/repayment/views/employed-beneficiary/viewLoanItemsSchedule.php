<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\modules\repayment\models\LoanSummaryDetail;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = "Loan Repayment Schedule Summary";
//$this->params['breadcrumbs'][] = ['label' => 'Loan Details', 'url' => ['all-beneficiaries']];
//$this->params['breadcrumbs'][] = $this->title;
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
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                 return \common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->schedule_principal_amount;
            }, $model),
            ],
			[
        		'attribute'=>'penalty',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data){
                return \common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->schedule_penalty;
            }, $model),
            ],
			[
        		'attribute'=>'LAF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data){
                return \common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->schedule_laf;
            }, $model),
            ],
            [
        		'attribute'=>'VRF',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {
                return \common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->schedule_vrf;
            }, $model),
            ],			
            [
        		'attribute'=>'totalLoan',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data){		
                return \common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->schedule_total_loan_amount;
            }, $model),
            ],
            [
        		'label'=>'Start Date',
                'value'=>call_user_func(function ($data) {		
                return date("d-m-Y",strtotime(\common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->schedule_start_date));
            }, $model),
            ],
            [
        		'label'=>'End Date',
                'value'=>call_user_func(function ($data){		
                return date("d-m-Y",strtotime(\common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->schedule_end_date));
            }, $model),
            ],
            [
        		'label'=>'Monthly Installment',
				'format'=>['decimal',2],
                'value'=>call_user_func(function ($data) {		
                return \common\models\LoanBeneficiary::getScheduleDetail($data->applicant_id)->monthly_installment;
            }, $model),
            ],			

            			
        ],
    ]) ?>

</div>
    </div>
</div>
