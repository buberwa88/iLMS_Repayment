<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundPaylistOperationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Paylist Operations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-operation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Refund Paylist Operation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_application_operation_id',
            'refund_paylist_id',
            'refund_internal_operational_id',
            'previous_internal_operational_id',
            'access_role_master',
            // 'access_role_child',
            // 'status',
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
            // 'general_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
