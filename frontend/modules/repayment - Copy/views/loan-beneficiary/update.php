<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanBeneficiary */

$this->title = 'Update Loan Beneficiary: ' . $model->loan_beneficiary_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_beneficiary_id, 'url' => ['view', 'id' => $model->loan_beneficiary_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-beneficiary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
