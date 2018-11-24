<?php

use yii\helpers\Html;
use frontend\modules\application\models\Application;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
                        

$this->title ="SUBMITTING APPLICATION";
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

          <p>You are about to submit your Application, Please click "SUBMIT APPLICATION" button below to proceed. Thanks!!!</p>
        </div>

      <div class="row no-print">
        <div class="col-xs-12">

           <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/close-my-application','action' => 'close'])?>"class="btn btn-success pull-right"><i class="fa fa-submit"></i>SUBMIT APPLICATION</a>

        </div>
    </div>
