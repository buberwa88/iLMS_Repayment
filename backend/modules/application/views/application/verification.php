
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
	$resultsPath=\backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($model->attachment_definition_id,$application_id); 
        $file_name ='../'.$resultsPath->attachment_path;
        $file_contents  = @file_get_contents($file_name);
       if($file_contents != NULL){?>
        <p>
          <?php 
            $extension = explode(".",$resultsPath->attachment_path);
            if($extension[1] == 'pdf'){ ?>
               <embed src="<?= '../'.$resultsPath->attachment_path?>" width="900" height="600">
            <?php } 
           else{ ?>
               <img class="img" width="auto" height="auto" src="<?= '../'.$resultsPath->attachment_path?>" alt="">
           <?php } ?>
        </p>
     <?php
        }else{
            echo "<p><front color='red'><b>NO ATTACHEMENT ATTACHED</front></b></p>";
            }  

         echo "<p>Applicant Fullname:- <b>".$fullname."</b></p>";    
      ?>

     <div class="bank-form">

       <?php
       if($released==NULL OR $released==''){ 
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
/*
            'comment' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['placeholder' => 'Enter Comment'],
              ],
*/
/*
             'comment' => [
'type' => Form::INPUT_DROPDOWN_LIST,
'items' => VerificationFramework::getVerificationComments(), 
'options' => ['prompt' => '-- Select --'],
],
*/

/*
'comment' => [
                'label' => 'Comment',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ArrayHelper::map(\backend\modules\application\models\VerificationComment::find()->asArray()->all(), 'comment', 'comment'), 'options' => ['prompt' => '-- Select --'],
                'options' => ['prompt' => '-- Select --'],
            ],

*/

/*
'comment' => [
                'label' => 'Comment',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ArrayHelper::map(\backend\modules\application\models\VerificationComment::findBySql('SELECT verification_comment_id AS "comment",CONCAT(verification_comment_group.comment_group,"-",verification_comment.comment) AS "Name" FROM `verification_comment` LEFT JOIN verification_comment_group ON verification_comment_group.verification_comment_group_id=verification_comment.verification_comment_group_id')->asArray()->all(), 'comment', 'Name'), 'options' => ['prompt' => '-- Select --'],
                'options' => ['prompt' => '-- Select --'],
            ],
*/
'comment' => [
                'label' => 'Comment',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ArrayHelper::map(\backend\modules\application\models\VerificationComment::findBySql('SELECT  verification_comment_group.verification_comment_group_id AS "comment",verification_comment_group.comment_group AS "Name" FROM `verification_comment` LEFT JOIN verification_comment_group ON verification_comment_group.verification_comment_group_id=verification_comment.verification_comment_group_id WHERE verification_comment.attachment_definition_id="'.$model->attachment_definition_id.'" AND verification_comment.is_active="1"')->asArray()->all(), 'comment', 'Name'), 'options' => ['prompt' => '-- Select --'],
                'options' => ['prompt' => '-- Select --'],
            ],

			  /*
              'applicant_attachment_id'=>[
                    'type'=>Form::INPUT_HIDDEN, 
                ],
				*/
          ]
    ]);
       ?>
	   
<?= $form->field($model, 'applicant_attachment_id')->label(FALSE)->hiddenInput(["value" =>$resultsPath->applicant_attachment_id]) ?>
<?php      
      $verfctionCriteriaStatus=\backend\modules\application\models\VerificationFrameworkItem::getVerificationCriteriaStatus($application_id);
      
      ?>
      <?= $form->field($model, 'attachment_definition_id')->label(FALSE)->hiddenInput(["value" =>$model->attachment_definition_id]) ?>
      <?= $form->field($model, 'verification_framework_id')->label(FALSE)->hiddenInput(["value" =>$model->verification_framework_id]) ?>
      <?= $form->field($model, 'verification_criteria_status')->label(FALSE)->hiddenInput(["value" =>$verfctionCriteriaStatus]) ?>
      <?= $form->field($model, 'attachment_path')->label(FALSE)->hiddenInput(["value" =>$resultsPath->attachment_path]) ?>
      <?= $form->field($model, 'other_description')->textInput(['maxlength' => true]) ?>
      <?php 
      
      $a = strtoupper($model->attachmentDefinition->attachment_desc);
        if (strpos($a, 'SPONSOR') !== false) {
            ?>
      <?= $form->field($model, 'sponsor_address')->textInput(['maxlength' => true]) ?>
      <?php
        }      
      ?>

  </div>
    <div class="pull-right">
      <?php
    echo Html::submitButton('Submit', ['class' => 'btn btn-success']);
    ActiveForm::end();
}
   ?>
    </div>
     </div>
</div>
</div>
