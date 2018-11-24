<?php
$incomplete=0;
use yii\helpers\Html;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Education;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Application;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */


$this->title ="LOANEE DETAILS";
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-view">
   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>

   <div class="panel-body">
<?php
$modelApplication = $model;
$parent_count= ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND guarantor_type is NULL")->count();
                        $step2=0;
                       if($modelApplication->loanee_category==""&&$modelApplication->applicant_category_id==""){
                        $incomplete+=1;
                        $step2+=1;
                       // echo   "<p style='color:red'><strong>Step 2 is incomplete</strong></p>";
                       }
           ##################check step 3 required information ##############
                      $step3=0;
                      if($modelApplicant->date_of_birth==""||$modelApplicant->birth_certificate_number==""||$modelApplicant->identification_type_id==""||$modelApplicant->place_of_birth==""||$modelApplicant->disability_status==""){
                       $step3+=1;   
                          $incomplete+=1;  
                         //echo   "<p style='color:red'><strong>Step 3 : Date of Birth  or birth certificate number  is incomplete</strong></p>";
                      }
                    else if($modelApplicant->birth_certificate_document==""){
                       $step3+=1;   
                          $incomplete+=1;  
                      //echo   "<p style='color:red'><strong>Step 3 : Birth Certificate Document is incomplete</strong></p>";
                     }
                    else if($modelApplicant->identification_document==""){
                       $step3+=1;   
                       $incomplete+=1;  
                      //echo   "<p style='color:red'><strong>Step 3 : Identification Document is missing</strong></p>";
                     }
                    else if($modelApplicant->disability_document==""&&$modelApplicant->disability_status=="YES"){
                       $step3+=1;  
                        //echo   "<p style='color:red'><strong>Step 3 : Disability Document and disability status are incomplate</strong></p>";
                       $incomplete+=1;  
                     }
                   else if($modelApplication->passport_photo==""){
                       $step3+=1;
                       //echo   "<p style='color:red'><strong>Step 3 : Passport photo is incomplate</strong></p>";
                        $incomplete+=1;  
                     }
                      ######step 7 #######
                         $incomplete=$step8=$step7=0;
                    if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==4){
                        if($parent_count==0){
                        $incomplete+=1;
                          $step7+=1;
                           // echo   "<p style='color:red'><strong>Step 7 is incomplete</strong></p>";
                         }
                            }
                       ######end ############
$guardian_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GD' ")->count();
                  
$guarantor_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GA' ")->count();
                    
                       #####step 5 ##########
                         
        
//                    if($modelApplication->loan_application_form_status<3){
//                     $incomplete+=1;  
//                    }
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
                      
                       ##########################educatio status 'PRIMARY','OLEVEL','ALEVEL','COLLEGE','BACHELOR','MASTERS'########################
//                        $primary=Education::getcheckeducation("PRIMARY", $modelApplication->application_id);
//                        $olevel=Education::getcheckeducation("OLEVEL", $modelApplication->application_id);
//                        $alevel=Education::getcheckeducation("ALEVEL", $modelApplication->application_id);
//                        $college=Education::getcheckeducation("COLLEGE", $modelApplication->application_id);
$primary=$primary_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'PRIMARY'])->one();
$olevel=$ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->one();
$alevel=$advanced_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'ALEVEL'])->one();
$college=$college_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'COLLEGE'])->one();
$all_ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->all();
$all_advanced_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'ALEVEL'])->all();
$bachelor_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'BACHELOR'])->one();
$masters_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'MASTERS'])->one();

                        ######step 4 #######
                        if($primary==0){
                        $incomplete+=1;
                          $step4+=1;
                           //echo   "<p style='color:red'><strong>Step 4 is incomplete</strong></p>";
                         }
                       ######end ############
                       #####step 5 ##########
                      if($olevel==0){
                          $incomplete+=1;
                          $step5+=1;
                         //echo   "<p style='color:red'><strong>Step 5 is incomplete</strong></p>";
                         }
                       ######end ############
                       #####step 6 ##########
                        if($alevel==0&&$college==0){
                          $incomplete+=1;
                          $step6+=1;
                        //echo   "<p style='color:red'><strong>Step 6 is incomplete</strong></p>";
                         }
                       ###### end ############
                       ##################### end #############################################
                             if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==4){
                                  $bachelor=Education::getcheckeducation("BACHELOR", $modelApplication->application_id);
                                  $master=Education::getcheckeducation("MASTERS", $modelApplication->application_id);
                                 if($bachelor==0){
                                   $incomplete+=1;  
                                  //echo   "<p style='color:red'><strong>Step 7 is incomplete</strong></p>";
                                    } 
                             }
                             else{
                                if($parent_count==0){
                                    $incomplete+=1;  
                                     $step7+=1;
                                   //echo   "<p style='color:red'><strong>Step 7 is incomplete</strong></p>";
                                   }   
                                 if($guardian_count==0){
                                    $incomplete+=1;  
                                     $step8+=1;
                                   //echo   "<p style='color:red'><strong>Step 8 is incomplete</strong></p>";
                                   }
                             }
                         ######step 8  #######
                     if($modelApplication->applicant_category_id==2||$modelApplication->applicant_category_id==4){  
                        if($guardian_count==0){
                        $incomplete+=1;
                          $step8+=1;
                           //echo   "<p style='color:red'><strong>Step 8 is incomplete</strong></p>";
                         }
                          }
                       ######end ############
                    ######step 9 #######
                           $step9=0;
                        if($guarantor_count==0){
                        $incomplete+=1;
                          $step9+=1;
                       //echo   "<p style='color:red'><strong>Step 9 is incomplete</strong></p>";
                         }
                       ######end ############


$father_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'M'])->one();

$mother_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'F'])->one();

$guardian_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'GD'])->one();

$guarantor_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'GA'])->one();
$guarantor_full_name = $guarantor_details->firstname.' '.$guarantor_details->middlename.' '.$guarantor_details->surname;

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


    <div class="row" style="margin: 1%;"> 
            <img class="img" src="<?= '../'.$model->passport_photo?>" alt="" style="height: 182px;width: 170px; float:right">

        <div class="col-xs-10">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">TAARIFA BINAFSI NA ANUANI ZA MWOMBAJI(APPLICANT'S PERSONAL DETAILS)</h3>
              </div>                   
           
                 <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Jina Kamili(Full Name) :<b><?= $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;?></b></h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body no-padding">
                 <table class="table table-condensed">
                  <tr>
                    <td>Jinsia(Sex) : </td>
                    <td><b><?= $model->applicant->user->sex ==M?'Male' : 'Female';?></b></td>
                    <td>Tarehe ya Kuzaliwa(Date of Birth) : </td>
                    <td><b><?= $model->applicant->date_of_birth;?></b></td>
                  </tr>

                 <tr>
                   <td>Wilaya Ulikozaliwa(Birth District) : </td>
                   <td><b><?= $model->applicant->ward->district->district_name;?></b></td>
                   <td>Mkoa Ulikozaliwa(Birth Region) : </td>
                   <td><b><?= $model->applicant->ward->district->region->region_name;?></b></td>
                 </tr>
                 <tr>
                   <td>Barua Pepe(Email) : </td>
                   <td><b><?= $model->applicant->user->email_address;?></b></td>
                   <td>Namba ya Simu ya Mkononi(Mobile Phone) : </td>
                   <td><b><?= $model->applicant->user->phone_number;?></b></td>
                 </tr>
                </table>
              </div>
                <!-- /.box-body -->
             </div>               
          </div>
        </div>
      </div>

      <div class="row" style="margin: 1%;"> 
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">TAARIFA ZA ELIMU YA  MWOMBAJI (EDUCATIONAL BACKGROUND)</h3>
              </div> 
                <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Elimu ya Shule ya Msingi (Primary School Education History)</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body no-padding">
                 <table class="table table-condensed">
                  <tr>
                    <td>Jina la Shule(School Name) : </td>
                    <td><b><?= $primary_education_details->learningInstitution->institution_name;?></b></td>
                  </tr>
                 <tr>
                   <td>Year of Entry : </td>
                   <td><b><?= $primary_education_details->entry_year;?></b></td>
                   <td>Year of Graduation : </td>
                   <td><b><?= $primary_education_details->completion_year;?></b></td>
                 </tr>

                  <tr>
                   <td>District : </td>
                   <td><b><?= $primary_education_details->learningInstitution->ward->district->district_name;?></b></td>
                   <td>Region : </td>
                   <td><b><?= $primary_education_details->learningInstitution->ward->district->region->region_name;?></b></td>
                 </tr>
                </table>
              </div>
                <!-- /.box-body -->
             </div>
               <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Shule ya Sekondari Kidato cha 4 (O-level Secondary School)</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body no-padding">
                 <table class="table table-condensed">
                  <?php 
                      foreach ($all_ordinary_level_education_details as $ordinary_level_education_detail) {
                  ?>
                  <tr>
                    <td>Jina la Shule(School Name) : </td>
                    <td><b><?= $ordinary_level_education_detail->learningInstitution->institution_name;?></b></td>
                    <td>Namba ya Mtahiniwa(Form Four Index Number) : </td>
                   <td><b><?= $ordinary_level_education_detail->registration_number.'.'.$ordinary_level_education_details->completion_year;?></b></td>
                  </tr>
                  <?php } ?>
                </table>
              </div>
                <!-- /.box-body -->
             </div>

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Shule ya Sekondari Kidato cha 6 (A-level Secondary School)</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body no-padding">
                 <table class="table table-condensed">
                 <?php 
                      foreach ($all_advanced_level_education_details as $advanced_level_education_detail) {
                  ?>
                  <tr>
                    <td>Jina la Shule(School Name) : </td>
                    <td><b><?= $advanced_level_education_detail->learningInstitution->institution_name;?></b></td>
                    <td>Namba ya Mtahiniwa(Form Six Index Number) : </td>
                   <td><b><?= $advanced_level_education_detail->registration_number.'.'.$advanced_level_education_detail->completion_year;?></b></td>
                  </tr>
                <?php } ?>
                </table>
              </div>
                <!-- /.box-body -->
              <?php
                if($college_level_education_details){ 
              ?>
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Elimu baada ya Form IV - Chuo cha Diploma</h3>
               </div>
                <div class="box-body no-padding">
                 <table class="table table-condensed">
                   <tr>
                    <td>Jina la Chuo (College Name) : </td>
                    <td><b><?= $college_level_education_details->learningInstitution->institution_name;?></b></td>
                    <td>Completed Year : </td>
                   <td><b><?= $college_level_education_details->completion_year;?></b></td>
                  </tr>
                    <tr>
                    <td>Registration No : </td>
                    <td><b><?= $college_level_education_details->avn_number;?></b></td>
                    <td>Award : </td>
                   <td><b><?= $college_level_education_details->programme_name;?></b></td>
                  </tr>
                </table>
              </div>
                <!-- /.box-body -->
             </div>
             <?php } ?>
             </div>
              <?php
              if($model->applicant_category_id == 2){ 
              ?>
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Elimu ya Chuo Kikuu (Tertiary Education History)</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body no-padding">
                 <table class="table table-condensed">
             <?php
                if($bachelor_level_education_details){
              ?>
                  <tr>
                    <td>Jina la Chuo (College Name) : </td>
                    <td><b><?= $bachelor_level_education_details->learningInstitution->institution_name;?></b></td>
                    <td>Award : </td>
                   <td><b><?= $bachelor_level_education_details->programme_name;?></b></td>
                  </tr>
                  <tr>
                    <td>Region: </td>
                    <td><b><?= $bachelor_level_education_details->region->region_name;?></b></td>
                    <td>Registration No : </td>
                   <td><b><?= $bachelor_level_education_details->avn_number;?></b></td>
                  </tr>
                   <tr>
                    <td>Year of Entry: </td>
                    <td><b><?= $bachelor_level_education_details->entry_year;?></b></td>
                    <td>Year of Graduation: </td>
                   <td><b><?= $bachelor_level_education_details->completion_year;?></b></td>
                  </tr>
             <?php } ?>
             <?php
                if($masters_level_education_details){
              ?>
                  <tr>
                    <td>Jina la Chuo (College Name) : </td>
                    <td><b><?= $masters_level_education_details->learningInstitution->institution_name;?></b></td>
                    <td>Award : </td>
                   <td><b><?= $masters_level_education_details->programme_name;?></b></td>
                  </tr>
                  <tr>
                    <td>Region: </td>
                    <td><b><?= $masters_level_education_details->region->region_name;?></b></td>
                    <td>Registration No : </td>
                   <td><b><?= $masters_level_education_details->avn_number;?></b></td>
                  </tr>
                   <tr>
                    <td>Year of Entry: </td>
                    <td><b><?= $masters_level_education_details->entry_year;?></b></td>
                    <td>Year of Graduation: </td>
                   <td><b><?= $masters_level_education_details->completion_year;?></b></td>
                  </tr>
           <?php } ?>
                </table>
              </div>
                <!-- /.box-body -->
             </div>
             <?php } ?>

            </div>
          </div>
          </div>
 <?php if($model->applicant_category_id != 2){ ?>
       <div class="row" style="margin: 1%;"> 
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">TAARIFA ZA KIJAMII NA UCHUMI YA  MWOMBAJI (APPLICANT'S SOCIO-ECONOMIC DETAILS)</h3>
              </div>
                 <div class="box-body no-padding">
                 <table class="table table-condensed">
             
                  <tr>
                    <td><b><?= Application::getFatherAliveStatus($father_details->is_parent_alive); ?></b></td>
                  </tr>
              
                  <tr>
                    <td><b><?= Application::getMotherAliveStatus($mother_details->is_parent_alive); ?></b></td>
                  </tr>
                  <tr>
                    <td><b><?= Application::getApplicantDisabilityStatus($model->applicant->disability_status); ?></b></td>
                  </tr>
                  <tr>
                    <td><b><?= Application::getParentsDisabilityStatus($mother_details->disability_status,$father_details->disability_status); ?></b></td>
                  </tr>
                </table> 
            </div>
          </div>
      </div>
    </div>

    <div class="row" style="margin: 1%;"> 
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">TAARIFA ZA WAZAZI/MLEZI (PARENTS/GUARDIAN INFORMATION)</h3>
              </div>
                 <div class="box-body no-padding">
              <?php
                if($mother_details->is_parent_alive == 'YES'){
              ?>
                 <table class="table table-condensed">
                  <tr>
                   <td>Jina Kamili la Mama(Mother's Full Name) : </td>
                   <td><b><?= $mother_details->firstname.' '.$mother_details->middlename.' '.$mother_details->surname;?></b></td>
                   <td>Makazi ya Mama : </td>
                   <td><b><?= $mother_details->ward->district->region->region_name;?></b></td>
                 </tr>
                <tr>
                   <td>Anuani ya Posta Mama(Mother's Postal Address) : </td>
                   <td><b><?= $mother_details->postal_address;?></b></td>
                   <td>Simu ya Mama(Mother's Mobile Phone) : </td>
                   <td><b><?= $mother_details->phone_number;?></b></td>
                 </tr>
                 <tr>
                   <td>Kazi ya Mama : </td>
                   <td><b><?= $mother_details->occupation->occupation_desc;?></b></td>
                 </tr>
                </table>
                <br /> 
                <?php } ?>
                <?php
                if($father_details->is_parent_alive == 'YES'){
                ?>
                <table class="table table-condensed">
                  <tr>
                   <td>Jina Kamili la Baba(Father's Full Name) : </td>
                   <td><b><?= $father_details->firstname.' '.$father_details->middlename.' '.$father_details->surname;?></b></td>
                   <td>Makazi ya Baba : </td>
                   <td><b><?= $father_details->ward->district->region->region_name;?></b></td>
                 </tr>
                <tr>
                   <td>Anuani ya Posta Baba(Father's Postal Address) : </td>
                   <td><b><?= $father_details->postal_address;?></b></td>
                   <td>Simu ya Baba(Father's Mobile Phone) : </td>
                   <td><b><?= $father_details->phone_number;?></b></td>
                 </tr>
                 <tr>
                   <td>Kazi ya Baba : </td>
                   <td><b><?= $father_details->occupation->occupation_desc;?></b></td>
                 </tr>
                </table>
                <br />
                <?php } ?>
                <?php 
                if($guardian_details){
                ?>
                  <table class="table table-condensed">
                  <tr>
                   <td>Jina Kamili la Mlezi (Guardian Full Name) : </td>
                   <td><b><?= $guardian_details->firstname.' '.$guardian_details->middlename.' '.$guardian_details->surname;?></b></td>
                    <td>Makazi ya Mlezi : </td>
                   <td><b><?= $guardian_details->ward->district->region->region_name;?></b></td>
                 </tr>
                <tr>
                  <td>Anuani ya Posta ya Mlezi (Guardian's Postal Address) : </td>
                  <td><b><?= $guardian_details->postal_address;?></b></td>
                  <td>Simu ya Mlezi (Guardian's Mobile Phone) : </td>
                  <td><b><?= $guardian_details->phone_number;?></b></td>
                 </tr>
                  <tr>
                   <td>Wilaya : </td>
                   <td><b><?= $guardian_details->ward->district->district_name;?></b></td>
                   <td>Mkoa : </td>
                   <td><b><?= $guardian_details->ward->district->region->region_name;?></b></td>
                 </tr>
                <tr>
                   <td>Kazi ya Mlezi : </td>
                   <td><b><?= $guardian_details->occupation->occupation_desc;?></b></td>
                 </tr>

                </table>
                <?php } ?>
            </div>
          </div>
      </div>
    </div>
 <?php } ?>
   <?php
     if($model->applicant_category_id != 2){
   ?>
   <div class="row" style="margin: 1%;"> 
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">TAARIFA ZA MDHAMINI (GUARANTOR'S INFORMATION)</h3>
              </div>
              <?php 
                if($guarantor_details){
              ?>
                 <div class="box-body no-padding">
                  <table class="table table-condensed">
                <tr>
                 <td style="width:90%"><table>
                  <tr>
                   <td>Jina Kamili la Mdhamini(Guarantor's Full Name) : </td>
                   <td><b><?= $guarantor_details->firstname.' '.$guarantor_details->middlename.' '.$guarantor_details->surname;?></b></td>
                   <td>Anwani ya Posta : </td>
                   <td><b><?= $guarantor_details->postal_address;?></b></td>
                  </tr>
                  <tr>
                  <td>Kijiji/Mtaa : </td>
                   <td><b><?= $guarantor_details->ward->ward_name;?></b></td>
                   <td>Kata/Shehia : </td>
                   <td><b><?= $guarantor_details->ward->ward_name;?></b></td>
                 </tr>
                  <tr>
                   <td>Wilaya : </td>
                   <td><b><?= $guarantor_details->ward->district->district_name;?></b></td>
                   <td>Mkoa : </td>
                   <td><b><?= $guarantor_details->ward->district->region->region_name;?></b></td>
                 </tr>
                 <tr>
                  <td>Barua pepe : </td>
                   <td><b><?= $guarantor_details->email_address;?></b></td>
                   <td>Namba ya Simu ya Mkononi : </td>
                   <td><b><?= $guarantor_details->phone_number;?></b></td>
                 </tr>
                 <tr>
                   <td>Namba ya Kitambulisho : </td>
                   <td><b><?= $guarantor_details->NID;?></b></td>
                   <td>Aina ya Kitambulisho : </td>
                   <td><b><?= $guarantor_details->identificationType->identification_type;?></b></td>
                 </tr>
                 </table></td>
                <td style="width:10%;">
                  <img class="img" src="../applicant_attachment/profile/<?=$guarantor_details->passport_photo ?>" alt="" style="height: 100px;width: 120px;">
                </td>
                </tr>
            </table>
             </div>
                <?php } ?>
                <br /> 
            </div>
          </div>
      </div>
  <?php } ?>

<?php
     if($model->applicant_category_id == 2){
   ?>
   <div class="row" style="margin: 1%;">
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">TAARIFA ZA MDHAMINI (GUARANTOR'S INFORMATION)</h3>
              </div>
              <?php
                if($guarantor_details){
              ?>
                 <div class="box-body no-padding">
                  <table class="table table-condensed">

                  <tr>
                   <td>Jina la Taasisi(Institution's Full Name) : </td>
                   <td><b><?= $guarantor_details->organization_name;?></b></td>
                   <td>Physical Address : </td>
                   <td><b><?= $guarantor_details->physical_address;?></b></td>
                  </tr>
                  <tr>
                  <td>Postal Address : </td>
                   <td><b><?= $guarantor_details->ward->ward_name;?></b></td>
                   <td>Telephone : </td>
                   <td><b><?= $guarantor_details->phone_number;?></b></td>
                 </tr>
                  <tr>
                    <td>Contact Person Name : </td>
                    <td><b><?= $guarantor_full_name;?></b></td>
                    <td>Title : </td>
                    <td><b><?= $guarantor_details->guarantorPosition->guarantor_position;?></b></td>                  
                 </tr>
                 <tr>
                    <td>Region : </td>
                    <td><b><?= $guarantor_details->ward->district->region->region_name;?></b></td>
                    <td>District : </td>
                    <td><b><?= $guarantor_details->ward->district->district_name;?></b></td>                  
                 </tr>
            </table>

                <?php } ?>
                <br />
            </div>
          </div>
      </div>
    </div>
  <?php } ?>

        
   </div>
   </div>
</div>

