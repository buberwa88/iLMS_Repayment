<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

$loan_given_to = \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
    <h4><b>Loan Items</b></h4>
<?php

$attributes = [
    [
        'columns' => [

            [
                'label' => 'Principal',
                'value'=>call_user_func(function ($data) {
					if($data->applicant_id !=''){
					return \frontend\modules\repayment\models\LoanRepaymentDetail::getPrincipalLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
				}else{
				return $data->amount;	
				}
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
                'format' => ['decimal', 2],
            ],
            [
                'label' => 'Penalty',
                'value'=>call_user_func(function ($data) {
				return \frontend\modules\repayment\models\LoanRepaymentDetail::getPenaltyLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
                'format' => ['decimal', 2],
            //'filter' => Lookup::items('SubjectType'),
            ],
        ],
    ],
    [
        'columns' => [

            [
                'label' => 'LAF',
                'value'=>call_user_func(function ($data) {
					return \frontend\modules\repayment\models\LoanRepaymentDetail::getLAFLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
                'format' => ['decimal', 2],
            ],
            [
                'label' => 'VRF',
                'value'=>call_user_func(function ($data) {
				return \frontend\modules\repayment\models\LoanRepaymentDetail::getVRFLoanPaidPerBill($data->applicant_id,$data->loan_repayment_id);
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
                'format' => ['decimal', 2],
            //'filter' => Lookup::items('SubjectType'),
            ],
        ],
    ],
];
echo DetailView::widget([
    'model' => $model,
    'condensed' => true,
    'hover' => true,
    'mode' => DetailView::MODE_VIEW,
    'attributes' => $attributes,
]);
