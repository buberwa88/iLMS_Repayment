<?php
use mPDF;
use yii\helpers\Html;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundClaimant;
use frontend\modules\repayment\models\RefundClaimantEducationHistory;
use frontend\modules\repayment\models\RefundClaimantEmployment;
use frontend\modules\repayment\models\RefundContactPerson;
use backend\modules\repayment\models\RefundClaimantAttachment;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;

$refund_application_id=$refundapplicationid;

$modelRefundApplication = RefundApplication::find()->where("refund_application_id={$refund_application_id}")->one();
$modelRefundClaimant = RefundClaimant::find()->where("refund_claimant_id={$modelRefundApplication->refund_claimant_id}")->one();

$modelRefundClaimantEducHistory = RefundClaimantEducationHistory::find()->where("refund_application_id={$modelRefundApplication->refund_application_id}")->all();
$modelRefundClaimantEmploymentDet = RefundClaimantEmployment::find()->where("refund_application_id={$modelRefundApplication->refund_application_id}")->all();
$modelRefContactPers = RefundContactPerson::find()->where("refund_application_id={$refund_application_id}")->all();
$modelAttachment = RefundClaimantAttachment::find()->where("refund_application_id={$refund_application_id}")->all();
if ($modelRefundApplication->refund_type_id == RefundApplication::REFUND_TYPE_NON_BENEFICIARY) {
    $title = "NON-BENEFICIARY - REFUND APPLICATION #" . $modelRefundApplication->application_number;
} else if ($modelRefundApplication->refund_type_id == RefundApplication::REFUND_TYPE_OVER_DEDUCTED) {
    $title = "OVER-DEDUCTED - REFUND APPLICATION #" . $modelRefundApplication->application_number;
} else if ($modelRefundApplication->refund_type_id == RefundApplication::REFUND_TYPE_DECEASED) {
    $title = "DECEASED - REFUND APPLICATION #" . $modelRefundApplication->application_number;
}
$refund_type = $modelRefundApplication->refund_type_id;
$educationAttained = $modelRefundApplication->educationAttained;
$f4type = $modelRefundClaimant->f4type;
$stepsCount = \frontend\modules\repayment\models\RefundSteps::getCountThestepsAttained($refund_application_id, $refund_type);
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$reportLabel="refund_application_form_" . date("Y_m_d_h_m_s");
$printed_on = "Printed on " . date('l F d Y H:i A', time());
$printedBy='';


$amount_total=0;
$header_id=1;
$learning_institution_ids_s=0;

$amount_bottom_array=array();
$mpdf=new mPDF('c','A4-L','','',5,5,30,25,10,10);
/*********************************************
 *
 * here removed by telesphory 29/03/2019
 */

$html.= '<div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 12px; font-size:20px;">1. Claimant Particulars</div>
              </div>';
$html.='<table style="width: 100%;font-size:18px;">
                                        <tr>
                                            <td ><b>Full Name: </b></td>
                                            <td >'.strtoupper($modelRefundClaimant->firstname ." ". $modelRefundClaimant->middlename . " " . $modelRefundClaimant->surname);

                                            $html.='</td></tr>';
    $html.='</table><br/>';

$html.= '<div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 12px; font-size:20px;">2. Contacts Details</div>
              </div>';

$html.='<table style="width: 100%;font-size:18px;">';
                                        foreach ($modelRefContactPers AS $contactPersDetails) {

                                            $html.='<tr>
                                                <td><b>First Name: </b></td>
                                                <td>'.$contactPersDetails->firstname.'</td>
                                                <td><b>Middle Name: </b></td>
                                                <td>'.$contactPersDetails->middlename.'</td>
                                                <td><b>Last Name: </b></td>
                                                <td>'.$contactPersDetails->surname.'</td>
                                                <td><b>Phone Number: </b></td>
                                                <td>'.$contactPersDetails->phone_number.'</td>
                                                <td><b>Email: </b></td>
                                                <td>'.$contactPersDetails->email_address.'</td>                            
                                            </tr>';
                                       }
                                    $html.='</table><br/>';

$html.= '<div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 12px; font-size:20px;">3. Employment Details</div>
              </div>';
$html.='<table style="width: 100%;font-size:18px;">';
                                        foreach ($modelRefundClaimantEmploymentDet AS $employmentDetails) {

$html.='<tr>
                                                <td><b>Employer Name: </b></td>
                                                <td>'.\frontend\modules\repayment\models\Employer::getEmployerCategory($employmentDetails->employer_name)->employer_name.'</td>
                                                <td><b>Employee ID/Check #: </b></td>
                                                <td>'.$employmentDetails->employee_id.'</td>
                                            </tr>';

                                         }
$html.= '</table><br/>';

$html.= '<div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 12px; font-size:20px;">4. Repayment Details</div>
              </div>';

$html.= '<table style="width: 100%;font-size:18px;">
                                        <tr>
                                            <td><b>Liquidation Letter Number: </b></td>
                                            <td>'.$modelRefundApplication->liquidation_letter_number.'</td>                           
                                        </tr>
                                    </table><br/>';
$html.= '<div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 12px; font-size:20px;">5. Bank Details</div>
              </div>';

$html.= '<table style="width: 100%;font-size:18px;">

                                        <tr>
                                            <td><b>Bank Name: </b></td>
                                            <td>'.$modelRefundApplication->bank_name.'</td>
                                            <td><b>Account Number: </b></td>
                                            <td>'.$modelRefundApplication->bank_account_number.'</td>
                                            <td><b>Account Name: </b></td>
                                            <td>'.$modelRefundApplication->bank_account_name.'</td>
                                            <td><b>Branch: </b></td>
                                            <td>'.$modelRefundApplication->branch.'</td>
                                        </tr>
                                    </table><br/>';
$html.= '<div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 12px; font-size:20px;">6. Social Fund Details</div>
              </div>';

$html.= '<table style="width: 100%;font-size:18px;">
                                        <tr>
                                            <td><b>Employment Status: </b></td>
                                            <td>';
                                                    if ($modelRefundApplication->social_fund_status == 1) {
                                                        $html.='Retired';
                                                    } else {
                                                        $html.='Not Retired';
                                                    }
$html.= '</td>';

$html.= '</tr>';
$html.= '</table><br/><br/><br/>';
$html.= '<div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 12px; font-size:20px;">7. List of Attachments Attached</div>
              </div>';

$html.='<table style="width: 100%;font-size:18px;">
<tr>
                                                <td><b>S/No: </b></td>
                                                <td><b>Attachment: </b></td>                       
                                            </tr>';
$attachCount=0;
foreach ($modelAttachment AS $modelAttachmentDetails) {
    $attachCount++;
    $html.='<tr>
                                                <td>'.$attachCount.'</td>
                                                <td>'.$modelAttachmentDetails->attachmentDefinition->attachment_desc.'</td>           
                                            </tr>';
}
$html.='</table><br/><br/>';


$html.= '<div class="row" style="text-align: right;">
        <div class="col-xs-12">
            <div class="box box-primary" style="font-size:20px;">
            <b>Claimant Signature:</b>
              <div class="box-header" style="margin-left: 12px;">
                <div class="box-title">_________________________________________________________________________</div>
              </div>';


$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("heslb");
$mpdf->SetAuthor("heslb");
//$mpdf->SetWatermarkText("heslb");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->SetDefaultFontSize(8.0);
$mpdf->useDefaultCSS2 = true;
$mpdf->SetTitle('Report');
$mpdf->SetDisplayMode('fullpage');
$mpdf->setAutoTopMargin = 'stretch';
$logoHESLB=Yii::$app->params['HESLBlogo_refund'].'logohelsb_new.jpg';
$mpdf->SetHTMLHeader("<div class='header' style='text-align: center;'><table width='100%'>
          <tr>
           <td width='100%' style='margin: 1%;text-align: center;'>
            <span style='font-weight: bold; font-size: 14pt;'>HIGHER EDUCATION STUDENT'S LOANS BOARD</span><br />
            <img class='img' src='".$logoHESLB."' alt='' style='height: 70px;width: 70px;'>
             <br />
             <span style='font-weight: bold; font-size: 14pt;'>
             Plot No. 8, Block No. 46; Sam Nujoma Rd; P.O Box 76068 Dar es Salaam, <strong>Tanzania</strong><br/>
             <strong>Tel: </strong>(General) +255 22 22772432/22772433;  <strong>Fax: </strong> +255 22 2700286; <strong>Email:</strong>repayment@heslb.go.tz;<br/>
             <strong>Website:</strong>www.heslb.go.tz
             </span>
           </td>          
         </tr>
         <tr>
         <td width='100%' style='margin: 1%;text-align: center;'>
         <span style='font-weight: bold; font-size: 14pt;'>
          ".$title."
          </span>
           </td>
           </tr>
             

       </table><br/></div>");



//$mpdf->SetFooter('|Page {PAGENO} of {nbpg}|');
$mpdf->SetFooter($printedBy.'  |Page {PAGENO} of {nbpg} |<div style="text-align:left;font-size: 12pt;">'.$printed_on.'</div>');

$mpdf->WriteHTML($html);

$mpdf->Output($reportLabel . '.pdf', "D");
exit;
?>
