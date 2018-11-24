<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanBeneficiary */

$this->title = 'Update Loan Beneficiary';
$this->params['breadcrumbs'][] = ['label' => 'Loan Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_beneficiary_id, 'url' => ['view', 'id' => $model->loan_beneficiary_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="loan-beneficiary-update">
<div class="panel panel-info">
        <div class="panel-heading">

        </div>
        <div class="panel-body">

    <?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
