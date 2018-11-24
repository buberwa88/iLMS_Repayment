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

$attachmentDefinitionID='3';
$resultsPathDefini=\backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($attachmentDefinitionID,$model->application_id);

$primary_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'PRIMARY'])->one();
$ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->one();
$advanced_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'ALEVEL'])->one();
$college_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'COLLEGE'])->one();
$bachelor_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'BACHELOR'])->one();
$masters_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'MASTERS'])->one();
$all_ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->limit(2)->all();

$father_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'M'])->one();

$mother_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'PR','sex' => 'F'])->one();

$guardian_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'GD'])->one();

$full_name  = $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;

$form_four_index = 'Index#: '.$ordinary_level_education_details->registration_number.'.'.$ordinary_level_education_details->completion_year;
$form_number = 'Form#: '.$model->application_form_number;

$contract_title_sw = 'MKATABA WA MKOPO KWA MWANAFUNZI - '.$model->academicYear->academic_year;
$title = Application::getApplicationFormTitle($model->applicant_category_id);

      if(!file_exists('applicant_attachment/'.$model->application_form_number.'.png')){
         $qrCode = (new QrCode($model->application_form_number))
           ->setSize(250)
           ->setMargin(5)
           ->useForegroundColor(51, 153, 255);
           $qrCode->writeFile('applicant_attachment/'.$model->application_form_number.'.png'); 
          }

  ?>


<?php 
 $mpdf = new mPDF(); 
 $mpdf->SetDefaultFontSize(8);
 $mpdf->useDefaultCSS2 = true; 
 $mpdf->SetTitle('Loan Application Form');
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->SetFooter('Loan Application Form  |Page #{PAGENO} out of {nbpg} |Generated @ {DATE Y-m-j:h-m}');
 $mpdf->SetImportUse(); 

    $header ='<table width="100%">
          <tr>
            <td width="5%" style="text-align: left;">
                  <img class="img" src="applicant_attachment/'.$model->application_form_number.'.png" alt="" style="height: 100px;width: 80px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATION STUDENTS'."'".'  LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
              <img class="img" src="image/logo/logohelsb_new.jpg" alt="" style="height: 70px;width: 70px;"><br />
             <span style="font-weight: bold; font-size: 9.4pt;">Plot No. 8, Block No. 46; Sam Nujoma Road; P.O.Box 76068, Dar es Salaam, Tanzania</span><br />
             <b>Dar es Salaam, Tanzania<br />
             Tel: (General) +255 22 2772432/2772433; Fax: +255 22 2700286;<br />
             E-mail: info@heslb.go.tz; Website: www.heslb.go.tz<br /><br />
             '.$title['title_eng'].' -'.$model->academicYear->academic_year.'<br /></b>
             <span style="font-weight: bold; font-size: 8.8pt;">'.$title['title_sw'].'</span>
           </td>
          <td width="10%" style="text-align: right;"><img class="img" src="'.$model->passport_photo.'" alt="" style="height: 120px;width: 120px;"><br />

          </td>
         </tr>
         <tr><td colspan="2"><b>'.$form_four_index.'</b></td><td style="width:20%"><b>'.$form_number.'</b></td></tr>
       </table>
      <br />';
    $mpdf->WriteHTML($header);

        $basic_details = '
        <style>p{margin:4}</style><div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2">TAARIFA BINAFSI NA ANUANI ZA MWOMBAJI(APPLICANTS PERSONAL DETAILS)</div>
              </div>
              <table>
                <tr>
                  <td>Jina Kamili (Full Name) : '.$full_name.'</td>
                  <td width="40%" style="float: right;">Jinsia (Sex)     : '.Application::getApplicantSex($model->applicant->user->sex).'</td>
                </tr>
                <tr>
                    <td>Tarehe ya Kuzaliwa (Date of Birth) : '. $model->applicant->date_of_birth.'</td>
                    <td width="40%" style="float: right;">Wilaya Ulikozaliwa (Birth District) : '.$model->applicant->ward->district->district_name.'</td>
                </tr>
                 <tr>
                   <td>Mkoa Ulikozaliwa (Birth Region) : '. $model->applicant->ward->district->region->region_name.'</td>
                   <td width="40%" style="float: right;">Barua Pepe (Email) : '. $model->applicant->user->email_address.'</td>
                 </tr>
                 <tr>
                   <td>Namba ya Simu ya Mkononi (Mobile Phone) : '.$model->applicant->user->phone_number.'</td>
                 </tr>
              </table>
             </div>
      </div><br />';

    $mpdf->WriteHTML($basic_details);
 $education_details = '
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2">TAARIFA YA ELIMU YA MWOMBAJI (EDUCATIONAL BACKGROUND)</div>
              </div>
               <table width = "100%">
                  <tr><td>Elimu ya Shule ya Msingi (Primary School Education History)</td></tr>
                  <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jina la shule (School Name) :'.strtoupper($primary_education_details->learningInstitution->institution_name).'</td></tr>
                  <tr style="float: right;">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year of Entry :   '. $primary_education_details->entry_year.'</td>
                    <td width="50%" style="float: right;">Year of Graduation : '. $primary_education_details->completion_year.'</td>
                  </tr>
                 <tr style="float: right;">
                   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region :   '. $primary_education_details->learningInstitution->ward->district->region->region_name.'</td>
                   <td width="50%" style="float: right;">District : '. $primary_education_details->learningInstitution->ward->district->district_name.'</td>
                 </tr>
               </table>';
                if($model->applicant_category_id == 2){
                  $education_details.= '<p>
                        Elimu Kabla ya Chuo Kikuu (Pre University Education History)
                        </p>';
                     }

                   foreach ($all_ordinary_level_education_details as $ordinary_level_education_detail) {
                     $education_details.= '<p><table width = "100%">
                  <tr>
                    <td width="50%">Shule ya Sekondari Kidato cha 4 (O-level Secondary School) :</td><td width="50%">'. $ordinary_level_education_detail->learningInstitution->institution_name.'</td>
                  </tr>
                  <tr>
                    <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Namba ya Mtahiniwa (Form Four Index Number): </td><td width="50%">'.$ordinary_level_education_detail->registration_number.'.'.$ordinary_level_education_detail->completion_year.'</td>
                  </tr>

                      </table></p>';
                  }

                if($advanced_level_education_details){
                $education_details.= '<p><table width = "100%">
                  <tr>
                    <td width="50%">Shule ya Sekondari Kidato cha 6 (A-level Secondary School) :</td><td width="50%" style="float: right;">'. $advanced_level_education_details->learningInstitution->institution_name.'</td>
                  </tr>
                  <tr>
                    <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Namba ya Mtahiniwa (Form Six Index Number): </td><td width="50%" style="float: right;">'.$advanced_level_education_details->registration_number.'.'.$advanced_level_education_details->completion_year.'</td>
                  </tr></table></p>';
               }

                if($college_level_education_details){
                  $education_details.= '<p><table width = "60%">
                         <tr>
                            <td colspan="2">Elimu baada ya Form IV - Chuo cha Diploma</td>
                         </tr>
                          <tr>
                            <td>Jina la Chuo (College Name) :  </td><td width="40%" style="float: right;">'. $college_level_education_details->learningInstitution->institution_name.'</td>
                        </tr>
                        <tr>
                            <td>Completed Year :  </td><td width="40%" style="float: right;">'. $college_level_education_details->completion_year.'</td>
                       </tr>
                       <tr></table></p>';
                     }        

                 if( $model->applicant_category_id == 2){
                   $education_details.= '<table>
                         <tr>
                            <td colspan="2">Elimu ya Chuo Kikuu (Tertiary Education History)</td>
                         </tr>';
                if($bachelor_level_education_details){
                  $education_details.= '
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jina la Chuo (College Name) :  </td><td width="40%" style="float: right;">'. $bachelor_level_education_details->learningInstitution->institution_name.'</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entry Year :  '. $bachelor_level_education_details->entry_year.'</td>
                            <td>Completed Year :  '. $bachelor_level_education_details->completion_year.'</td>
                       </tr>
                       <tr>';
                     }
                if($masters_level_education_details){
                  $education_details.= '<br />
                          <tr>
                            <td>Jina la Chuo (College Name) :  </td><td width="40%" style="float: right;">'. $masters_level_education_details->learningInstitution->institution_name.'</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entry Year :  '. $masters_level_education_details->entry_year.'</td>
                            <td>Completed Year :  '. $masters_level_education_details->completion_year.'</td>
                       </tr>
                       <tr>';
                     }
                   }
               $education_details.= ' </table><br />';

     $mpdf->WriteHTML($education_details);

     $socio_economic_details = '
       <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2"> TAARIFA ZA KIJAMII NA UCHUMI YA MWOMBAJI (APPLICANT'."'S".' SOCIO-ECONOMIC DETAILS)</div>
              </div>
              <table class="table table-condensed">
                  <tr>
                    <td>Hali ya wazazi/mlezi na Mwombaji. (Parents Physical/Social Status)</td>
                  </tr>
                  <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Application::getFatherAliveStatus($father_details->is_parent_alive).'</td></tr>
                  <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Application::getMotherAliveStatus($mother_details->is_parent_alive).'</td></tr>
                 <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Application::getApplicantDisabilityStatus($model->applicant->disability_status).'</td></tr>
                 <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Application::getParentsDisabilityStatus($mother_details->disability_status,$father_details->disability_status).'</td></tr>
                </table>
          </div>
        </div>
      </div><br/>
     ';

        $mpdf->WriteHTML($socio_economic_details);       
   $parents_details = '<div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2"> TAARIFA ZA WAZAZI/MLEZI (PARENTS/GUARDIAN INFORMATION)</div>
              </div>';
  if($mother_details->is_parent_alive == 'YES'){
       $parents_details.= '
              <table>
                <tr>
                 <td style="width:60%"><table>
                  <tr>
                     <td style="width:50%">Jina Kamili la Mama (Mother'."'s".' Full Name) : '.$mother_details->firstname.' '.$mother_details->middlename.' '.$mother_details->surname .' </td>
                  </tr>
                  <tr>
                     <td>Anwani ya Posta : '. $mother_details->ward->district->region->region_name.'</td>
                  </tr>
                  <tr>
                      <td>Simu ya Mama (Mother'."'s".' Mobile Phone)  :'.$mother_details->phone_number.'</td>
                  </tr>
                 </table></td>
                <td style="width:40%;">
                <table>
                <tr>
                   <tr><td>Makazi : '. $mother_details->ward->district->region->region_name.'</td></tr>
                    <tr><td>Kazi ya Mama  :'.$mother_details->occupation->occupation_desc.'</td></tr>
                </tr>
                </table>
                </td>
                </tr>
            </table>';
              }

           if($father_details->is_parent_alive == 'YES'){
                $parents_details.= '<table>
                <tr>
                 <td style="width:60%"><table>
                  <tr>
                     <td style="width:50%">Jina Kamili la Baba (Father'."'s".' Full Name) : '.$father_details->firstname.' '.$father_details->middlename.' '.$father_details->surname .' </td>
                  </tr>
                  <tr>
                     <td>Anwani ya Posta : '. $father_details->ward->district->region->region_name.'</td>
                  </tr>
                  <tr>
                      <td>Simu ya Baba (Father'."'s".' Mobile Phone)  :'.$father_details->phone_number.'</td>
                  </tr>
                 </table></td>
                <td style="width:40%;">
                <table>
                <tr>
                   <tr><td>Makazi : '. $father_details->ward->district->region->region_name.'</td></tr>
                    <tr><td>Kazi ya Baba  :'.$father_details->occupation->occupation_desc.'</td></tr>
                </tr>
                </table>
                </td>
                </tr>
            </table>';
    }

      if($guardian_details){
                  $parents_details.= '<table>
                <tr>
                 <td style="width:60%"><table>
                  <tr>
                     <td style="width:50%">Jina Kamili la Mlezi (Guardian'."'s".' Full Name) : '.$guardian_details->firstname.' '.$guardian_details->middlename.' '.$guardian_details->surname .' </td>
                  </tr>
                  <tr>
                     <td>Anwani ya Posta : '. $guardian_details->ward->district->region->region_name.'</td>
                  </tr>
                  <tr>
                      <td>Simu ya Mlezi (Guardian'."'s".' Mobile Phone)  :'.$guardian_details->phone_number.'</td>
                  </tr>
                 </table></td>
                <td style="width:40%;">
                <table>
                <tr>
                   <tr><td>Makazi : '. $guardian_details->ward->district->region->region_name.'</td></tr>
                    <tr><td>Kazi ya Mlezi  :'.$guardian_details->occupation->occupation_desc.'</td></tr>
                </tr>
                </table>
                </td>
                </tr>
            </table>
     ';
     }
   
               
    if($model->applicant_category_id != 2){
         $mpdf->WriteHTML($parents_details);
      }

      $page_two_attachment = ApplicantAttachment::find()->where(['application_id' => $model->application_id,'attachment_definition_id' =>1])->one()->attachment_path;
      $applicant_declaration = $mpdf->SetSourceFile($page_two_attachment);
    // $applicant_declaration = $mpdf->SetSourceFile('applicant_attachment/loanApplicationFormPageNumberTwo_14493U2018.pdf');
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
                  <img class="img" src="applicant_attachment/'.$model->application_form_number.'.png " alt="" style="height: 100px;width: 80px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATION STUDENTS'."'".' LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
              <img class="img" src="image/logo/logohelsb_new.jpg" alt="" style="height: 70px;width: 70px;"><br /></b>
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
     <div style="text-align: justify;"> Mkataba huu ni kati ya <b>Bodi ya Mikopo ya Wanafunzi wa Elimu ya Juu</b> , yenye anwani hapo juu, ambayo ndani ya mkataba huu itajulikana kama <b>"Bodi"</b> na <b>'.$full_name.'</b> ambaye namba yake ya mtihani wa kidato cha Nne ni <b>'.$ordinary_level_education_details->registration_number.'.'.$ordinary_level_education_details->completion_year.'</b> na ambaye katika mkataba huu atajulikana kama <b>Mwanafunzi au Mkopaji</b>.
 </div>';
      $mpdf->AddPage();
      $mpdf->WriteHTML($contract_header);

      $contract_terms = '<br /><div style="text-align: justify;">
      '.Templates::find()->where(["template_id" => 3])->one()->template_content
      .'<br /></div>
      ';
      $mpdf->WriteHTML($contract_terms);

      $page_five_attachment = ApplicantAttachment::find()->where(['application_id' => $model->application_id,'attachment_definition_id' =>2])->one()->attachment_path;
      $contract_declaration = $mpdf->SetSourceFile($page_five_attachment);
      for($i=1; $i<=$contract_declaration; $i++) {
        if($i == 1){
           $mpdf->AddPage();
           $tplIdx = $mpdf->ImportPage($i);
           $mpdf->UseTemplate($tplIdx);
          }
        }
    

    $list_of_attachments = '
     <p align="right"><b>'.$form_number.'</b></p>
     <b>Orodha ya Viambatanisho (List of Attachments)</b><br />
      <div style="text-align: justify;">
       <p>Tafadhali,ambatanisha nakala za vivuli vilivyothibitishwa (certified) za nyaraka zifuatazo ili kuthibitisha maelezo yako:-</p>
       <p>1. Uthibitisho wa uraia: <b> "Birth Certificate" Number : '. $model->applicant->birth_certificate_number.'</p>
       <p>2. Nakala ya kitambulisho cha mdhamini:<b>'.$guarantor_details->identificationType->identification_type.' : '. $guarantor_details->NID.'</p>
       <p>3.Nakala ya vivuli vya vyeti au barua zote ulizopandisha kwenye mfumo</p>'.
        Templates::find()->where(["template_id" => 4])->one()->template_content
     .' <br /></div>
   ';
   $mpdf->AddPage();
  $mpdf->WriteHTML($list_of_attachments);

$mpdf->Output('Loan Application Form.pdf', 'I');
exit;

//==============================================================
//==============================================================
//==============================================================


?>
