<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementTaskAssignment */

$this->title = "View Disbursement Task Assignment";
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Task Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-task-assignment-view">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?><?= Html::a('Return Back', ['index','id'=>$model->disbursement_schedule_id], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->disbursement_task_assignment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->disbursement_task_assignment_id], [
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
           // 'disbursement_task_assignment_id',
            //'disbursement_schedule_id',
            'disbursementStructure.structure_name',
            'disbursementTask.task_name',
            /*'created_at',
            'updated_at',
            'created_by',
            'updated_by',*/
          //  'deleted_by',
           // 'deleted_at',
        ],
    ]) ?>

</div>
  </div>
</div>