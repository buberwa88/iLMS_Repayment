<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */

$this->title = 'Update Loan Repayment Batch: ' . $model->loan_repayment_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Repayment Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_repayment_id, 'url' => ['view', 'id' => $model->loan_repayment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-repayment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
