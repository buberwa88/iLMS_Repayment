<script>
   function getIframeContents(id){
    
      var url = document.getElementById(id).src;
      
      $('#'+id).contents().find('html').html('<strong><font color="green">Loading....</font></strong>')
      $('#'+id).attr('src', url); 
   } 
   
   function viewSittinResults(url){
      $('#sitting-subjects-iframe').contents().find('html').html('<strong><font color="green">Loading....</font></strong>')
      $('#sitting-subjects-dialog').dialog('open');
      $('#sitting-subjects-iframe').attr('src', url); 
   }
</script>

<style>
    iframe{
        border: 0;
    }
    
/*    #loader-image{
        width: 150px;
        height: 100px;
        position: fixed;
        margin-left: 10%;
        margin-bottom: 10%;
        z-index: 3000;
        
        
    }*/
</style>

<?php
use yii\helpers\Html;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Education;
//$this->title = 'Welcome '. $modelApplicant->firstname.' '.$modelApplicant->othernames.' '.$modelApplicant->surname;
$this->title ='My Application ::'.strtoupper($modelUser->firstname).' '.strtoupper($modelUser->middlename).' '.strtoupper($modelUser->surname);
$this->params['breadcrumbs'][] = 'My Application';
//$checkstatus=  \common\models\Education::find
           $user_id = Yii::$app->user->identity->id;
              $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
           $modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
           $parent_count= ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND guarantor_type is NULL")->count();
           $guardian_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GD' ")->count();
          $guarantor_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GA' ")->count();
                   
           ##################check step 3 required information ##############
                    $step3=0;
                      if($modelApplicant->date_of_birth==""||$modelApplicant->birth_certificate_number==""||$modelApplicant->identification_type_id==""||$modelApplicant->place_of_birth==""||$modelApplicant->disability_status==""){
                       $step3+=1;   
                      }
                    else if($modelApplicant->birth_certificate_document==""){
                       $step3+=1;    
                     }
                    else if($modelApplicant->identification_document==""){
                       $step3+=1;    
                     }
                    else if($modelApplicant->disability_document==""&&$modelApplicant->disability_status=="YES"){
                       $step3+=1;    
                     }
                   else if($modelApplication->passport_photo==""){
                       $step3+=1;    
                     }
                 #############################end step 3 #################
                 #####@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@##########
                    ##################check step 4-6 required information ##############
//                 function checkeducation($level,$applicationId){
//            $model=\frontend\modules\application\models\Education::find()->where(["level"=>$level,'application_id'=>$applicationId])->count();  
//            return $model;
//                 }
                 #############################end step 4-6 #################
                 #####@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@##########
                ?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
<label class="label label-primary"> Overall Status</label>: <label class="label label-danger">Incomplete</label>
<br> <br>
<p class='alert alert-info'>
    Your application is not yet completed. Please complete all the stages shown with 'Red Cross'. You are adviced to review your application thorough before printing as you 
    will not be able to change it again 
</p>

<ul class="list-group">
    <?php
             if($modelApplication->loan_application_form_status==""){
    ?>
    <li class="list-group-item"> <?= yii\helpers\Html::a("Step 1: Pay Application Fee ",['/application/applicant/pay-application-fee']);?>  <label class="label <?=  $modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"label-success":"label-danger";?> pull-right"><span class="glyphicon  <?=$modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label> </li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Intended Level of Study ",['/application/application/study-view']);?><label class='label  <?=  $modelApplication->loanee_category!=""&&$modelApplication->applicant_category_id!=""?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$modelApplication->loanee_category!=""&&$modelApplication->applicant_category_id!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Applicant Basic Information ",['/application/default/my-profile']);?><label class='label <?=$step3==0?"label-success":"label-warning";?> pull-right'> <span class=" glyphicon <?=$step3==0?"glyphicon-check":"glyphicon-check";?>"></span> </label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Primary Education  ",['/application/education/primary-view']);?><label class='label  <?= Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Form IV Education  ",['/application/education/olevel-view']);?><label class='label  <?= Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Post form IV Education ",['/application/education/alevel-view']);?><label class='label  <?= Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Tertiary Education Details ",['/application/education/tlevel-view']);?><label class='label  <?= Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 7: Parents Details ",['/application/applicant-associate/parent-view','id'=>6]);?> <label class='label <?= $parent_count==2?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $parent_count==2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 8: Guardian Details ",['/application/applicant-associate/guardian-view']);?> <label class='label  <?= $guardian_count==1?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $guardian_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 9: Guarantor Details ",['/application/applicant-associate/guarantor-view']);?> <label class='label  <?= $guarantor_count==1?"label-success":"label-danger";?>  pull-right' ><span class="glyphicon  <?= $guarantor_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
       <?php
         }
         else{
         ?>
    <li class="list-group-item">Step 1: Pay Application Fee   <label class="label <?=  $modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"label-success":"label-danger";?> pull-right"><span class="glyphicon  <?=$modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label> </li>
    <li class="list-group-item">Step 2: Intended Level of Study<label class='label  <?=  $modelApplication->loanee_category!=""&&$modelApplication->applicant_category_id!=""?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$modelApplication->loanee_category!=""&&$modelApplication->applicant_category_id!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 3: Applicant Basic Information<label class='label <?=$step3==0?"label-success":"label-warning";?> pull-right'> <span class=" glyphicon <?=$step3==0?"glyphicon-check":"glyphicon-check";?>"></span> </label></li>
    <li class="list-group-item">Step 4: Primary Education  <label class='label  <?= Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 5: Form IV Education <label class='label  <?= Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 6: Post form IV Education <label class='label  <?= Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 7: Parents Details <label class='label <?= $parent_count==2?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $parent_count==2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 8: Guardian Details  <label class='label  <?= $guardian_count==1?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $guardian_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 9: Guarantor Details  <label class='label  <?= $guarantor_count==1?"label-success":"label-danger";?>  pull-right' ><span class="glyphicon  <?= $guarantor_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
      
    <?php
         }
         ?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 10: Preview & Submit ", ['application/view-application','id'=> $modelApplication->application_id]);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 11: Upload Signed Forms ", ['application/upload-signed-form','id'=> $modelApplication->application_id]);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
  
   <li class="list-group-item"><?= yii\helpers\Html::a("Step 12: Close Application ", ['application/close-my-application','id'=> $modelApplication->application_id]);?>  <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>

</ul>
<?php
//echo yii\helpers\Html::a("<span class='glyphicon glyphicon-pencil'></span> Edit Application", "#", ['class'=>"btn btn-sm btn-success"]); echo "&nbsp;&nbsp;&nbsp;";
// <li class="list-group-item"><?= yii\helpers\Html::a("Step 10: Submit Final Application [Click Here to Edit]",['/application/applicant-attachment/index']);? <label class='label label-danger pull-right'><span class="glyphicon glyphicon-remove"></span></label></li>
  
//echo yii\helpers\Html::a("<span class='glyphicon glyphicon-eye-open'></span> Preview | Confirm Application", ['application/view-application','id'=> $modelApplication->application_id], ['class'=>"btn btn-sm btn-success"]); echo "&nbsp;&nbsp;&nbsp;";


?>
        </p>
        </div>
        </div>
</div>
    




 
