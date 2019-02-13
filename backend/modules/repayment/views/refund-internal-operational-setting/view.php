<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundInternalOperationalSetting */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Refund Internal Operational Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-internal-operational-setting-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Refund Internal Operational Setting'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->refund_internal_operational_id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->refund_internal_operational_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->refund_internal_operational_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'refund_internal_operational_id',
        'name',
        'code',
        'access_role_master',
        'access_role_child',
        'flow_order_list',
        'is_active',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerRefundApplicationOperation->totalCount){
    $gridColumnRefundApplicationOperation = [
        ['class' => 'yii\grid\SerialColumn'],
            'refund_application_operation_id',
            [
                'attribute' => 'refundApplication.refund_application_id',
                'label' => 'Refund Application'
            ],
                        'access_role',
            'status',
            [
                'attribute' => 'refundStatusReasonSetting.refund_comment_id',
                'label' => 'Refund Status Reason Setting'
            ],
            'narration',
            [
                'attribute' => 'assignee0.username',
                'label' => 'Assignee'
            ],
            'assigned_at',
            [
                'attribute' => 'assignedBy.username',
                'label' => 'Assigned By'
            ],
            [
                'attribute' => 'lastVerifiedBy.username',
                'label' => 'Last Verified By'
            ],
            'is_current_stage',
            'date_verified',
            'is_active',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerRefundApplicationOperation,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-refund-application-operation']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Refund Application Operation'),
        ],
        'export' => false,
        'columns' => $gridColumnRefundApplicationOperation
    ]);
}
?>

    </div>
    <div class="row">
        <h4>User<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnUser = [
        'user_id',
        'firstname',
        'middlename',
        'surname',
        'sex',
        'username',
        'password_hash',
        'password_hash1',
        'security_question_id',
        'security_answer',
        'email_address',
        'passport_photo',
        'phone_number',
        'is_default_password',
        'status',
        'status_comment',
        'login_counts',
        'last_login_date',
        'date_password_changed',
        'auth_key',
        'password_reset_token',
        'activation_email_sent',
        'email_verified',
        'login_type',
        'other_id',
        'is_migration_data',
        'ouser_id',
    ];
    echo DetailView::widget([
        'model' => $model->createdBy,
        'attributes' => $gridColumnUser    ]);
    ?>
    <div class="row">
        <h4>User<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnUser = [
        'user_id',
        'firstname',
        'middlename',
        'surname',
        'sex',
        'username',
        'password_hash',
        'password_hash1',
        'security_question_id',
        'security_answer',
        'email_address',
        'passport_photo',
        'phone_number',
        'is_default_password',
        'status',
        'status_comment',
        'login_counts',
        'last_login_date',
        'date_password_changed',
        'auth_key',
        'password_reset_token',
        'activation_email_sent',
        'email_verified',
        'login_type',
        'other_id',
        'is_migration_data',
        'ouser_id',
    ];
    echo DetailView::widget([
        'model' => $model->updatedBy,
        'attributes' => $gridColumnUser    ]);
    ?>
</div>
