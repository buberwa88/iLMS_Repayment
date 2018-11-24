<?php
use yii\helpers\Html;
use Da\QrCode\QrCode;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use frontend\modules\application\models\Education;
use backend\modules\application\models\Templates;
use frontend\modules\application\models\ApplicantAttachment;
use frontend\modules\application\models\ApplicantAssociate;
use mPDF;
use yii\web\ForbiddenHttpException;
use yii\base\ErrorException;
use frontend\modules\application\models\Application;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */


$primary_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'PRIMARY'])->one();
$ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->one();
$advanced_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'ALEVEL'])->one();
$college_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'COLLEGE'])->one();
$all_ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->all();

$father_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'M'])->one();

$mother_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'F'])->one();

$guardian_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'GD'])->one();

$full_name  = $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;

$form_four_index = 'Index# :'.$ordinary_level_education_details->registration_number.'.'.$ordinary_level_education_details->completion_year;
$form_number = 'Form# :'.$model->application_form_number;

$contract_title_sw = 'MKATABA WA MKOPO KWA MWANAFUNZI - '.$model->academicYear->academic_year;
$title = Application::getApplicationFormTitle($model->applicant_category_id);

      if(!file_exists('applicant_attachment/'.$model->application_id.'.png')){
         $qrCode = (new QrCode('$model->application_id'))
           ->setSize(250)
           ->setMargin(5)
           ->useForegroundColor(51, 153, 255);
           $qrCode->writeFile('applicant_attachment/'.$model->application_id.'.png'); 
          }

  ?>


<?php 
 $mpdf = new mPDF(); 
 $mpdf->SetDefaultFontSize(9.5);
 $mpdf->useDefaultCSS2 = true; 
 $mpdf->SetTitle('Loan Application Form');
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->SetFooter('Loan Application Form  |{PAGENO} |Generated @ {DATE Y-m-j:h-m}');
 $mpdf->SetImportUse(); 

    $header ='<table width="100%">
          <tr>
            <td width="5%" style="text-align: left;">
                  <img class="img" src="applicant_attachment/'.$model->application_id.'.png" alt="" style="height: 70px;width: 50px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATIONS LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
              <img class="img" src="image/logo/logohelsb_new.png" alt="" style="height: 70px;width: 70px;"><br /></b>
             <span style="font-weight: bold; font-size: 9.4pt;">Plot No. 8, Block No. 46; Sam Nujoma Road; P.O.Box 76068, Dar es Salaam, Tanzania</span><br />
             <b>Dar es Salaam, Tanzania<br />
             Tel: (General) +255 22 2772432/2772433; Fax: +255 22 2700286;<br />
             E-mail: info@heslb.go.tz; Website: www.heslb.go.tz<br /><br />
             '.$title['title_eng'].' -'.$model->academicYear->academic_year.'<br /></b>
             <span style="font-weight: bold; font-size: 10pt;">'.$title['title_sw'].'</span>
           </td>
          <td width="10%" style="text-align: right;"><img class="img" src="'.$model->passport_photo.'" alt="" style="height: 120px;width: 120px;"><br />

          </td>
         </tr>
         <tr><td colspan="2"><b>'.$form_four_index.'</b></td><td style="width:20%"><b>'.$form_number.'</b></td></tr>
       </table>
      <br />';
    $mpdf->WriteHTML($header);

    $basic_details = '<div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2">TAARIFA BINAFSI NA ANUANI ZA MWOMBAJI(APPLICANTS PERSONAL DETAILS)</div>
              </div>                              
              <table class="table table-condensed">
                <tr>
                  <td>Jina Kamili(Full Name) : '.$full_name.'</td>
                </tr>
                <tr>
                    <td>Jinsia(Sex)     : '.Application::getApplicantSex($model->applicant->user->sex).'</td>
                    <td>Tarehe ya Kuzaliwa(Date of Birth) : '. $model->applicant->date_of_birth.'</td>
                </tr>
                 <tr>
                   <td>Wilaya Ulikozaliwa(Birth District) : '.$model->applicant->ward->district->district_name.'</td>
                   <td>Mkoa Ulikozaliwa(Birth Region) : '. $model->applicant->ward->district->region->region_name.'</td>
                 </tr>
                 <tr>
                   <td>Barua Pepe(Email) : '. $model->applicant->user->email_address.'</td>
                 </tr>
                 <tr>
                  <td>Namba ya Simu ya Mkononi(Mobile Phone) : '.$model->applicant->user->phone_number.'</td>
                 </tr>
              </table>           
             </div>               
      </div>';
    $mpdf->WriteHTML($basic_details);

    $education_details = '
    <div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2">TAARIFA YA ELIMU YA MWOMBAJI (EDUCATIONAL BACKGROUND)</div>
              </div> 
              <table class="table table-condensed">
                  <tr>
                    <td><i>Elimu ya Shule ya Msingi (Primary School Education History) </i></td>
                  </tr>
                  <tr>
                    <td>Jina la shule (School Name) :   </td><td>'.strtolower($primary_education_details->learningInstitution->institution_name).'</td>
                  </tr>
                  <tr>
                    <td>Year of Entry :   '. $primary_education_details->entry_year.'</td>
                    <td>Year of Graduation : '. $primary_education_details->completion_year.'</td>
                  </tr>
                 <tr>
                   <td>District :   '. $primary_education_details->learningInstitution->ward->district->district_name.'</td>
                   <td>Region : '. $primary_education_details->learningInstitution->ward->district->region->region_name.'</td>
                 </tr>
                 <br />';
                if($model->applicant_category_id == 2){
                  $education_details.= '<tr>
                        <td><i>Elimu Kabla ya Chuo Kikuu (Pre University Education History) </i></td>
                        </tr>';
                     }
              
                foreach ($all_ordinary_level_education_details as $ordinary_level_education_detail) {
                $education_details.= '<tr>
                    <td>Shule ya Sekondari Kidato cha 4(O-level Secondary School) :</td><td> '. $ordinary_level_education_details->learningInstitution->institution_name.'</td>
                  </tr>
                  <tr>
                    <td>Namba ya Mtahiniwa (Form Four Index Number): </td><td>  '.$ordinary_level_education_detail->registration_number.'.'.$ordinary_level_education_detail->completion_year.'</td>
                  </tr>
                  <br />';
                  }$education_details.= '<br />
                  </tr>
                  <tr>
                    <td>Namba ya Mtahiniwa (Form Six Index Number): </td><td>'.$advanced_level_education_details->registration_number.'.'.$advanced_level_education_details->completion_year.'</td>
                  </tr>';
             
                   if($model->applicant_category_id == 2){ 
                  $education_details.= '<br /><br />
                         <tr>
                            <td><i>Elimu ya Chuo Kikuu (Tertiary Education History)</i></td>
                         </tr>
                          <tr>
                            <td>Jina la Chuo (College Name) :  '. $college_level_education_details->learningInstitution->institution_name.'</td>
                        </tr>
                        <tr>
                            <td>Award :  '. $college_level_education_details->gpa_or_average.'</td>
                       </tr>
                       <tr>
                            <td>Region:    '.$college_level_education_details->learningInstitution->ward->ward_name.'</td>
                            <td>Registration No:   '.$college_level_education_details->registration_number.'</td>
                       </tr>
                       <tr>
                            <td>Year of Entry:   '.$college_level_education_details->entry_year.'</td>
                            <td>Year of Graduation:    '. $college_level_education_details->completion_year.'</td>
                       </tr>';
                     }
               $education_details.= ' </table>                                
          </div>
        </div>
      </div>';
     $mpdf->WriteHTML($education_details);

     $socio_economic_details = '
             <div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2"> TAARIFA YA KIJAMII NA UCHUMI YA MWOMBAJI (APPLICANT SOCIO-ECONOMIC DETAILS)</div>
              </div>
               <table class="table table-condensed">
                  <tr>
                    <td>Hali ya wazazi/mlezi na Mwombaji. (Parents Physical/Social Status)</td>
                  </tr>
                  <tr><td>'.Application::getFatherAliveStatus($father_details->is_parent_alive).'</td>
                  </tr><td>'.Application::getMotherAliveStatus($mother_details->is_parent_alive).'</td> </tr>
                 <tr><td>'.Application::getApplicantDisabilityStatus($model->applicant->disability_status).'</td></tr>
                 <tr><td>'.Application::getParentsDisabilityStatus($mother_details->disability_status,$father_details->disability_status).'</td></tr><br />
                </table>                                
          </div>
        </div>
      </div>
     ';
      if($model->applicant_category_id != 2){
        $mpdf->WriteHTML($socio_economic_details);
        }

   $parents_details = '';
    if($mother_details->is_parent_alive == 'YES'){
       $parents_details.= '
       <div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2"> TAARIFA YA WAZAZI/MLEZI (PARENT/GUARDIAN INFORMATION)</div>
              </div>
              <table class="table table-condensed">
                  <tr>
                    <td>Jina Kamili la Mama(Mother Full Name)  :</td><td>'.$mother_details->firstname.' '.$mother_details->middlename.' '.$mother_details->surname.'</td>
                </tr>
                <tr>
                    <td>Anuani ya Posta Mama(Mother Postal Address)  :</td><td>'.$mother_details->postal_address.'</td>
                    <td>Kazi ya Mama  :</td><td>'.$mother_details->occupation->occupation_desc.'</td>
                </tr>
                <tr>
                    <td>Simu ya Mama(Mother Mobile Phone)  :</td><td>'.$mother_details->phone_number.'</td>
                </tr>
                </table>'; 
                } 
           if($father_details->is_parent_alive == 'YES'){
                $parents_details.= '
                <table class="table table-condensed">
                  <tr>
                    <td>Jina Kamili la Baba(Father Full Name)  :</td><td>'.$father_details->firstname.' '.$father_details->middlename.' '.$father_details->surname.'</td>
                </tr>
                <tr>
                    <td>Anuani ya Posta Baba(Father Postal Address)  :</td><td>'.$father_details->postal_address.'</td>
                    <td>Kazi ya Baba  :</td><td>'.$father_details->occupation->occupation_desc.'</td>
                </tr>
                <tr>
                    <td>Simu ya Baba(Father Mobile Phone)  :</td><td>'.$father_details->phone_number.'</td>
                </tr>
                </table>                               
          </div>
        </div>
      </div>
     ';
   }
     if($guardian_details){
                  $parents_details.= '</table>  
                <table class="table table-condensed">
                  <tr>
                    <td>Jina Kamili la Mlezi(Guardian Full Name)  :</td><td>'.$guardian_details->firstname.' '.$guardian_details->middlename.' '.$guardian_details->surname.'</td>
                    <td>Makazi  :</td><td>'.$guardian_details->ward->district->region->region_name.'</td>
                </tr>
                <tr>
                    <td>Anuani ya Posta Mlezi(Guardian Postal Address)  :</td><td>'.$guardian_details->postal_address.'</td>
                </tr>
                <tr>
                    <td>Simu ya Mlezi(Guardian Mobile Phone)  :</td><td>'.$guardian_details->phone_number.'</td>
                </tr>
                 <tr>
                    <td>Kazi ya Mlezi  :</td><td>'.$guardian_details->occupation->occupation_desc.'</td>
                </tr>
                </table>                               
          </div>
        </div>
      </div>
     ';
     }
      $mpdf->WriteHTML($parents_details);

      $page_two_attachment = ApplicantAttachment::find()->where(['application_id' => $model->application_id,'attachment_definition_id' =>2])->one()->attachment_path;
     // exec('gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dBATCH -sOutputFile=uploadimage/profile/mike_two.pdf uploadimage/profile/mike.pdf');
    // $cmd = 'gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dBATCH -sOutputFile=applicant_attachment/ZZ.pdf applicant_attachment/Mike.pdf';
    // $result = shell_exec($cmd);
    // print_r($result);die('Hapaaa');
     $applicant_declaration = $mpdf->SetSourceFile('applicant_attachment/'.$page_two_attachment);
      for($i=1; $i<=$applicant_declaration; $i++) {
        if($i == 1){
           $mpdf->AddPage();
           $tplIdx = $mpdf->ImportPage($i);
           $mpdf->UseTemplate($tplIdx);
          }
        }

      $contract_header = '
      <table width="100%">
          <tr>
            <td width="5%" style="text-align: left;">
                  <img class="img" src="applicant_attachment/'.$model->application_id.'.png " alt="" style="height: 70px;width: 50px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATIONS LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
              <img class="img" src="image/logo/logohelsb_new.png" alt="" style="height: 70px;width: 70px;"><br /></b>
             <span style="font-weight: bold; font-size: 9.4pt;">Plot No. 8, Block No. 46; Sam Nujoma Road; P.O.Box 76068, Dar es Salaam, Tanzania</span><br />
             <b>Dar es Salaam, Tanzania<br />
             Tel: (General) +255 22 2772432/2772433; Fax: +255 22 2700286;<br />
             E-mail: info@heslb.go.tz; Website: www.heslb.go.tz<br />
           </td>
          <td width="10%" style="text-align: right;"><img class="img" src="'.$model->passport_photo.'" alt="" style="height: 120px;width: 120px;"><br />

          </td>
         </tr>
          <tr><td colspan="2"></td><td style="width:20%"><b>'.$form_number.'</b></td></tr>
        <tr><div class="row">
       </table>
      <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2;text-align: center;">'. $contract_title_sw.'</div>
              </div><br />
      <b>1.0 Wahusika wa Mkataba huu</b><br /><br />
      Mkataba huu ni kati ya Bodi ya Mikopo ya Wanafunzi wa Elimu ya Juu , yenye anwani hapo juu, ambayo ndani ya mkataba huu itajulikana kama "Bodi" na <b>'.$full_name.'</b> Ambaye namba yake ya mtihani wa kidato cha Nne ni <b>'.$ordinary_level_education_details->registration_number.'.'.$ordinary_level_education_details->completion_year.'</b> na ambaye katika mkataba huu atajulikana kama Mwanafunzi au Mkopaji.
 ';
      $mpdf->AddPage();
      $mpdf->WriteHTML($contract_header);

      $contract_terms = '<br />
      '.Templates::find()->where(["template_id" => 4])->one()->template_content
      .'<br />
      ';
      $mpdf->WriteHTML($contract_terms);

    $page_five_attachment = ApplicantAttachment::find()->where(['application_id' => $model->application_id,'attachment_definition_id' =>4])->one()->attachment_path;
      $contract_declaration = $mpdf->SetSourceFile('applicant_attachment/'.$page_five_attachment);
      for($i=1; $i<=$contract_declaration; $i++) {
        if($i == 1){
           $mpdf->AddPage();
           $tplIdx = $mpdf->ImportPage($i);
           $mpdf->UseTemplate($tplIdx);
          }
        }

   $list_of_attachments = '
     <b>Orodha ya Viambatanisho(List of Attachments)</b><br />
     Tafadhali,amabatanisha nakala za vivuli vilivyothibitishwa(certified) za nyaraka zifuatazo ili kuthibitisha maelezo yako:-<br />
      1. Uthibitisho wa uraia: <b> "Birth Certificate" Number : '. $model->applicant->birth_certificate_number.'</b><br />
      2. Nakala ya kitambulisho cha mdhamini:<b>'.$guarantor_details->identificationType->identification_type.' : '. $guarantor_details->NID.'</b><br />
      3.Nakala ya vivuli vya vyeti au barua zote ulizopandisha kwenye mfumo
      '.
        Templates::find()->where(["template_id" => 5])->one()->template_content
     .' <br />
 ';
   $mpdf->AddPage();
  $mpdf->WriteHTML($list_of_attachments);

$mpdf->Output('Loan Application Form.pdf', 'I');
exit;

//==============================================================
//==============================================================
//==============================================================


?>
