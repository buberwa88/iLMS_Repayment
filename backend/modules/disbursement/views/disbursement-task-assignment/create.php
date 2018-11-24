<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementTaskAssignment */

$this->title = 'Create Disbursement Task Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Task Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-task-assignment-create">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'disbursement_schedule_id'=>$disbursement_schedule_id
            ])
            ?>

        </div>
    </div>
</div>