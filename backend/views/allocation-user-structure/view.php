<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructure */

$this->title = $model->allocation_user_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation User Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-user-structure-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Allocation User Structure'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->allocation_user_structure_id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->allocation_user_structure_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->allocation_user_structure_id], [
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
        'allocation_user_structure_id',
        [
            'attribute' => 'allocationStructure.allocation_structure_id',
            'label' => 'Allocation Structure',
        ],
        [
            'attribute' => 'user.username',
            'label' => 'User',
        ],
        'status',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>User<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnUser = [
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
    ];
    echo DetailView::widget([
        'model' => $model->user,
        'attributes' => $gridColumnUser    ]);
    ?>
    <div class="row">
        <h4>AllocationStructure<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnAllocationStructure = [
        'structure_name',
        'parent_id',
        'order_level',
        'status',
    ];
    echo DetailView::widget([
        'model' => $model->allocationStructure,
        'attributes' => $gridColumnAllocationStructure    ]);
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
    ];
    echo DetailView::widget([
        'model' => $model->updatedBy,
        'attributes' => $gridColumnUser    ]);
    ?>
</div>
