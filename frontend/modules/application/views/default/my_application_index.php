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
     $incomplete=0;
use yii\helpers\Html;
use frontend\modules\application\models\Application;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Education;
use frontend\modules\application\models\ApplicantAttachment;
use backend\modules\application\models\ReattachmentSetting;
//$this->title = 'Welcome '. $modelApplicant->firstname.' '.$modelApplicant->othernames.' '.$modelApplicant->surname;
$this->title ='My Application ('.strtoupper($modelUser->firstname).' '.strtoupper($modelUser->middlename).' '.strtoupper($modelUser->surname).")";
$this->params['breadcrumbs'][] = 'My Application';
//$checkstatus=  \common\models\Education::find
$user_id = Yii::$app->user->identity->id;
$modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
$modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
$parent_count= ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND guarantor_type is NULL")->count();
              ########## step 1 #############  
                 

             ############ end step 1 ##########
             ######step 7 #######
                         $incomplete=$step8=$step7=0;
                    if($modelApplication->applicant_category_id==1||$modelApplication->applicant_category_id==3){
                        if($parent_count<2){
                        $incomplete+=1;
                       // exit();
                          $step7+=1;
                         }
                            }
                      
                       ######end ############
$guardian_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GD' ")->count();
                     ######step 8  #######
                     if($modelApplication->applicant_category_id==1||$modelApplication->applicant_category_id==3){  
                        if($guardian_count==0){
                        $incomplete+=1;
                          $step8+=1;
                         }
                          }
                       ######end ############
             //$guarantor_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GA' ")->count();
                      ######step 9 #######
                    $guarantor_count=ApplicantAssociate::checkguarantor($modelApplication->application_id,$modelApplication->applicant_category_id);
                        
                          $step9=0;
                        if($guarantor_count==0){
                        $incomplete+=1;
                          $step9+=1;
                         }
                       ######end ############
                       #####step 5 ##########
                     
           ##################check step 3 required information ##############
                      $step3=0;
                      if($modelApplicant->date_of_birth==""||$modelApplicant->birth_certificate_number==""){
                       $step3+=1;   
                       $incomplete+=1;  
                      }
                    if($modelApplicant->birth_certificate_document==""&&$modelApplication->loan_application_form_status!=3){
                       $step3+=1;   
                         $incomplete+=1;  
                     }
//                    else if($modelApplicant->identification_document==""){
//                       $step3+=1;   
//                       $incomplete+=1;  
//                     }
                   if($modelApplicant->tasaf_support_document==""&&$modelApplicant->tasaf_support==""){
                       $step3+=1;   
                       $incomplete+=1;  
                     }
                    if($modelApplicant->disability_document==""&&$modelApplicant->disability_status=="YES"){
                       $step3+=1;   
                       $incomplete+=1;  
                     }
                    if($modelApplicant->tasaf_support_document==""&&$modelApplicant->tasaf_support=="YES"){
                       $step3+=1;   
                      $incomplete+=1;  
                     }
                   if($modelApplication->passport_photo==""){
                       $step3+=1;
                        $incomplete+=1;  
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
                     ///payment checking 
//                       if( $modelApplication->receipt_number==""&&$modelApplication->control_number==""){
//                        $incomplete+=1;   
//                       }
                       $step2=0;
                       if($modelApplication->loanee_category==""&&$modelApplication->applicant_category_id==""){
                        $incomplete+=1;
                        $step2+=1;
                       }
                      if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==5){
                            if($modelApplication->admission_letter==""||$modelApplication->employer_letter==""){
                           $incomplete+=1;
                           $step2+=1;  
                            }
                      }
                       ##########################educatio status 'PRIMARY','OLEVEL','ALEVEL','COLLEGE','BACHELOR','MASTERS'########################
                        $primary=Education::getcheckeducation("PRIMARY", $modelApplication->application_id);
                        $olevel=Education::getcheckeducation("OLEVEL", $modelApplication->application_id);
                        $alevel=Education::getcheckeducation("ALEVEL", $modelApplication->application_id);
                        $college=Education::getcheckeducation("COLLEGE", $modelApplication->application_id);
                        $other=Education::getcheckeducation("OTHER", $modelApplication->application_id);
                          //  exit();
                        ######step 4 #######
                        if($primary==0){
                        $incomplete+=1;
                          $step4+=1;
                         }
                       ######end ############
                       #####step 5 ##########
                      if($olevel==0){
                          $incomplete+=1;
                          $step5+=1;
                         }
                       ######end ############
                       #####step 6 ##########
                         $step6=0;
                         $step6=$college+$alevel+$other;
                         
                        if($step6==0){
                          $incomplete+=1;
                          $step6+=1;
                         }
                       ###### end ############
                       ##################### end #############################################
                              $bachelor_test=0; 
                           if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==5||$modelApplication->applicant_category_id==4){
                                  $bachelor=Education::getcheckeducation("BACHELOR", $modelApplication->application_id);
                                  $master=Education::getcheckeducation("MASTERS", $modelApplication->application_id);
                                 if($bachelor==0){
                                   $incomplete+=1;  
                                      $bachelor_test+=1;
                                    } 
                                if($modelApplication->applicant_category_id==5&& $master==0){
                               $incomplete+=1;  
                               $bachelor_test+=1;
                                }
                             }
                             else{
                                if($parent_count==0){
                                    $incomplete+=1;  
                                     $step7+=1;
                                   }   
                                 if($guardian_count==0){
                                    $incomplete+=1;  
                                     $step8+=1;
                                   }
                             }
                      
                             $openlink=$incomplete;
                    if($modelApplication->loan_application_form_status<3){
                       $incomplete+=1;  
                    }
                    ################# End Education ####################################
                      //end 
                   ///$modelApplication->receipt_number="35233252";
                   //$modelApplication->control_number="3523523";
                   //end
                   ################################################ mickidadimsoka@gmail.com ##########################
                   ###   missing attachment process                                                                  ##
                   ###################################################################################################
                    $application_attachment=0;
                 ///  $application_attachment = ApplicantAttachment::find()->where("application_id='{$modelApplication->application_id}' AND submited=2")->count();
                   //find reattachment definition
                  // $modelall=ReattachmentSetting::findbysql('SELECT group_concat(verification_status) as verification_status ,group_concat(comment_id) as comment_id FROM `reattachment_setting` WHERE `is_active`=1')->asArray()->one();
                   //  print_r($modelall['verification_status']);
                  /* $modelall=ReattachmentSetting::findbysql('SELECT group_concat(verification_status) as verification_status ,
                        group_concat(comment_id) as comment_id FROM `reattachment_setting` WHERE `is_active`=1')->asArray()->one();
                   // print_r($modelall);
                   //   exit();
                   //  print_r($modelall['verification_status']);
                   $verification_status=$modelall['verification_status'];
                   $comment_id="";
                   if($modelall['comment_id']!=""){
                       $comment_id=$modelall['comment_id'];
                   }
                   // $commentsql='';
                   if($comment_id!=""){
                       $commentsql=" AND comment IN($comment_id)";
                   }*/
                   if($verification_status !=''){
					 $verification_status=$verification_status;  
				   }else{
					   $verification_status=100000;//the default value for not existing status
				   }
                  
                   //  $query = ApplicantAttachment::find()->where("application_id='{$application_id}' AND verification_status IN($verification_status) $commentsql ");
                   //$application_attachment_missing = ApplicantAttachment::find()->where("application_id='{$modelApplication->application_id}' AND verification_status IN($verification_status) $commentsql")->count();
                  // $application_attachment_missing = ApplicantAttachment::find()->where("application_id='{$modelApplication->application_id}' AND submited=1")->count();
                   //end
                   ################################################ mickidadimsoka@gmail.com ##########################
                   ###   missing attachment process      end                                                         ##
                   ###################################################################################################
                   $application_attachment_missing=0;
                   ?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
<label class="label label-primary"> Overall Status</label>: 
     <?php
         if($incomplete>0){
   echo '<label class="label label-danger">Incomplete</label>';
         }
         else{
   echo '<label class="label label-success">Complete</label>';           
         }
        ?>
<br> <br>
<?php
  if($modelApplication->receipt_number!=""&&$modelApplication->control_number!=""&&$incomplete>0){ ?>
<p class='alert alert-info'>
    Your application is not yet complete. Please complete all the stages shown with 'Red Cross'. You are advice to review your application thorough before printing as you 
    will not be able to change it again 
</p>
<?php
  }else if($modelApplication->receipt_number==""&&$modelApplication->control_number==""){ 
      ?>
<p class='alert alert-danger'>
                    Pay application fee to proceed to other steps</p>
 <?php
   }else if($modelApplication->receipt_number!=""&&$modelApplication->control_number!=""&&$modelApplication->loan_application_form_status==3){ 
       ?>
<p class='alert alert-info'>
              You have completed all application steps.
</p>
 
<?php
   }?>
<ul class="list-group">
     <?php
    
         $sqlquest=Yii::$app->db->createCommand('SELECT count(*) FROM `application_cycle` apc join academic_year ac  on apc.`academic_year_id`=ac.`academic_year_id` WHERE application_cycle_status_out_id=2 AND ac.`academic_year_id`=1')->queryScalar();
         if($sqlquest==0){
          
             if($modelApplication->loan_application_form_status==""){ ?>
      <li class="list-group-item"> <?= yii\helpers\Html::a("Step 1: Pay Application Fee ",['/application/applicant/pay-application-fee']);?>  <label class="label <?=  $modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"label-success":"label-danger";?> pull-right"><span class="glyphicon  <?=$modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label> </li>
   
    <?php
         }
         if($modelApplication->receipt_number!=""&&$modelApplication->control_number!=""){
             if($modelApplication->loan_application_form_status==""){
    ?>
  
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Intended Level of Study ",['/application/application/study-view']);?><label class='label  <?= $step2==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$step2==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Applicant Basic Information ",['/application/default/my-profile']);?><label class='label <?=$step3==0?"label-success":"label-warning";?> pull-right'> <span class=" glyphicon <?=$step3==0?"glyphicon-check":"glyphicon-check";?>"></span> </label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Primary Education  ",['/application/education/primary-view']);?><label class='label  <?= $primary>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Form 4 Education  ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Post form 4 Education ",['/application/education/alevel-view']);?><label class='label  <?= $alevel>0||$college>0||$other>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$alevel>0||$college>0||$other>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php
         $mh=6;
        if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==4||$modelApplication->applicant_category_id==5){
                 $mh+=1;
       ?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh: Tertiary Education Details ",['/application/education/tlevel-view']);?><label class='label  <?=  $bachelor_test==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?= $bachelor_test==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
        <?php
          }
         if($modelApplication->applicant_category_id==1||$modelApplication->applicant_category_id==4||$modelApplication->applicant_category_id==3){
        ?>
        <?php   $mh+=1;?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh : Parents Details ",['/application/applicant-associate/parent-view','id'=>6]);?> <label class='label <?= $parent_count==2?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $parent_count==2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
        <?php   $mh+=1;?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh : Guardian Details ",['/application/applicant-associate/guardian-view']);?> <label class='label  <?= $guardian_count==1?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $guardian_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
       <?php
         
          }
        ?>
        <?php   $mh+=1;?>
     <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh: Guarantor Details ",['/application/applicant-associate/guarantor-view']);?> <label class='label  <?= $guarantor_count==1?"label-success":"label-danger";?>  pull-right' ><span class="glyphicon  <?= $guarantor_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
       <?php
         }
         else{
         ?>
    <li class="list-group-item">Step 1: Pay Application Fee   <label class="label <?=  $modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"label-success":"label-danger";?> pull-right"><span class="glyphicon  <?=$modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label> </li>
    <li class="list-group-item">Step 2: Intended Level of Study<label class='label  <?= $step2==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$step2==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 3: Applicant Basic Information<label class='label <?=$step3==0?"label-success":"label-warning";?> pull-right'> <span class=" glyphicon <?=$step3==0?"glyphicon-check":"glyphicon-check";?>"></span> </label></li>
    <li class="list-group-item">Step 4: Primary Education  <label class='label  <?= Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 5: Form 4 Education <label class='label  <?= Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 6: Post form 4 Education <label class='label  <?= $alevel>0||$college>0||$other>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$alevel>0||$college>0||$other>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php
         $mh=6;
        if($modelApplication->applicant_category_id==1||$modelApplication->applicant_category_id==4||$modelApplication->applicant_category_id==3){
                 $mh+=1;
       ?>
    <li class="list-group-item">Step <?=$mh?>: Parents Details <label class='label <?= $parent_count==2?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $parent_count==2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
        <?php   $mh+=1;?>
    <li class="list-group-item">Step <?=$mh?>: Guardian Details  <label class='label  <?= $guardian_count==1?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $guardian_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php
        } 
      if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==5){?>
        <?php   $mh+=1;?>
      <li class="list-group-item">Step <?=$mh?>: Tertiary Education Details<label class='label  <?=  $bachelor_test==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?= $bachelor_test==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
        
        <?php
         }
        $mh+=1;
        ?>
    <li class="list-group-item">Step <?=$mh?>: Guarantor Details  <label class='label  <?= $guarantor_count==1?"label-success":"label-danger";?>  pull-right' ><span class="glyphicon  <?= $guarantor_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
      
    <?php
         }
       $mh+=1;
             if($modelApplication->loan_application_form_status==""){
               $label_pr="Preview & Confirm  "; 
               
              }
            else{
              $label_pr="Preview ";      
            }
      if($openlink==0){
         ?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh: $label_pr", ['application/view-application']);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php   $mh+=1;
  if($modelApplication->loan_application_form_status>=1){ ?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh: Download Application ", ['application/download-my-application']);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php 
       }
       else{ ?>
    
 <li class="list-group-item">Step <?=$mh?>: Download Application <label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>    
     <?php
       }
     $mh+=1;
     if($modelApplication->loan_application_form_status>=1&&$modelApplication->loan_application_form_status<3){ ?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh: Upload Signed Forms ", ['application/upload-signed-form','id'=> $modelApplication->application_id]);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php 
      }else{ ?>
   <li class="list-group-item">Step  <?=$mh?> Upload Signed Forms <label class='label <?= $modelApplication->loan_application_form_status > 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php
       }
    $mh+=1;
     if($modelApplication->loan_application_form_status>1&&$modelApplication->loan_application_form_status<3){ ?>
   <li class="list-group-item"><?= yii\helpers\Html::a("Step  $mh: Submit ", ['application/close-my-application','id'=> $modelApplication->application_id]);?>  <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
   <?php
      }
     else{ ?>
    <li class="list-group-item">Step  <?=$mh?>: Submit  <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
       
     <?php 
     }
     $mh+=1;
     if($modelApplication->loan_application_form_status>1&&$modelApplication->loan_application_form_status<3){ ?>
   <li class="list-group-item"><?= yii\helpers\Html::a("Step  $mh: Upload Missing Attachment ", ['application/upload-missing-attachment','id'=> $modelApplication->application_id]);?>  <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
   <?php
      }
     else{ $tela=15;?>
   <li class="list-group-item"><?= yii\helpers\Html::a("Step  $mh: Upload Missing Attachment", ['application/upload-missing-attachment','id'=> $modelApplication->application_id]);?> <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
   <li class="list-group-item"><?= yii\helpers\Html::a("Step  $tela: Download Loan Application Form(PDF) for Signatures and Certification processes", ['application/application-original-form','id'=> $modelApplication->application_id]);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php 
     
     }
     }else{?>
    <li class="list-group-item">Step <?= $mh.":".$label_pr?> <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php   $mh+=1;?>
    <li class="list-group-item">Step <?=$mh?>: Download Application <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php   $mh+=1;?>
    <li class="list-group-item">Step <?=$mh?>: Upload Signed Forms <label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php  $mh+=1;?>
   <li class="list-group-item">Step  <?=$mh?>: Submit <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
 
 <?php
    }
 }
 else{
?>
   
    <li class="list-group-item">Step 2: Intended Level of Study<label class='label  <?=$step2==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$step2==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 3: Applicant Basic Information<label class='label <?=$step3==0?"label-success":"label-warning";?> pull-right'> <span class=" glyphicon <?=$step3==0?"glyphicon-check":"glyphicon-check";?>"></span> </label></li>
    <li class="list-group-item">Step 4: Primary Education  <label class='label  <?= Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 5: Form 4 Education <label class='label  <?= Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 6: Post form 4 Education <label class='label  <?= Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
   <li class="list-group-item">Step 7: Parents Details <label class='label <?= $parent_count==2?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $parent_count==2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
   <li class="list-group-item">Step 8 : Guardian Details  <label class='label  <?= $guardian_count==1?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $guardian_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
   <li class="list-group-item">Step 9: Guarantor Details  <label class='label  <?= $guarantor_count==1?"label-success":"label-danger";?>  pull-right' ><span class="glyphicon  <?= $guarantor_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 10 : Preview &  Confirm  <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
 
    <li class="list-group-item">Step 11 : Download Application<label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
  
    <li class="list-group-item">Step 12 : Upload Signed Forms<label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
  
   <li class="list-group-item">Step  13 : Submit <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
 
  <?php
 }
 }
 else{ ?>
     
   <div class="alert alert-warning alert-dismissible">
               
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                 <h2>The Application is Currently Closed.</h2>
              </div>    
              
              
              
   <li class="list-group-item">Step 1: Pay Application Fee   <label class="label <?=  $modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"label-success":"label-danger";?> pull-right"><span class="glyphicon  <?=$modelApplication->receipt_number!=""&&$modelApplication->control_number!=""?"glyphicon-check":"glyphicon-remove";?>"></span></label> </li>
    <li class="list-group-item">Step 2: Intended Level of Study<label class='label  <?=$step2==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=$step2==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 3: Applicant Basic Information<label class='label <?=$step3==0?"label-success":"label-warning";?> pull-right'> <span class=" glyphicon <?=$step3==0?"glyphicon-check":"glyphicon-check";?>"></span> </label></li>
    <li class="list-group-item">Step 4: Primary Education  <label class='label  <?= Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("PRIMARY", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 5: Form 4 Education <label class='label  <?= Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=Education::getcheckeducation("OLEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <li class="list-group-item">Step 6: Post form 4 Education <label class='label  <?= Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?=Education::getcheckeducation("ALEVEL", $modelApplication->application_id)>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php
         $mh=6;
        if($modelApplication->applicant_category_id==1||$modelApplication->applicant_category_id==4||$modelApplication->applicant_category_id==3){
                 $mh+=1;
       ?>
    <li class="list-group-item">Step <?=$mh?>: Parents Details <label class='label <?= $parent_count==2?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $parent_count==2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
        <?php   $mh+=1;?>
    <li class="list-group-item">Step <?=$mh?>: Guardian Details  <label class='label  <?= $guardian_count==1?"label-success":"label-danger";?> pull-right' ><span class="glyphicon <?= $guardian_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php
        } 
      if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==5){?>
        <?php   $mh+=1;?>
      <li class="list-group-item">Step <?=$mh?>: Tertiary Education Details<label class='label  <?=  $bachelor_test==0?"label-success":"label-danger";?> pull-right '><span class="glyphicon <?= $bachelor_test==0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
        
        <?php
         }
        $mh+=1;
        ?>
    <li class="list-group-item">Step <?=$mh?>: Guarantor Details  <label class='label  <?= $guarantor_count==1?"label-success":"label-danger";?>  pull-right' ><span class="glyphicon  <?= $guarantor_count==1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
      
    <?php
   
       $mh+=1;
             if($modelApplication->loan_application_form_status==""){
               $label_pr="Preview & Confirm  "; 
               
              }
            else{
              $label_pr="Preview ";      
            }
      if($openlink==0){
         ?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh: $label_pr", ['application/view-application']);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php   $mh+=1;
  if($modelApplication->loan_application_form_status>=1){ ?>
    <li class="list-group-item"><?= yii\helpers\Html::a("Step $mh: Download Application ", ['application/download-my-application']);?>  <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php 
       }
       else{ ?>
    
 <li class="list-group-item">Step <?=$mh?>: Download Application <label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>    
     <?php
       }
     $mh+=1;
     if($modelApplication->loan_application_form_status>=1&&$modelApplication->loan_application_form_status<3){ ?>
    <li class="list-group-item">Step  <?=$mh?> Upload Signed Forms <label class='label <?= $modelApplication->loan_application_form_status > 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php 
      }else{ ?>
   <li class="list-group-item">Step  <?=$mh?> Upload Signed Forms <label class='label <?= $modelApplication->loan_application_form_status > 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php
       }
    $mh+=1;
     if($modelApplication->loan_application_form_status>1&&$modelApplication->loan_application_form_status<3){ ?>
   <li class="list-group-item">Step  <?=$mh?>: Submit <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
   
   <?php
      }
     else{ ?>
    <li class="list-group-item">Step  <?=$mh?>: Submit <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
       
     <?php 
     
     }
   $mh+=1;
    if($application_attachment_missing>0){
   ?>
   <li class="list-group-item"><?= yii\helpers\Html::a("Step  $mh: Upload Missing Attachment ", ['application/upload-missing-attachment','id'=> $modelApplication->application_id]);?> <label class='label <?= $application_attachment >0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $application_attachment>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
  <?php
    } 
    }else{?>
    <li class="list-group-item">Step <?= $mh.":".$label_pr?> <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 1?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    <?php   $mh+=1;?>
    <li class="list-group-item">Step <?=$mh?>: Download Application <label class='label <?= $modelApplication->loan_application_form_status >= 1?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php   $mh+=1;?>
    <li class="list-group-item">Step <?=$mh?>: Upload Signed Forms <label class='label <?= $modelApplication->loan_application_form_status >= 2?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status >= 2?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
     <?php  $mh+=1;?>
   <li class="list-group-item">Step  <?=$mh?>: Submit <label class='label <?= $modelApplication->loan_application_form_status == 3?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?= $modelApplication->loan_application_form_status == 3?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
    
 <?php
    }
 }
 ?>
       </ul> </p>
        </div>
        </div>
</div>
    




 
