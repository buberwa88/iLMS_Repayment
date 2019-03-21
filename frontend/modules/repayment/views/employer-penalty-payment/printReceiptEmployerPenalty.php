<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use frontend\modules\repayment\models\LoanRepayment;

$mpdf = new mPDF();

$values= frontend\modules\repayment\models\EmployerPenaltyPayment::getReceiptDetailsEmployerPenalty($id);
    if($values->employer_id !=''){
        $payer=$values->employer->employer_name;
    }
$resultInWord=frontend\modules\repayment\models\NumbersToWords::convert(round($values->amount,2));
//$sum = 100500;
//$total= Yii::$app->formatter->asSpellout($sum);
$contract_header = '
     <table width="100%">
          <tr>
           <td width="85%" style="margin: 1%;text-align: center;">
            <span style="font-weight: bold; font-size: 14pt;">Higher Education Students'."'".'  Loans Board</span><br /><br />             
             <span style="font-weight: bold; font-size: 9.4pt;">P.O.Box 76068, Dar es Salaam</span><br /><br />
             <i>TIN: 104-496-318</i><br />
            <b> RECEIPT<br />
           </td>
         </tr>        
       </table>
      <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header" style="border: 1">
                <div class="box-title" style="margin-left: 2;text-align: center;">'.'</div>
              </div><br />
      <b> 
<table width="100%"><tr><td width="5%" style="text-align: left;">No: '.$values->receipt_number.'</td><td width="10%" style="text-align: right;">Date: '.date("d-F-Y",strtotime($values->date_receipt_received)).'</td></tr>
<tr><td colspan="2" style="text-align: left;"><i>RECEIVED FROM:</i> '.'<strong>'.$payer.'</strong>'.'</td></tr>    
<tr><td colspan="2" style="text-align: left;"><br/><br/><b><i>The Sum of </i></b> TZS '.$resultInWord." only".'</td></tr>
<tr><td colspan="2" style="text-align: left;"><br/><br/><b><i>Being payment in respect of </i></b> Employer Penalty</td></tr> 
<tr><td colspan="2" style="text-align: left;">DEPOSITED ON '.date("d/m/Y",strtotime($values->date_receipt_received)).'</td></tr>
    <tr><td width="5%" style="text-align: left;">Cash/Cheque No.: '." ".'</td><td rowspan="4" width="10%" style="text-align: right;">WITH THANKS<br/><br/><br/><b>_____________________________</b><br/><br/>HESLB</td></tr>
        <tr><td width="5%" style="text-align: left;">TZS: '.number_format($values->amount,2).'</td></tr>
            <tr><td width="5%" style="text-align: left;">RECOVERY NMB'.'</td></tr>
                <tr><td width="5%" style="text-align: left;">Code(s): '." ".$values->receipt_number.'</td></tr>
                    <tr><td width="5%" style="text-align: left;">'.$values->receipt_number.'</td></tr>
</table>          
</b><br /><br />
     ';
      $mpdf->AddPage();
      $mpdf->WriteHTML($contract_header);

$mpdf->Output('Receipt.pdf', 'I');
exit;

?>