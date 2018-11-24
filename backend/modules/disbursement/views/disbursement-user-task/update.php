<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementUserTask */

$this->title = 'Update Disbursement User Task: ';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement User Tasks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => "View ", 'url' => ['view', 'id' => $model->disbursement_user_task_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-user-task-update">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
  </div>
</div>