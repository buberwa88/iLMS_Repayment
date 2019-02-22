<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundApplicationOperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Application Operations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-application-operation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Refund Application Operation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_application_operation_id',
            'refund_application_id',
            'refund_internal_operational_id',
            'access_role',
            'status',
            // 'refund_status_reason_setting_id',
            // 'narration',
            // 'assignee',
            // 'assigned_at',
            // 'assigned_by',
            // 'last_verified_by',
            // 'is_current_stage',
            // 'date_verified',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
