<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanLoanItem */

$this->title = $model->allocation_plan_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Loan Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-loan-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'allocation_plan_id' => $model->allocation_plan_id, 'loan_item_id' => $model->loan_item_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'allocation_plan_id' => $model->allocation_plan_id, 'loan_item_id' => $model->loan_item_id], [
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
            'allocation_plan_id',
            'loan_item_id',
            'priority_order',
            'rate_type',
            'unit_amount',
            'duration',
            'loan_award_percentage',
            'created_at',
        ],
    ]) ?>

</div>
