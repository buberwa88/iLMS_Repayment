<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentPrepaidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Repayment Prepaids';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-prepaid-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Loan Repayment Prepaid', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'prepaid_id',
            'employer_id',
            'applicant_id',
            'loan_summary_id',
            'monthly_amount',
            // 'payment_date',
            // 'created_at',
            // 'created_by',
            // 'bill_number',
            // 'control_number',
            // 'receipt_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'receipt_date',
            // 'date_receipt_received',
            // 'payment_status',
            // 'cancelled_by',
            // 'cancelled_at',
            // 'cancel_reason',
            // 'gepg_cancel_request_status',
            // 'monthly_deduction_status',
            // 'date_deducted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
