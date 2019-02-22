<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$loan_given_to = \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
<div class="employed-beneficiary-view">
    <?=
    GridView::widget([
        'dataProvider' => \backend\modules\repayment\models\LoanRepaymentDetailSearch::getBeneficiaryRepayment($model->applicant_id),
        'hover' => true,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'payment_date',
                'label' => "Date",
                'value' => function ($model) {
                    return date("d-M-Y", strtotime($model->loanRepayment->payment_date));
                },
            ],
            [
                'attribute' => 'loan_no',
                'label' => "Loan #",
                'value' => function ($model) {
                    return $model->applicant_id;
                },
            ],
            [
                'attribute' => 'bill_number',
                'label' => "Bill #",
                'value' => function ($model) {
                    return $model->loanRepayment->bill_number;
                },
            ],
            [
                'attribute' => 'control_number',
                'label' => "Control #",
                'value' => function ($model) {
                    return $model->loanRepayment->control_number;
                },
            ], [
                'attribute' => 'amount',
                'label' => "Amount",
                'vAlign' => 'middle',
                'hAlign' => 'right',
                'width' => '90px',
                'value' => function ($model) {
                    return number_format($model->amount);
                },
            ], [
                'attribute' => 'receipt_number',
                'label' => "Receipt #",
                'value' => function ($model) {
                    return $model->loanRepayment->receipt_number;
                },
            ],
            [
                'attribute' => 'prepaid_id',
                'label' => "Payment Mode",
                'value' => function ($model) {
                    return ($model->prepaid_id>0?'Pre-paid':'Normal');
                },
            ],
            [
                'attribute' => 'loan_given_to',
                'label' => "Loan Type",
                'value' => function ($model) {
                    return $model->getLoanType();
                },
            ],
            [
                'attribute' => 'payment_status',
                'label' => "Status",
                'value' => function ($model) {

                    return $model->loanRepayment->getPaymentStatus();
                },
            ],
        ],
    ]);
    ?>
</div>
