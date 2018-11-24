<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;

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
        $file_name = '../'.$model->attachment_path;
        $file_contents  = @file_get_contents($file_name);
       if($file_contents != NULL){?>
        <p>
           <iframe src="../<?=$model->attachment_path?>" style="width:900px; height:300px;" frameborder="0"></iframe>
        </p>
     <?php
        }else{
            echo "<p><front color='red'><b>NO ATTACHEMENT ATTACHED</front></b></p>";
            }  

         echo "<p>Applicant Fullname:- <b>".$fullname."</b></p>";    
      ?>

     <div class="bank-form">

       <?php 
         $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); 
       ?>
  <div class="col-lg-12">
    <?php
       echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [                 
            'verification_status' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ApplicantQuestion::getVerificationStatus(), 
                'options' => ['prompt' => '-- Select --'],
              ],
            'comment' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['placeholder' => 'Enter Comment'],
              ],
              'applicant_attachment_id'=>[
                    'type'=>Form::INPUT_HIDDEN, 
                ],
          ]
    ]);
       ?>
  </div>
    <div class="pull-right">
      <?php
    echo Html::submitButton('Submit', ['class' => 'btn btn-success']);
    ActiveForm::end();
   ?>
    </div>
     </div>
</div>
</div>
