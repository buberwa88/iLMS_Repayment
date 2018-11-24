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
$bachelor_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'BACHELOR'])->one();
$masters_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'MASTERS'])->one();
$all_ordinary_level_education_details = Education::find()->where(['application_id' => $model->application_id,'level' => 'OLEVEL'])->limit(2)->all();
$guarantor_details = ApplicantAssociate::find()->where(['application_id' => $model->application_id,'type' => 'GA'])->one();
$guarantor_full_name = $guarantor_details->firstname.' '.$guarantor_details->middlename.' '.$guarantor_details->surname;

$full_name  = $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;

$form_four_index = 'Index#: '.$ordinary_level_education_details->registration_number.'.'.$ordinary_level_education_details->completion_year;
$form_number = 'Form#: '.$model->application_form_number;
$contract_title_sw = 'MKATABA WA MKOPO KWA MWANAFUNZI - '.$model->academicYear->academic_year;
$title = Application::getApplicationFormTitle($model->applicant_category_id);

            if(!file_exists('../applicant_attachment/'.$model->application_form_number.'.png')){
         if($model->application_form_number === NULL){
           $qrCode = (new QrCode($model->application_id))
           ->setSize(250)
           ->setMargin(5)
           ->useForegroundColor(51, 153, 255);
           $qrCode->writeFile('../applicant_attachment/'.$model->application_form_number.'.png');
          }else{
          $qrCode = (new QrCode($model->application_form_number))
           ->setSize(250)
           ->setMargin(5)
           ->useForegroundColor(51, 153, 255);
           $qrCode->writeFile('../applicant_attachment/'.$model->application_form_number.'.png');
          }
        }

  ?>


<?php 
 $mpdf = new mPDF(); 
// $mpdf =new mPDF('th', 'A4', '0', 'THSaraban');
 $mpdf->SetDefaultFontSize(8.0);
 $mpdf->useDefaultCSS2 = true; 
 $mpdf->SetTitle('Loan Application Form');
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->SetFooter('Loan Application Form  |Page #{PAGENO} out of {nbpg} |Generated @ {DATE d/m/Y H:i:s}');
 $mpdf->SetImportUse(); 

    $header ='<table width="100%">
          <tr>
            <td width="5%" style="text-align: left;">
                  <img class="img" src="../applicant_attachment/'.$model->application_form_number.'.png" alt="" style="height: 100px;width: 80px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATION STUDENTS'."'".' LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
              <img class="img" src="../image/logo/logohelsb_new.jpg" alt="" style="height: 70px;width: 70px;"><br /></b>
             <span style="font-weight: bold; font-size: 9.4pt;">Plot No. 8, Block No. 46; Sam Nujoma Road; P.O.Box 76068, Dar es Salaam, Tanzania</span><br />
             <b>Dar es Salaam, Tanzania<br />
             Tel: (General) +255 22 2772432/2772433; Fax: +255 22 2700286;<br />
             E-mail: info@heslb.go.tz; Website: www.heslb.go.tz<br /><br />
             '.$title['title_eng'].' - '.$model->academicYear->academic_year.'<br /></b>
             <span style="font-weight: bold; font-size: 8.8pt;">'.$title['title_sw'].'</span>
           </td>
          <td width="10%" style="text-align: right;"><img class="img" src="../'.$model->passport_photo.'" alt="" style="height: 120px;width: 120px;"><br />

          </td>
         </tr>
         <tr><td colspan="2"><b>'.$form_four_index.'</b></td><td style="width:20%"><b>'.$form_number.'</b></td></tr>
       </table>';
    $mpdf->WriteHTML($header);

     $basic_details = '
        <style>p{margin:4}</style><div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2">TAARIFA BINAFSI NA ANUANI ZA MWOMBAJI (APPLICANT'."'".'S PERSONAL DETAILS)</div>
              </div><br />                           
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
      </div><br /><br />';
    
    $mpdf->WriteHTML($basic_details);

    $education_details = '
    <div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2">TAARIFA YA ELIMU YA MWOMBAJI (EDUCATIONAL BACKGROUND)</div>
              </div>
               <table width = "100%">
                  <tr><td><b>Elimu ya Shule ya Msingi (Primary School Education History)</b></td></tr>
                  <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jina la shule (School Name) :'.strtoupper($primary_education_details->learningInstitution->institution_name).'</td></tr>
                  <tr style="float: right;">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year of Entry :   '. $primary_education_details->entry_year.'</td>
                    <td width="50%" style="float: right;">Year of Graduation : '. $primary_education_details->completion_year.'</td>
                  </tr>
                 <tr style="float: right;">
                   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region :   '. $primary_education_details->learningInstitution->ward->district->region->region_name.'</td>
                   <td width="50%" style="float: right;">District : '. $primary_education_details->learningInstitution->ward->district->district_name.'</td>
                 </tr>
               </table><br />';
                if($model->applicant_category_id == 2 || $model->applicant_category_id > 3){
                  $education_details.= '<p>
                        <b>Elimu Kabla ya Chuo Kikuu (Pre University Education History)</b>
                        </p>';
                     }
              
                   foreach ($all_ordinary_level_education_details as $ordinary_level_education_detail) {
                     $education_details.= '<p><table width = "100%">
                  <tr>
                    <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shule ya Sekondari Kidato cha 4 (O-level Secondary School) :</td><td width="50%">'. $ordinary_level_education_detail->learningInstitution->institution_name.'</td>
                  </tr>
                  <tr>
                    <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Namba ya Mtahiniwa (Form Four Index Number): </td><td width="50%">'.$ordinary_level_education_detail->registration_number.'.'.$ordinary_level_education_detail->completion_year.'</td>
                  </tr>

                      </table></p>';
                  }
            
                if($advanced_level_education_details){
                $education_details.= '<p><table width = "100%">
                  <tr>
                    <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shule ya Sekondari Kidato cha 6 (A-level Secondary School) :</td><td width="50%">'. $advanced_level_education_details->learningInstitution->institution_name.'</td>
                  </tr>
                  <tr>
                    <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Namba ya Mtahiniwa (Form Six Index Number): </td><td width="50%" >'.$advanced_level_education_details->registration_number.'.'.$advanced_level_education_details->completion_year.'</td>
                  </tr></table></p><br />';
               }

                if($college_level_education_details){
                  $education_details.= '<p><table width = "60%">
                         <tr>
                            <td colspan="2"><b>Elimu baada ya Form IV - Chuo cha Diploma</b></td>
                         </tr>
                          <tr>
                            <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jina la Chuo (College Name) :  </td><td width="40%" style="float: right;">'. $college_level_education_details->learningInstitution->institution_name.'</td>
                        </tr>
                        <tr>
                            <td>Completed Year :  </td><td width="40%" style="float: right;">'. $college_level_education_details->completion_year.'</td>
                       </tr>
                       <tr></table></p><br />';
                     }         

                 if( $model->applicant_category_id == 2 || $model->applicant_category_id > 3){ 
                   $education_details.= '<table width="100%">
                         <tr>
                            <td colspan="2"><b>Elimu ya Chuo Kikuu (Tertiary Education History)</b></td>
                         </tr>';
                if($bachelor_level_education_details){
                  $education_details.= '
                          <tr>
                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jina la Chuo (College Name) : '. $bachelor_level_education_details->institution_name.'</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Award : '. $bachelor_level_education_details->programme_name.'</td>
                        </tr>
                         <tr>
                            <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region :  '. $bachelor_level_education_details->region->region_name.'</td>
                            <td>Registration No :  '. $bachelor_level_education_details->avn_number.'</td>
                       </tr>

                        <tr>
                            <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year of Entry :  '. $bachelor_level_education_details->entry_year.'</td>
                            <td>Year of Graduation :  '. $bachelor_level_education_details->completion_year.'</td>
                       </tr>
                       <tr><br /><br />';
                     }
                if($masters_level_education_details){
                  $education_details.= '<br />
                        <tr>
                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jina la Chuo (College Name) : '. $masters_level_education_details->learningInstitution->institution_name.'</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Award : '. $masters_level_education_details->programme_name.'</td>
                        </tr>
                        <tr>
                            <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region :  '. $masters_level_education_details->region->region_name.'</td>
                            <td>Registration No :  '. $masters_level_education_details->avn_number.'</td>
                       </tr>
                      <tr>
                            <td width="60%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year of Entry :  '. $masters_level_education_details->entry_year.'</td>
                            <td>Year of Graduation :  '. $masters_level_education_details->completion_year.'</td>
                       </tr>
                       <tr>';
                     }
                   }
               $education_details.= ' </table><br /><br />';

     $mpdf->WriteHTML($education_details);

     $page_two_attachment = ApplicantAttachment::find()->where(['application_id' => $model->application_id,'attachment_definition_id' =>1])->one()->attachment_path;
     if($page_two_attachment){
     $applicant_declaration = $mpdf->SetSourceFile('../'.$page_two_attachment);
      for($i=1; $i<=$applicant_declaration; $i++) {
        if($i == 1){
           $mpdf->AddPage();
           $tplIdx = $mpdf->ImportPage($i);
           $mpdf->UseTemplate($tplIdx);
          }
        }
      }

      $contract_header = '
      <table width="100%">
          <tr>
            <td width="5%" style="text-align: left;">
                  <img class="img" src="../applicant_attachment/'.$model->application_form_number.'.png " alt="" style="height: 100px;width: 80px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATION STUDENTS'."'".' LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
              <img class="img" src="../image/logo/logohelsb_new.jpg" alt="" style="height: 70px;width: 70px;"><br /></b>
             <span style="font-weight: bold; font-size: 9.4pt;">Plot No. 8, Block No. 46; Sam Nujoma Road; P.O.Box 76068, Dar es Salaam, Tanzania</span><br />
             <b>Dar es Salaam, Tanzania<br />
             Tel: (General) +255 22 2772432/2772433; Fax: +255 22 2700286;<br />
             E-mail: info@heslb.go.tz; Website: www.heslb.go.tz<br />
           </td>
          <td width="10%" style="text-align: right;"><img class="img" src="../'.$model->passport_photo.'" alt="" style="height: 120px;width: 120px;"><br />

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
     if($page_five_attachment){
      $contract_declaration = $mpdf->SetSourceFile('../'.$page_five_attachment);
      for($i=1; $i<=$contract_declaration; $i++) {
        if($i == 1){
           $mpdf->AddPage();
           $tplIdx = $mpdf->ImportPage($i);
           $mpdf->UseTemplate($tplIdx);
          }
        }
     }

  $postgraduate_list_of_attachments = '
   <p align="right"><b>'.$form_number.'</b></p>
    <b>Orodha ya Viambatanisho (List of Attachments)</b><br />
    <div style="text-align: justify;"> <br />
     <p>Tafadhali ambatanisha nakala za vivuli vilivyothibitishwa (certified copies) za nyaraka zifuatazo ili kuthibitisha maelezo yako :-</p><br />
     <p>1.Uthibitisho wa uraia: <b> "Birth Certificate" Number : '. $model->applicant->birth_certificate_number.'<br /></p>'.
        Templates::find()->where(["template_id" => 7])->one()->template_content
     .' <br /></div>
   ';
$mpdf->AddPage();
$mpdf->WriteHTML($postgraduate_list_of_attachments);

$mpdf->Output('Loan Application Form.pdf', 'I');
exit;

//==============================================================
//==============================================================
//==============================================================


?>


