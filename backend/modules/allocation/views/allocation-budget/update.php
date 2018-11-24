<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationBudget */

$this->title = 'Update Allocation Budget: #' . $model->allocation_budget_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_budget_id, 'url' => ['view', 'id' => $model->allocation_budget_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="learning-institution-fee-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
