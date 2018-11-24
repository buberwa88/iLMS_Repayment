<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetail */

$this->title = $model->loan_repayment_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Batch Details', 'url' => ['bills-payments']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-detail-view">

<div class="panel panel-info">
        <div class="panel-heading">
        </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->loan_repayment_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->loan_repayment_detail_id], [
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
            'loan_repayment_detail_id',
            'loan_repayment_id',
            'applicant_id',
            'loan_repayment_item_id',
            'amount',
            'loan_summary_id',
        ],
    ]) ?>

</div>
    </div>
</div>
