<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationHistory */

$this->title = 'Update Allocation History: ' . $model->loan_allocation_history_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->loan_allocation_history_id, 'url' => ['view', 'id' => $model->loan_allocation_history_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
