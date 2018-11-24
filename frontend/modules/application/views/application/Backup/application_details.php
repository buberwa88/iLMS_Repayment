<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use frontend\modules\application\models\Education;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Application;
use kartik\mpdf\Pdf;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
                        

$this->title ="APPLICATION FORM PREVIEW";
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;


$primary_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'PRIMARY'])->one();
$ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->one();
$advanced_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'ALEVEL'])->one();
$college_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'COLLEGE'])->one();
$all_ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->all();
$all_advanced_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'ALEVEL'])->all();

$father_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'M'])->one();

$mother_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'F'])->one();

$guardian_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'GD'])->one();

$guarantor_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'GA'])->one();
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
        </div>

   <div class="panel-body">

    <div class="row" style="margin: 1%;"> 
            <img class="img" src="<?=$model->passport_photo?>" alt="" style="height: 182px;width: 170px; float:right">

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
                    <h3 class="box-title">TAARIFA YA ELIMU YA  MWOMBAJI(EDUCATIONAL BACKGROUND)</h3>
              </div> 
                <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Elimu ya Shule ya Msingi(Primary School Education History)</h3>
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
                  <h3 class="box-title">Shule ya Sekondari Kidato cha 4(O-level Secondary School)</h3>
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
                  <h3 class="box-title">Shule ya Sekondari Kidato cha 6(A-level Secondary School)</h3>
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
                   <td><b><?= $advanced_level_education_detail->registration_number.'.'.$ordinary_level_education_details->completion_year;?></b></td>
                  </tr>
                <?php } ?>
                </table>
              </div>
                <!-- /.box-body -->
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
                  <tr>
                    <td>Jina la Chuo (College Name) : </td>
                    <td><b><?= $college_level_education_details->learningInstitution->institution_name;?></b></td>
                    <td>Award : </td>
                   <td><b><?= $college_level_education_details->gpa_or_average;?></b></td>
                  </tr>
                  <tr>
                    <td>Region: </td>
                    <td><b><?= $college_level_education_details->learningInstitution->ward->district->region->region_name;?></b></td>
                    <td>Registration No : </td>
                   <td><b><?= $college_level_education_details->registration_number;?></b></td>
                  </tr>
                   <tr>
                    <td>Year of Entry: </td>
                    <td><b><?= $college_level_education_details->entry_year;?></b></td>
                    <td>Year of Graduation: </td>
                   <td><b><?= $college_level_education_details->completion_year;?></b></td>
                  </tr>
                </table>
              </div>
                <!-- /.box-body -->
             </div>
             <?php } ?>

            </div>
          </div>
      </div>

       <div class="row" style="margin: 1%;"> 
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">TAARIFA YA KIJAMII NA UCHUMI YA  MWOMBAJI(APPLICANT'S SOCIO-ECONOMIC DETAILS)</h3>
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
                    <h3 class="box-title">TAARIFA YA WAZAZI/MLEZI (PARENT'S/GUARDIAN'S INFORMATION)</h3>
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
                   <td>Simu ya Baba(Father'ss Mobile Phone) : </td>
                   <td><b><?= $father_details->phone_number;?></b></td>
                 </tr>
                 <tr>
                   <td>Kazi ya Baba : </td>
                   <td><b><?= $mother_details->occupation->occupation_desc;?></b></td>
                 </tr>
                </table>
                <br />
                <?php } ?>
                <?php 
                if($guardian_details){
                ?>
                <table class="table table-condensed">
                  <tr>
                   <td>Jina Kamili la Mlezi(Guardian's Full Name) : </td>
                   <td><b><?= $guardian_details->firstname.' '.$guardian_details->middlename.' '.$guardian_details->surname;?></b></td>
                   <td>Makazi ya Mlezi : </td>
                   <td><b><?= $guardian_details->ward->district->region->region_name;?></b></td>
                  </tr>
                  <tr>
                   <td>Anuani ya Posta Mlesi(Guardian's Postal Address) : </td>
                   <td><b><?= $guardian_details->postal_address;?></b></td>
                   <td>Simu ya Mlezi(Guardian's Mobile Phone) : </td>
                   <td><b><?= $guardian_details->phone_number;?></b></td>
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

    <div class="row no-print">
        <div class="col-xs-12">
          <?php
             if(is_null($model->loan_application_form_status)){
           ?>
           <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/submit-application','id'=>$model->application_id])?>"class="btn btn-success pull-right"><i class="fa fa-save"></i> SUBMIT</a>
           <?php } ?>
           <?php
             if($model->loan_application_form_status >= 1){
           ?>
           <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/application-form','id'=>$model->application_id])?>" target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Download Loan Application Form(PDF)</a>
           <?php } ?>
        </div>
    </div>

