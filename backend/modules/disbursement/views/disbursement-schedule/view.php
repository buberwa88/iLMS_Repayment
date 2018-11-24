<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSchedule */


$this->params['breadcrumbs'][] = ['label' => 'Disbursement Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-schedule-view">
  <div class="panel panel-info">
        <div class="panel-heading">
     
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->disbursement_schedule_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->disbursement_schedule_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'attributes' => [
           // 'disbursement_schedule_id',
            'operator_name',
            'from_amount',
            'to_amount',
//            'created_at',
//            'updated_at',
          //  'created_by',
            //'updated_by',
        ],
    ]) ?>

</div>
  </div>
</div>