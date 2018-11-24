
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = "Profile Details";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'user_id',
            'firstname',
            'middlename',
            'surname',
            'sex',
            'username',
           // 'password_hash',
           // 'security_question_id',
         //   'security_answer',
            'email_address:email',
         //   'passport_photo',
            'phone_number',
//            'is_default_password',
//            'status',
//            'status_comment:ntext',
//            'login_counts',
//            'last_login_date',
//            'date_password_changed',
//            'auth_key',
//            'password_reset_token',
//            'activation_email_sent:email',
//            'email_verified:email',
//            'created_at',
//            'updated_at',
//            'created_by',
//            'login_type',
        ],
    ]) ?>

</div>