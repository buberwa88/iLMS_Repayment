<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

$loan_given_to = \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$loan_given_toThroughEmployer = \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;

$resultAcademicTrendSubTotalThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($model->applicant_id);
 foreach ($resultAcademicTrendSubTotalThroughEmployer as $resultsAmountSubtotal2) {
 $academic_yearIDQR=$resultsAmountSubtotal2->disbursementBatch->academic_year_id;
 $SubTotalAmount2ThroughEmployer = \common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYThroughEmployer($model->applicant_id,$academic_yearIDQR);
 $subtitalAccqThroughEmployer +=$SubTotalAmount2ThroughEmployer->disbursed_amount;
 }
$date = date("Y-m-d");
$amountPaidThroughEmployer=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($model->applicant_id,$date,$loan_given_toThroughEmployer);
$vrfThroughEmpl=\backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginalGivenToApplicantTrhEmployer($model->applicant_id,$date,$loan_given_toThroughEmployer);
$throghemployerBalance=($subtitalAccqThroughEmployer + $vrfThroughEmpl) - $amountPaidThroughEmployer;
?>
<div class="employed-beneficiary-view">
    <h4><b>Loan Given to Student</b></h4>
    <?php
    $attributes = [
        [
            'columns' => [

                [
                    'label' => 'Disbursement',
                    'value' => call_user_func(function ($data) {
                        if (\common\models\LoanBeneficiary::getPrinciplePlusReturn($data->applicant_id) != '') {
                            return \common\models\LoanBeneficiary::getPrinciplePlusReturn($data->applicant_id);
                        } else {
                            return 0;
                        }
                    }, $model),
                    'labelColOptions' => ['style' => 'width:20%'],
                    'valueColOptions' => ['style' => 'width:30%'],
                    'format' => ['decimal', 2],
                ],
                [
                    'label' => 'Return',
                    'value' => call_user_func(function ($data) {
                        if (\common\models\LoanBeneficiary::getAmountReturned($data->applicant_id) != '') {
                            return \common\models\LoanBeneficiary::getAmountReturned($data->applicant_id);
                        } else {
                            return 0;
                        }
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
                    'label' => 'Repayment',
                    'value' => call_user_func(function ($data) use($loan_given_to) {
                        $date = date("Y-m-d");
                        return \frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($data->applicant_id, $date, $loan_given_to);
                    }, $model),
                    'labelColOptions' => ['style' => 'width:20%'],
                    'valueColOptions' => ['style' => 'width:30%'],
                    'format' => ['decimal', 2],
                ],
                [
                    'label' => 'Principal',
                    'value' => call_user_func(function ($data) use($loan_given_to) {
                        $date = date("Y-m-d");
                        return backend\modules\repayment\models\LoanSummaryDetail::getTotalPrincipleLoanOriginal($data->applicant_id, $date, $loan_given_to);
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
                    'label' => 'VRF',
                    'value' => call_user_func(function ($data) use($loan_given_to) {
                        $date = date("Y-m-d");
                        return backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($data->applicant_id, $date, $loan_given_to);
                    }, $model),
                    'labelColOptions' => ['style' => 'width:20%'],
                    'valueColOptions' => ['style' => 'width:30%'],
                    'format' => ['decimal', 2],
                ],
                [
                    'label' => 'Penalty',
                    'value' => call_user_func(function ($data) use($loan_given_to) {
                        $date = date("Y-m-d");
                        return backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($data->applicant_id, $date, $loan_given_to);
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
                    'value' => call_user_func(function ($data) use($loan_given_to) {
                        $date = date("Y-m-d");
                        return backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($data->applicant_id, $date, $loan_given_to);
                    }, $model),
                    'labelColOptions' => ['style' => 'width:20%'],
                    'valueColOptions' => ['style' => 'width:30%'],
                    'format' => ['decimal', 2],
                ],
                [
                    'label' => 'Refund',
                    'value' => call_user_func(function ($data) {

                        return 0;
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
                    'label' => 'Balance',
                    'value' => call_user_func(function ($data) use($loan_given_to) {
                        $date = date("Y-m-d");
                        return \frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($data->applicant_id, $date, $loan_given_to);
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
    ?>

    <br/>

    <h4><b>Loan Given to Student Through Employer</b></h4>
    <?php
    $attributes = [
        [
            'columns' => [

                [
                    'label' => 'Disbursement',
                    'value' => call_user_func(function ($data) use($subtitalAccqThroughEmployer) {
                            return $subtitalAccqThroughEmployer;
                    }, $model),
                    'labelColOptions' => ['style' => 'width:20%'],
                    'valueColOptions' => ['style' => 'width:30%'],
                    'format' => ['decimal', 2],
                ],
                [
                    'label' => 'Return',
                    'value' => call_user_func(function ($data) {

                            return 0;

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
                    'label' => 'Repayment',
                    'value' => call_user_func(function ($data) use($amountPaidThroughEmployer) {
                        $date = date("Y-m-d");
                        return $amountPaidThroughEmployer;
                    }, $model),
                    'labelColOptions' => ['style' => 'width:20%'],
                    'valueColOptions' => ['style' => 'width:30%'],
                    'format' => ['decimal', 2],
                ],
                [
                    'label' => 'Principal',
                    'value' => call_user_func(function ($data) use($subtitalAccqThroughEmployer) {
                        $date = date("Y-m-d");
                        return $subtitalAccqThroughEmployer;
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
                    'label' => 'VRF',
                    'value' => call_user_func(function ($data) use($vrfThroughEmpl) {
                        $date = date("Y-m-d");
                        return $vrfThroughEmpl;
                    }, $model),
                    'labelColOptions' => ['style' => 'width:20%'],
                    'format' => ['decimal', 2],
                ],

            ],
        ],
        [
            'columns' => [

                [
                    'label' => 'Balance',
                    'value' => call_user_func(function ($data) use($throghemployerBalance) {
                        $date = date("Y-m-d");
                        return $throghemployerBalance;
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
    ?>
</div>
