<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementTask */

$this->title = 'Update Disbursement Task: ';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Tasks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->disbursement_task_id, 'url' => ['view', 'id' => $model->disbursement_task_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-task-update">
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