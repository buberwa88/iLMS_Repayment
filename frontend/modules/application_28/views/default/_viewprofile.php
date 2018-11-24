
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = "Basic  Details";
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
    ]); 
      
?>
    <?= DetailView::widget([
        'model' => $modelall,
        'attributes' => [
            'identificationType.identification_type',
            'NID',
          //  'f4indexno',
          //  'f6indexno',
            'mailing_address',
            'date_of_birth',
            'ward.district.region.region_name',
            'ward.district.district_name',
            'ward.ward_name',
 
        ],
    ]); 
                     if($modelall->place_of_birth>0||$modelall->date_of_birth!=""){
                        $label="  edit information";    
                     }
                     else{
                         $label="  add more information";
                     }
     ?>
    <p>
        <?= Html::a("Click to $label", ['updateprofile', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        
    </p>
</div>