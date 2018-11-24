<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSchedule */

$this->title = 'Update Disbursement Schedule: ';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'View ', 'url' => ['view', 'id' => $model->disbursement_schedule_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-schedule-update">
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