<?php

use yii\helpers\Html;
use frontend\modules\application\models\Application;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
                        

$this->title ="DOWNLOAD LOAN APPLICATION FORM";
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="application-view">
   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>

   <div class="panel-body">

       <div class="callout callout-success">
          <h4><b>Dear <?= $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;?></b></h4>
  
          <p>Please click the "Download Loan Application Form(PDF) button below to download the Application Form for Signatures and Certification processes". Thanks!!!</p>
        </div>

      <div class="row no-print">
        <div class="col-xs-12">

              <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/application-form'])?>" target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Download Loan Application Form(PDF)</a>


        </div>
    </div>
