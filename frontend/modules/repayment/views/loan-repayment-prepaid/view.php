<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentPrepaid */

$this->title = $model->prepaid_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Prepaids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-prepaid-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->prepaid_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->prepaid_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'prepaid_id',
            'employer_id',
            'applicant_id',
            'loan_summary_id',
            'monthly_amount',
            'payment_date',
            'created_at',
            'created_by',
            'bill_number',
            'control_number',
            'receipt_number',
            'date_bill_generated',
            'date_control_received',
            'receipt_date',
            'date_receipt_received',
            'payment_status',
            'cancelled_by',
            'cancelled_at',
            'cancel_reason',
            'gepg_cancel_request_status',
            'monthly_deduction_status',
            'date_deducted',
        ],
    ]) ?>

</div>
