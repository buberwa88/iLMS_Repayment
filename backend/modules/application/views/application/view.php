<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

$this->title ="Application Verification";
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => Yii::$app->request->referrer];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
<div class="application-view">
   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
          <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/preview-application-form','id'=>$model->application_id])?>"target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-eye"></i> Preview PDF Form</a>
        </div>


   <div class="panel-body">

    <div class="row" style="margin: 1%;">

        <div class="col-xs-4">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">APPLICANT PHOTO</h3>
                </div>     
               <img class="img" src="<?= '../'.$model->passport_photo?>" alt="">
          </div>
        </div>
        <div class="col-xs-8">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">APPLICANT DETAILS</h3>
              </div>     
               <?php $fullname = $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;
			   $application_id1=$application_id;
                           $released=$released;
                           $verificationStatus1=$verificationStatus;
			   ?>   
               <p>
                 &nbsp;Full Name:-<b><?= $fullname;?></b><br/>
                 &nbsp;Form IV Index No:- <b><?= $model->applicant->f4indexno;?></b><br/>
                 <br/><br/><br/>
              </p>
          </div>
        </div>
        
    </div>
           

<div class="row" style="margin: 1%;">        
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">CUSTOM CRITERIA:<strong><?php 
                  $verificationFramework=backend\modules\application\models\VerificationCustomCriteria::getFramework($model->verification_framework_id,$model->applicant_category_id);
                  echo Html::label(" Framework ID: ".$verificationFramework->verification_framework_title, NULL, ['class'=>'label label-success']); ?></strong></h3>
              </div>     
               <?php $results=backend\modules\application\models\VerificationCustomCriteria::getActiveCustomerCriteria($model->verification_framework_id,$model->applicant_category_id); 
               ?>   
               <p>
                   <table class="table table-striped table-bordered detail-view" id="w1">
                <tbody>
                    <tr>
                        <td><strong>Criteria</strong></td>
                        <td><strong>Operator</strong></td>
                        <td><strong>Value</strong></td>
                        <td><strong>Education Level</strong></td>
                       <td><strong>Applicant Value</strong></td>
                        <td><strong>General Status</strong></td>
                    </tr>
                 <?php

$i=0;
$generalCriteriaValue=1;
if(count($results) >0){
if($verificationStatus1 !=1){
 foreach($results AS $values){
                   $tableName=$values->applicant_source_table; $tableColumn=$values->applicant_souce_column; $tableColumnValue=$values->applicant_source_value;$operator=$values->operator;$applicationID=$model->application_id;$applicantID=$model->applicant_id;$level=$values->level;
                   if($tableName=='applicant'){
                  $resultsFinal=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteria2($tableName,$tableColumn,$tableColumnValue,$operator,$applicantID);   
                 $resultsFinalFound=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteria2Found($tableName,$tableColumn,$tableColumnValue,$operator,$applicantID,$applicationID); 
                  }else if($tableName=='education'){ 
                 $resultsFinal=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteriaEducation($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID,$level);
                 $resultsFinalFound=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteriaFoundEducation($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID,$level);
                  }else{
                  $resultsFinal=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteria($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID);
                 $resultsFinalFound=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteriaFound($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID); 
                  
                  }
                  ?>
                    <tr>
                        <td><?php echo $values->criteria_name; ?></td>
                        <td><?php echo $values->operator; ?></td>
                        <td><?php echo $values->applicant_source_value; ?></td>

<td><?php 
if($values->level=="NONE"){
  echo "";  
}else{
  echo $values->level;  
}
 ?></td>

                        <td><?php echo $resultsFinalFound; ?></td>
                        <td><?php    
                        if($resultsFinal==1){
                           echo Html::label("OK", NULL, ['class'=>'label label-success']); 
                        }else{
                            //echo "Failed";
                            echo Html::label("Failed", NULL, ['class'=>'label label-danger']);

$generalCriteriaValue=0;

                        }
                        ?></td>
                    </tr>               
                      
                  <?php   

++$i;
$results_check_criteria_general =$generalCriteriaValue;

                 }

}else{
    $passedCriteria=backend\modules\application\models\VerificationCustomCriteriaPassed::getVerificationCriteriaPassed($model->application_id,$model->verification_framework_id);
                                      foreach($passedCriteria AS $valuesPassedCriteria){
                                          
$tableName=$valuesPassedCriteria->applicant_source_table; $tableColumn=$valuesPassedCriteria->applicant_souce_column; $tableColumnValue=$valuesPassedCriteria->applicant_source_value;$operator=$valuesPassedCriteria->operator;$applicationID=$model->application_id;$applicantID=$model->applicant_id;$level=$valuesPassedCriteria->level;

                 if($tableName=='applicant'){
                 $resultsFinalFoundPass=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteria2Found($tableName,$tableColumn,$tableColumnValue,$operator,$applicantID,$applicationID); 
                  }else if($tableName=='education'){
                 $resultsFinalFoundPass=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteriaFoundEducation($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID,$level);
                  }else{
                 $resultsFinalFoundPass=backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteriaFound($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID);    
                  }

                                 ?>    
                                 
                    <tr>
                        <td><?php echo backend\modules\application\models\VerificationCustomCriteria::findOne(['verification_custom_criteria_id'=>$valuesPassedCriteria->verification_custom_criteria_id])->criteria_name; ?></td>
                        <td><?php echo $valuesPassedCriteria->operator; ?></td>                        
                        <td><?php echo $valuesPassedCriteria->applicant_source_value; ?></td>
                        <td><?php 
                        if($valuesPassedCriteria->level=="NONE"){
                          echo "";  
                        }else{
                          echo $valuesPassedCriteria->level;  
                        }
                         ?></td>
                        <td><?php echo $resultsFinalFoundPass; ?></td>
                        <td><?php    
                           echo Html::label("OK", NULL, ['class'=>'label label-success']); 
                        ?></td>
                    </tr>                 
                    <?php             
                    }
                                  }




}else{
                    $application_setCriteriaStatus=backend\modules\application\models\Application::findOne(['application_id'=>$model->application_id,'verification_criteria_status'=>0]);
                    if(count($application_setCriteriaStatus) >0){
                    $application_setCriteriaStatus->verification_criteria_status=NULL;
                    $application_setCriteriaStatus->save();
                    }
                 }

if($i > 0 && $results_check_criteria_general==0){					 
					$application_verific_criteria=backend\modules\application\models\Application::findOne(['application_id'=>$model->application_id]);
                    $application_verific_criteria->verification_criteria_status=0;
                    $application_verific_criteria->save();					
				 }else if($i > 0 && $results_check_criteria_general==1){
					$application_verific_criteria=backend\modules\application\models\Application::findOne(['application_id'=>$model->application_id]);
                    $application_verific_criteria->verification_criteria_status=1;
                    $application_verific_criteria->save();
				 }
 ?>
                </tbody>
            </table>
              </p>
          </div>
        </div>        
    </div>


  
  <div class="row" style="margin: 1%;">  
      <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">VERIFY APPLICANT ATTACHMENTS</h3>
                </div>     
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
             ['class' => 'yii\grid\SerialColumn'],            
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) use($fullname,$application_id1,$released){
                  return $this->render('verification',['model'=>$model,'fullname' => $fullname,'application_id'=>$application_id1,'released'=>$released]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
             [
                     'attribute' => 'attachment_definition_id',
                        'label'=>"Verification Item",
                        'value' => function ($model) {
                            return $model->attachmentDefinition->attachment_desc;							
                        },
             ],          
             [
                'attribute' => 'verification_status',
                    'value' => function ($model) use($application_id1){
						$resultsPath=\backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($model->attachment_definition_id,$application_id1);
						
                       if($resultsPath->verification_status == 0){
                            return Html::label("UNVERIFIED", NULL, ['class'=>'label label-default']);
                            } else if($resultsPath->verification_status == 1) {
                            return Html::label("VALID", NULL, ['class'=>'label label-success']);
                            }
                              else if($resultsPath->verification_status == 2) {
                            return Html::label("INVALID", NULL, ['class'=>'label label-danger']);
                            }
                               else if($resultsPath->verification_status == 3) {
                                        return Html::label("WAITING", NULL, ['class'=>'label label-warning']);
                           }else if($resultsPath->verification_status == 4) {
                                        return Html::label("INCOMPLETE", NULL, ['class'=>'label label-danger']);
                                    }
                        },
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ], 					
             [
               'attribute' => 'comment',
                'label' => 'Verification Status Reason',
				'value' => function ($model) use($application_id1) {
                            $resultsPath=\backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($model->attachment_definition_id,$application_id1);
                           //return $resultsPath->comment;
                            return \backend\modules\application\models\VerificationComment::getVerificationComment($resultsPath->comment);
                 },
             ],
           ],
      ]); ?>

<?php if($model->verification_framework_id==''){
		  $checkFrameworkID=0;
		  	  }else{
		   $checkFrameworkID=$model->verification_framework_id;		  
			  } ?>
                  <?php if($released==NULL OR $released==''){ ?>
                 <?php $form = ActiveForm::begin(['action' => ['final-submitform','id'=>$model->application_id,'frameworkID'=>$checkFrameworkID]]); ?>
                    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                         <?php ActiveForm::end(); ?>
                         <?php } ?>

</div>
</div>          
</div>
   </div>
</div>
