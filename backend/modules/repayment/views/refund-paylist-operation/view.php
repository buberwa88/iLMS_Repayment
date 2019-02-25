<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistOperation */

$this->title = $model->refund_application_operation_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Paylist Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-operation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->refund_application_operation_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->refund_application_operation_id], [
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
            'refund_application_operation_id',
            'refund_paylist_id',
            'refund_internal_operational_id',
            'previous_internal_operational_id',
            'access_role_master',
            'access_role_child',
            'status',
            'narration',
            'assignee',
            'assigned_at',
            'assigned_by',
            'last_verified_by',
            'is_current_stage',
            'date_verified',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'is_active',
            'general_status',
        ],
    ]) ?>

</div>
