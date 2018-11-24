<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationTask */

$this->title = 'Update Allocation Task: ' . ' ' . $model->allocation_task_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_task_id, 'url' => ['view', 'id' => $model->allocation_task_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
