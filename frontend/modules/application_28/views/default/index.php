<?php
use yii\helpers\Html;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Applicant;

$user_id = Yii::$app->user->identity->id;
$modelUser = common\models\User::findone($user_id);
$this->title = "Welcome (".strtoupper($modelUser->firstname).' '.strtoupper($modelUser->middlename).' '.strtoupper($modelUser->surname).")";
$this->params['breadcrumbs'][] = 'My Application';
//$checkstatus=  \common\models\Education::find
           $user_id = Yii::$app->user->identity->id;
           $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
           $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
          $parent_count= ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' ")->count();
           $guardian_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GD' ")->count();
          $guarantor_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GA' ")->count();
           ?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>

<p class='alert alert-info'>
    Your application is not yet completed. Please complete all the stages shown with 'Red Cross'. You are adviced to review your application thorough before printing as you 
    will not be able to change it again 
</p>
