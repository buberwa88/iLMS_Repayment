<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */

$this->title = 'Update Loan Repayment Bill: ' . $model->loan_summary_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Bills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_summary_id, 'url' => ['view', 'id' => $model->loan_summary_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-summary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
