<?php

use yii\helpers\Html;
use frontend\modules\application\models\Application;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
                        

$this->title ="CONFIRM APPLICATION";
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="application-view">
   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>

   <div class="panel-body">
   
       <div class="callout callout-info">
          <h4><b>Dear <?= $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;?></b></h4>
  <?php 
	 $sqlquest=Yii::$app->db->createCommand('SELECT count(*) FROM `application_cycle` apc join academic_year ac  on apc.`academic_year_id`=ac.`academic_year_id` WHERE application_cycle_status_id=2 AND ac.`academic_year_id`=1')->queryScalar();
	if($sqlquest==0){
	?>
          <p>You are about to confirm your Application, Please click "CONFIRM APPLICATION" button below to proceed. Note that, after confirmation you will not be able to edit the details. If you want to Preview and Edit your details before confirming, navigate to "My Application" in the Menu. Thanks!!!</p>
        </div>

      <div class="row no-print">
        <div class="col-xs-12">

           <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/submit-application','action' => 'submit'])?>"class="btn btn-success pull-right"><i class="fa fa-submit"></i>CONFIRM APPLICATION</a>

        </div>
    </div>
     <?php 
	}
	else{
    ?>
    <div class="alert alert-warning alert-dismissible">
               
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                 <h2>The Application is Currently Closed.</h2>
              </div>
  <?php } ?>