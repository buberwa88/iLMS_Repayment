<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepaymentDetail */

$this->title = 'Update Loan Repayment Batch Detail: ' . $model->loan_repayment_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Batch Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_repayment_detail_id, 'url' => ['view', 'id' => $model->loan_repayment_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-repayment-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
