<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationTask */

$this->title = 'Update Allocation Task: ';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '', 'url' => ['view', 'id' => $model->allocation_task_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-task-update">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title); ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>