<?php 
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;
use backend\modules\disbursement\models\Disbursement;
/*
$stle_header='style="border: 1px solid #000000; border-collapse: collapse;\"';
$style1='style="width:20%;text-align: right;font-size: 13pt;font-weight:bold;"';
$style2='style="width:10%;text-align:right;font-size:13pt;font-weight:bold;"';
$style3='style="width:50%;text-align:left;font-size: 7pt;"';
$style4='style="width:20%;text-align: right;font-size: 7pt;"';
$style5HeaderS='style="width:5%;text-align: right;font-weight:bold;"';
$style5HeaderEmpC='style="width:15%;text-align: right;font-weight:bold;"';
$style5HeaderPayD='style="width:10%;text-align: right;font-weight:bold;"';
$style5HeaderAmount='style="width:30%;text-align: right;font-weight:bold;"';

$style5DataS='style="width:5%;text-align: right;font-size: 13pt;"';
$style5DataEmpC='style="width:15%;text-align: right;font-size: 13pt;"';
$style5DataPayD='style="width:10%;text-align: right;font-size: 13pt;"';
$style5DataAmount='style="width:30%;text-align: right;font-size: 13pt;"';
*/
$stle_header='style="border: 1px solid #000000; border-collapse: collapse;\"';
$style1='style="width:20%;text-align: right;font-weight:bold;"';
$style2='style="width:10%;text-align:right;font-weight:bold;"';
$style3='style="width:50%;text-align:left;font-size: 13pt;"';
$style4='style="width:20%;text-align: right;font-size: 13pt;"';
$style5HeaderS='style="width:5%;text-align: right;font-weight:bold;"';
$style5HeaderEmpC='style="width:15%;text-align: right;font-weight:bold;"';
$style5HeaderPayD='style="width:10%;text-align: right;font-weight:bold;"';
$style5HeaderAmount='style="width:30%;text-align: right;font-weight:bold;"';

$style5DataS='style="width:5%;text-align: right;font-size: 13pt;"';
$style5DataEmpC='style="width:15%;text-align: right;font-size: 13pt;"';
$style5DataPayD='style="width:10%;text-align: right;font-size: 13pt;"';
$style5DataAmount='style="width:30%;text-align: right;font-size: 13pt;"';
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;

$subtitalAcc=0;
$subtitalAccq=0;
$date=date("Y-m-d");
?>
 <?php 
$loanee = frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
$getProgramme = frontend\modules\application\models\application::findBySql("SELECT applicant.sex,applicant.f4indexno,programme.programme_name,learning_institution.institution_code FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id WHERE application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();

$programmeResultd=\common\models\LoanBeneficiary::getAllProgrammeStudiedGeneral($applicant_id);
 ?>
 <table witdth='100%'><tr>
         <td <?php echo $style2; ?>>FULL NAME:&nbsp;&nbsp;&nbsp;</td>
         <td <?php echo $style3; ?>><?php echo $loanee->user->firstname.", ".$loanee->user->middlename." ".$loanee->user->surname; ?></td>
         <td <?php echo $style1; ?>></td><td <?php echo $style4; ?>></td>
         </tr><tr>
         <td <?php echo $style2; ?>>INDEXNO:&nbsp;&nbsp;&nbsp;</td>
         <td <?php echo $style3; ?>><?php echo $getProgramme->f4indexno; ?></td>
         <td <?php echo $style1; ?>>TOTAL LOAN : </td>
         <td <?php echo $style4; ?>><?php 
         $totalLoan=\backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($applicant_id,$date,$loan_given_to);
         echo number_format($totalLoan); ?></td></tr>
         <tr>
             <td <?php echo $style2; ?>>GENDER:&nbsp;&nbsp;&nbsp;</td>
             <td <?php echo $style3; ?>><?php echo $getProgramme->sex; ?></td>
             <td <?php echo $style1; ?>>REPAYMENT :</td>
             <td <?php echo $style4; ?>><?php 
             $repayment=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id,$date,$loan_given_to);
             echo number_format($repayment); ?></td></tr>
         <tr>
             <td <?php echo $style2; ?>>INSTITUTION(S):&nbsp;&nbsp;&nbsp;</td>
             <td <?php echo $style3; ?>><?php echo $getProgramme->institution_code; ?></td>
             <td <?php 
             $balance=\frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($applicant_id,$date,$loan_given_to);
             echo $style1; ?>>LOAN BALANCE :</td>
             <td <?php echo $style4; ?>><?php echo number_format($balance); ?></td>
         </tr></table>
<?php

$getPaymentsOfLoanee = \backend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount,loan_repayment.payment_date,employer.employer_code,employer.short_name,loan_repayment_detail.applicant_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id LEFT JOIN employer ON employer.employer_id=loan_repayment.employer_id LEFT JOIN applicant ON applicant.applicant_id=loan_repayment.applicant_id WHERE loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id AND loan_repayment_detail.applicant_id=:applicant_id AND  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_given_to='$loan_given_to' GROUP BY loan_repayment.bill_number ORDER BY loan_repayment.payment_date ASC",[':applicant_id'=>$applicant_id])->all();
$sno=1;
?>
<br/><br/>
     <table witdth='100%'>
         <tr><th <?php echo $style5HeaderS; ?>>SNO</th><th <?php echo $style5HeaderEmpC; ?>>EMP.CODE</th><th <?php echo $style5HeaderEmpC; ?>>SHORT CODE</th><th <?php echo $style5HeaderPayD; ?>>PAY PERIOD</th><th <?php echo $style5HeaderAmount; ?>>AMOUNT</th><th <?php echo $style5HeaderAmount; ?>>LOAN BALANCE</th></tr>
<?php 
$amountDeduct=0;
foreach ($getPaymentsOfLoanee AS $values){
    $amountDeduct +=$values->amount;
    $totalLoan=\backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($values->applicant_id,$date,$loan_given_to);
?>
<tr><td <?php echo $style5DataS; ?>><?php echo $sno; ?></td>
    <td <?php echo $style5DataEmpC; ?>><?php echo $values->employer_code; ?></td>
    <td <?php echo $style5DataEmpC; ?>><?php echo $values->short_name; ?></td>
    <td <?php echo $style5DataPayD; ?>><?php echo date("d-m-Y",strtotime($values->payment_date)); ?></td>
    <td <?php echo $style5DataAmount; ?>><?php echo number_format($values->amount); ?></td>
    <td <?php echo $style5DataAmount; ?>><?php echo number_format($totalLoan-$amountDeduct); ?></td>
</tr>
<?php
++$sno;
}

?>
</table>    

 