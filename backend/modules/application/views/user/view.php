<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title ="View Applicant Details";
$this->params['breadcrumbs'][] = ['label' => 'List of Applicant', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'user_id',
            'firstname',
            'middlename',
            'surname',
            'sex',
            'username',
//            'password_hash',
//            'security_question_id',
//            'security_answer',
            'email_address:email',
           // 'passport_photo',
            'phone_number',
           // 'is_default_password',
           // 'status',
           // 'status_comment:ntext',
           // 'login_counts',
          //  'last_login_date',
         //   'date_password_changed',
         //   'auth_key',
           // 'password_reset_token',
           // 'activation_email_sent:email',
          //  'email_verified:email',
           // 'created_at',
           // 'updated_at',
          //  'created_by',
           // 'login_type',
        ],
    ]) ?>
  <?= DetailView::widget([
        'model' => $modelApplicant,
        'attributes' => [
            //'applicant_id',
           // 'user_id',
            'NID',
            'f4indexno',
          //  'f6indexno',
            'mailing_address',
            'date_of_birth',
          //  'place_of_birth',
           // 'loan_repayment_bill_requested',
        ],
    ]) ?>
        </div>
</div>
</div>
