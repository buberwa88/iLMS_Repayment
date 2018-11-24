<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSchedule */

$this->title = 'Update Disbursement Schedule: ' . $model->disbursement_schedule_id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->disbursement_schedule_id, 'url' => ['view', 'id' => $model->disbursement_schedule_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
