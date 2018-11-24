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
use frontend\modules\application\models\ApplicantAssociate;
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
// $mpdf =new mPDF('th', 'A4', '0', 'THSaraban');
 $mpdf->SetDefaultFontSize(8.0);
 $mpdf->useDefaultCSS2 = true; 
 $mpdf->SetTitle('Loan Application Form');
 $mpdf->SetDisplayMode('fullpage');
 $mpdf->SetFooter('Loan Application Form  |Page #{PAGENO} out of {nbpg} |Generated @ {DATE d/m/Y H:i:s}');


    $header ='<table width="100%">
          <tr>
            <td width="5%" style="text-align: left;">
                  <img class="img" src="applicant_attachment/'.$model->application_form_number.'.png" alt="" style="height: 100px;width: 80px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATION STUDENTS'."'".' LOANS BOARD</span><br />
             <b><i>(BODI YA MIKOPO YA WANAFUNZI WA ELIMU YA JUU)</i></b><br />
              <img class="img" src="image/logo/logohelsb_new.jpg" alt="" style="height: 70px;width: 70px;"><br /></b>
             <span style="font-weight: bold; font-size: 9.4pt;">Plot No. 8, Block No. 46; Sam Nujoma Road; P.O.Box 76068, Dar es Salaam, Tanzania</span><br />
             <b>Dar es Salaam, Tanzania<br />
             Tel: (General) +255 22 2772432/2772433; Fax: +255 22 2700286;<br />
             E-mail: info@heslb.go.tz; Website: www.heslb.go.tz<br /><br />
             '.$title['title_eng'].' - '.$model->academicYear->academic_year.'<br /></b>
             <span style="font-weight: bold; font-size: 8.8pt;">'.$title['title_sw'].'</span>
           </td>
          <td width="10%" style="text-align: right;"><img class="img" src="'.$model->passport_photo.'" alt="" style="height: 120px;width: 120px;"><br />

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
                  <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jina la shule (School Name) :'.strtoupper($primary_education_details->learningInstitution->institution_name).'</td></tr>
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

                 if( $model->applicant_category_id == 2 || $model->applicant_category_id==4|| $model->applicant_category_id==5){ 
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
                            <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region :  '. $bachelor_level_education_details->region->region_name.'</td>
                            <td>Registration No :  '. $bachelor_level_education_details->avn_number.'</td>
                       </tr>

                        <tr>
                            <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year of Entry :  '. $bachelor_level_education_details->entry_year.'</td>
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
                            <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Region :  '. $masters_level_education_details->region->region_name.'</td>
                            <td>Registration No :  '. $masters_level_education_details->avn_number.'</td>
                       </tr>
                      <tr>
                            <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year of Entry :  '. $masters_level_education_details->entry_year.'</td>
                            <td>Year of Graduation :  '. $masters_level_education_details->completion_year.'</td>
                       </tr>
                       <tr>';
                     }
                   }
               $education_details.= ' </table><br /><br />';

     $mpdf->WriteHTML($education_details);

     $applicant_declaration = '
         <div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2"> UTHIBITISHO WA MWOMBAJI (APPLICANT'."'S".' DECLARATION)</div>
              </div><br />
              <div style="text-align: justify;">Mimi <u><b>'. $full_name.'</b></u>  '.Templates::find()->where(["template_id" => 1])->one()->template_content                               
          .'</div></div>
        </div>
      </div>
      <br /><br />
      Jina Kamili la Mwombaji:   <u><b>'. $full_name.'</b></u>  '.'Tarehe: ______________________ Sahihi : ________________________
      <br /><br /><br />
      <div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2">UTHIBITISHO WA TAARIFA BINAFSI NA KAMISHNA WA VIAPO (CERTIFICATION BY COMMISSIONER OF OATHS)
              </div>
              </div><br /><br />
              <table class="table table-condensed">
                  <tr>
                   <td> Jina Kamili la Kamishna : __________________________________________________________________________Weka Muhuri wa ofisi hapa</td>
                  </tr><br /><br /><br />
                  <tr>
                    <td>Sahihi: ___________________________________________Tarehe : ___________________________</td>
                  </tr>
                </table>
                                               
          </div>
        </div>
      </div>
      <br /><br />
      <br /><br /><br /><br />

      <div class="row"> 
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2"> UTHIBITISHO WA SERIKALI YA KIJIJI/MTAA KUHUSU MAELEZO YA MWOMBAJI<br />
              </div>
              </div><div style="text-align: justify;">'.
              Templates::find()->where(["template_id" => 2])->one()->template_content                                 
          .'</div></div>
        </div>
      </div>
      <br />';

      $mpdf->AddPage();
      $mpdf->WriteHTML($applicant_declaration);

      $contract_header = '
     <table width="100%">
          <tr>
            <td width="5%" style="text-align: left;">
                  <img class="img" src="applicant_attachment/'.$model->application_form_number.'.png " alt="" style="height: 100px;width: 80px; float:right"><br />

            </td>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">HIGHER EDUCATION STUDENTS'."'".'  LOANS BOARD</span><br />
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

      $contract_declaration = '
        <b>3.0 Matamko </b><br /><br />
        <b>Sehemu hii itashuhudiwa na Wakili au Hakimu</b>
        <br /><br />
        <b>3.1 Tamko la Mwanafunzi</b><br />
        <div>
          <table class="table table-condensed" width="100%">
                  <tr>
                    <td style="width:50%">Jina Kamili : '. $full_name.' </td>
                    <td style="width:50%">Anwani ya Posta : '. $model->applicant->mailing_address.'</td>
                  </tr>
                 <tr>
                    <td>Kijiji/Mtaa : '. $model->applicant->village_domicile.' </td>
                    <td>Kata/Shehia : '. $model->applicant->warddomicile->ward_name.'</td>
                 </tr>
                 <tr>
                    <td>Wilaya : '. $model->applicant->warddomicile->district->district_name.' </td>
                    <td>Mkoa : '. $model->applicant->warddomicile->district->region->region_name.'</td>
                 </tr>
                 <tr>
                    <td>Barua pepe : '. $model->applicant->user->email_address.' </td>
                    <td>Namba ya Simu ya Mkononi : '. $model->applicant->user->phone_number.'</td>
                 </tr>
            </table><br />
            Mimi <b><u>'. strtoupper($full_name).'</u></b> niliye mwanafunzi mkopaji, bila shinikizo lolote, na nikiwa na akili timamu nimesoma na kuelewa na kukubali kanuni na masharti ya mkataba huu nikishuhudiwa na aliyesaini hapa chini <br /><br />
            Sahihi (ya mwanafunzi): ___________________________________ Tarehe : _______________________________________
           
            </div><br /><br />

            <div>';
      if($guarantor_details->organization_type != 1){
                  $contract_declaration.= '
          <b>3.2 Tamko la Mdhamini (lazima awe mkuu wa taasisi unayofanyia kazi)</b><br />
          <table class="table table-condensed" width="100%">
                  <tr>
                    <td style="width:50%">Jina la Taasisi : '. $guarantor_details->organization_name.' </td>
                    <td style="width:50%">Physical Address : '. $guarantor_details->physical_address.' </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Anwani ya Posta : '. $guarantor_details->ward->ward_name.' </td>
                    <td style="width:50%">Telephone : '. $guarantor_details->phone_number.'</td>
                 </tr>
                  <tr>
                    <td style="width:50%">Mkoa : '. $guarantor_details->ward->district->region->region_name.'</td>
                    <td style="width:50%">Wilaya : '.$guarantor_details->ward->district->district_name.' </td>                    
                 </tr>
   
            </table><br />

            <b>Contact Person Details</b><br />
          <table class="table table-condensed" width="100%">
                  <tr>
                    <td style="width:50%">Jina : '. $guarantor_full_name.' </td>
                    <td style="width:50%">Cheo : '. $guarantor_details->guarantorPosition->guarantor_position.' </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Namba ya Simu ya Mkononi : '. $guarantor_details->phone_number.'</td>
                    <td style="width:50%">Barua Pepe : '.$guarantor_details->email_address.' </td>                    
                 </tr>
            </table><br />

            Sahihi: _________________________________________________ Tarehe : _______________________________________________
           
            </div><br /><br />

    <br /><b>3.3 Ushuhuda wa Wakili/Hakimu</b><br />'.Templates::find()->where(["template_id" => 5])->one()->template_content;
}
else{
        $contract_declaration.= '
          <b>3.2 Tamko la Mdhamini (lazima awe mkuu wa chuo unachofanyia kazi)</b><br />
          <table class="table table-condensed" width="100%">
                  <tr>
                    <td style="width:50%">Jina la Chuo : '. $guarantor_details->organization_name.' </td>
                    <td style="width:50%">Anwani ya Posta : '. $guarantor_details->ward->ward_name.' </td>
                  </tr>
                  <tr>
                    <td style="width:50%">Telephone : '. $guarantor_details->phone_number.'</td>
                    <td style="width:50%">Region : '. $guarantor_details->ward->district->region->region_name.'</td>                   
                 </tr>
                 <tr>
                    <td style="width:50%">Cheo : '. $guarantor_details->guarantorPosition->guarantor_position.' </td>
                    <td style="width:50%">Sahihi na Muhuri wa Ofisi : ____________________________________</td>
                 </tr>
   
            </table><br /><br /><br /> <b>3.3 Ushuhuda wa Wakili/Hakimu</b><br />'.Templates::find()->where(["template_id" => 5])->one()->template_content;
}
$contract_declaration.= '<br /><b>3.4 Kwa Matumizi ya Ofisi ya Bodi ya Mikopo TU</b><br />'.Templates::find()->where(["template_id" => 6])->one()->template_content.'<br />
      ';

   $mpdf->AddPage();
   $mpdf->WriteHTML($contract_declaration);
  
  if($ordinary_level_education_details){
    $postgraduate_list_of_attachments = '
   <p align="right"><b>'.$form_number.'</b></p>
    <b>Orodha ya Viambatanisho (List of Attachments)</b><br />
    <div style="text-align: justify;"> <br />
     <p>Tafadhali ambatanisha nakala za vivuli vilivyothibitishwa (certified copies) za nyaraka zifuatazo ili kuthibitisha maelezo yako :-</p><br />
     <p>1.Uthibitisho wa uraia: <b> "Birth Certificate" Number : '. $model->applicant->birth_certificate_number.'</p><br />
     <p>2.Cheti cha kuhitimu masomo ya shahada ya Kwanza kwa mwombaji wa ufadhili wa Shahada ya Uzamili ama Cheti cha Shahada ya kwanza na ya Uzamili kwa Mwombaji wa Shahada ya Uzamivu.</p><br />
     <p>3.Barua ya utambulisho kutoka kwa mwajiri (Introduction letter from the employer).</p><br />
     <p>4.Barua ya udhamini kutoka kwa mwajiri (Guarantee letter from the employer).</p><br />'.
        Templates::find()->where(["template_id" => 7])->one()->template_content
     .' <br /></div>
   ';
}
else{
    $postgraduate_list_of_attachments = '
   <p align="right"><b>'.$form_number.'</b></p>
    <b>Orodha ya Viambatanisho (List of Attachments)</b><br />
    <div style="text-align: justify;"> <br />
     <p>Tafadhali ambatanisha nakala za vivuli vilivyothibitishwa (certified copies) za nyaraka zifuatazo ili kuthibitisha maelezo yako :-</p><br />
     <p>1.Uthibitisho wa uraia: <b> "Birth Certificate" Number : '. $model->applicant->birth_certificate_number.'</p><br />
     <p>2.Cheti cha matokeo ya mtihani ya kidato cha 4(Form 4 certificate).</p><br />
     <p>3.Cheti cha matokeo ya mtihani ya kidato cha 6 (Form 6 certificate).</p><br />
     <p>4.Cheti cha kuhitimu masomo ya shahada ya Kwanza kwa mwombaji wa ufadhili wa Shahada ya Uzamili ama Cheti cha Shahada ya kwanza na ya Uzamili kwa Mwombaji wa Shahada ya Uzamivu.</p><br />
     <p>5.Barua ya utambulisho kutoka kwa mwajiri (Introduction letter from the employer).</p><br />
     <p>6.Barua ya udhamini kutoka kwa mwajiri (Guarantee letter from the employer).</p><br />'.
        Templates::find()->where(["template_id" => 7])->one()->template_content
     .' <br /></div>
   ';
}

$mpdf->AddPage();
$mpdf->WriteHTML($postgraduate_list_of_attachments);

$mpdf->Output('Loan Application Form.pdf', 'I');
exit;

?>

