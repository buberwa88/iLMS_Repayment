<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummaryDetail */

$this->title = 'Update Loan Repayment Bill Detail: ' . $model->loan_summary_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Bill Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_summary_detail_id, 'url' => ['view', 'id' => $model->loan_summary_detail_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-summary-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
