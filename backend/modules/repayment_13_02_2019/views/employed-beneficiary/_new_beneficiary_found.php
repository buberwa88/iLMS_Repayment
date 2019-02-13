<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

$loan_given_to = \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
    <h4><b>Loan Details</b></h4>
<?php

$attributes = [
    [
        'columns' => [

            [
                'label' => 'Principal',
                'value'=>call_user_func(function ($data) use($loan_given_to) {
					$date=date("Y-m-d");
				return (\backend\modules\repayment\models\LoanSummaryDetail::getTotalPrincipleLoanOriginal($data->applicant_id,$date,$loan_given_to));
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
                'format' => ['decimal', 2],
            ],
            [
                'label' => 'Penalty',
                'value'=>call_user_func(function ($data) use($loan_given_to) {
					$date=date("Y-m-d");
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($data->applicant_id,$date,$loan_given_to);
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
                'value'=>call_user_func(function ($data) use($loan_given_to) {
					$date=date("Y-m-d");
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($data->applicant_id,$date,$loan_given_to);
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
                'format' => ['decimal', 2],
            ],
            [
                'label' => 'VRF',
                'value'=>call_user_func(function ($data) use($loan_given_to) {
					 $date=date("Y-m-d");
                return (\backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($data->applicant_id,$date,$loan_given_to));
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
                'label' => 'Total Loan',
                'value'=>call_user_func(function ($data) use($loan_given_to) {
					$date=date("Y-m-d");
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($data->applicant_id,$date,$loan_given_to);
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
                'format' => ['decimal', 2],
            ],
            [
                'label' => 'Paid',
                'value'=>call_user_func(function ($data) use($loan_given_to) {
					$date=date("Y-m-d");
                return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($data->applicant_id,$date,$loan_given_to);
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
                'label' => 'Outstanding',
                'value'=>call_user_func(function ($data) use($loan_given_to) {
			    $date=date("Y-m-d");		
                return \frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($data->applicant_id,$date,$loan_given_to);
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'format' => ['decimal', 2],
            //'valueColOptions'=>['style'=>'width:30%'],
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
