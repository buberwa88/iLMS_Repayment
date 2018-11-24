<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPriority */

$this->title = 'Update Allocation Priority: ' . $model->allocation_priority_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Priorities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_priority_id, 'url' => ['view', 'id' => $model->allocation_priority_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-priority-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
