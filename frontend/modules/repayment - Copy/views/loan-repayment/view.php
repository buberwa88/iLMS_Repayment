<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = $model->loan_repayment_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->loan_repayment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->loan_repayment_id], [
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
            'loan_repayment_id',
            'employer_id',
            'applicant_id',
            'repayment_reference_number',
            'control_number',
            'amount',
            'receipt_number',
            'pay_method_id',
            'pay_phone_number',
            'date_bill_generated',
            'date_control_received',
            'date_receipt_received',
        ],
    ]) ?>

</div>
