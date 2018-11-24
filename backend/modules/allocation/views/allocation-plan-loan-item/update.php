<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanLoanItem */

$this->title = 'Update Allocation Plan Loan Item: ' . $model->allocation_plan_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Loan Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_plan_id, 'url' => ['view', 'allocation_plan_id' => $model->allocation_plan_id, 'loan_item_id' => $model->loan_item_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-plan-loan-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
