<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructure */

$this->title ='Allocation Staff to Allocation Structure';
$this->params['breadcrumbs'][] = ['label' => 'Allocation User Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-user-structure-view">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title); ?>
        </div>
        <div class="panel-body">
          <p>
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
      </p>
<?php 
    $gridColumn = [
       // 'allocation_user_structure_id',
        [
            'attribute' => 'allocationStructure.structure_name',
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
  
    <?php 
    $gridColumnUser = [
        'firstname',
        'middlename',
        'surname',
        'sex',
      //  'username',
       /* 'password_hash',
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
        'login_type',*/
    ];
    echo DetailView::widget([
        'model' => $model->user,
        'attributes' => $gridColumnUser    ]);
    ?>
   </div>
   </div>
    