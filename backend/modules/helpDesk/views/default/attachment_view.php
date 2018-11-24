<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use backend\modules\application\models\VerificationFramework;
use backend\modules\application\models\VerificationFrameworkItem;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\widgets\Select2
 


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">         
            <?php //echo Html::encode($this->title) ?>         
        </div>
        <div class="panel-body">

     <?php
	$resultsPath=\frontend\modules\application\models\ApplicantAttachment::find()->where("application_id = {$model->application_id} AND attachment_definition_id={$model->attachment_definition_id}")->one(); 
        $file_name ='../'.$resultsPath->attachment_path;        
        $file_contents  = @file_get_contents($file_name);
       if($file_contents != NULL){?>
        <p>
          <?php 
            $extension = explode(".",$resultsPath->attachment_path);
            if($extension[1] == 'pdf'){ ?>
               <embed src="<?= '../'.$resultsPath->attachment_path?>" width="900" height="600">
            <?php } 
           else{ 
               ?>
               <img class="img" width="auto" height="auto" src="<?= '../'.$resultsPath->attachment_path?>" alt="">
           <?php } ?>
        </p>
     <?php
        }else{
            echo "<p><front color='red'><b>NO ATTACHEMENT ATTACHED</front></b></p>";
            }		 
      ?>    
</div>
</div>
    </div>
