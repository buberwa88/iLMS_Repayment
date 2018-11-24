<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementTaskAssignment */

$this->title = 'Update Disbursement Task Assignment: ';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Task Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "View", 'url' => ['view', 'id' => $model->disbursement_task_assignment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-task-assignment-update">
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