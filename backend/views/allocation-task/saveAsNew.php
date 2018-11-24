<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationTask */

$this->title = 'Save As New Allocation Task: '. ' ' . $model->allocation_task_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_task_id, 'url' => ['view', 'id' => $model->allocation_task_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="allocation-task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
