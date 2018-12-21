<?php 
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;
use backend\modules\disbursement\models\Disbursement;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$loan_given_toThroughEmployer=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
$stle_header='style="border: 1px solid #000000; border-collapse: collapse;\"';
$stle_headerNumb='style="border: 1px solid #000000; border-collapse: collapse;text-align: right;\"';
$stleTitle='style="font-weight:bold;width:100%;\"';

$subtitalAcc=0;
$subtitalAccq=0;
$postgraduate=0;
$date=date("Y-m-d");
$resultsCountNotThroughEmployer=\common\models\LoanBeneficiary::checkForBeneficiaryLoanNotThroughEmployer($applicant_id);
$resultsCountThroughEmployer=\common\models\LoanBeneficiary::checkForBeneficiaryLoanThroughEmployer($applicant_id);
if($resultsCountNotThroughEmployer ==1 && $resultsCountThroughEmployer==1){
$bothExists=1;	
}else{
$bothExists=0;	
}
?>
<table <?php echo" style=\"width:100%;background-color:white;font-size: 8pt;font-family: Times;\"";?>>
 <th <?php echo "style=\"width:100%;background-color:white;text-align:center;\"" ?>>
 <hr>
 CUSTOMER STATEMEMNT
 <hr>
 </th>
 <tr>
 <td colspan="5">
 <?php 
$loanee = frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
$getProgramme = frontend\modules\application\models\Application::findBySql("SELECT applicant.f4indexno,programme.programme_name,learning_institution.institution_code FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id WHERE application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();

$programmeResultd=\common\models\LoanBeneficiary::getAllProgrammeStudiedGeneral($applicant_id);
?>
 <table <?php echo" style=\"background-color:white;\"";?>><thead><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>LOANEE NAME:&nbsp;&nbsp;&nbsp;</td><td><?php echo $loanee->user->firstname.", ".$loanee->user->middlename." ".$loanee->user->surname; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INSTITUTION/COLLEGE:&nbsp;&nbsp;&nbsp;</td><td><?php 
 echo $programmeResultd->institution_code; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>COURSE:&nbsp;&nbsp;&nbsp;</td><td><?php echo $programmeResultd->programme_name; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INDEX NUMBER:&nbsp;&nbsp;&nbsp;</td><td><?php echo $getProgramme->f4indexno; ?></td></tr></thead></table>
<br/><br/>
<?php if($resultsCountNotThroughEmployer==1){	?>
<?php if($bothExists==1){ ?>
<table > <thead><tr><td><strong>SECTION A:&nbsp;&nbsp;&nbsp;</strong>STUDENT LOAN</td></tr></thead></table>
<?php } ?>
<table width="100%" style="font-size: 8pt;">
 &nbsp;&nbsp;&nbsp;
 <tbody>
 <tr <?php echo" style=\"font-weight:bold;\"";?>>
 <td><strong>Item/AC. Year</strong></td>
 <?php
	$resultAcademic = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);	
	foreach ($resultAcademic as $disbursedbatchResults) {
	?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php 
  echo $disbursedbatchResults->disbursementBatch->academicYear->academic_year;
 ?></strong></td>
 <?php
$sn++;
 }
 $val=$sn + 1;
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total</strong></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Loan Items :</strong></td></tr>
 <?php

 $resultLoanItems = \common\models\LoanBeneficiary::getLoanItemsProvided($applicant_id);	
	foreach ($resultLoanItems as $resultLoanItemsResults) {
	?>
 <tr <?php echo" style=\"\"";?>><td ><?php 
 $loanItem=$resultLoanItemsResults->loan_item_id;
 echo $resultLoanItemsResults->loanItem->item_name; ?></td>
 <?php
$loanItemReturnsAcademicY1 = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id); 
$loopItem=0;
$total=0;
 foreach($loanItemReturnsAcademicY1 as $generalAcademicYearResults1){
 $loopItem++;
 $academic_yearID=$generalAcademicYearResults1->disbursementBatch->academic_year_id;
 
 
 $amount1 = \common\models\LoanBeneficiary::getAmountPerLoanItemsProvided($applicant_id,$loanItem,$academic_yearID);
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($amount1->disbursed_amount >0){
 echo number_format($amount1->disbursed_amount,2); 
 $total +=$amount1->disbursed_amount;
 }else{
 echo '';
 }
 ?></td>
 <?php
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($total,2); ?></td>
 </tr>
 <?php
 } 
 
 //here for subtotal 

 $resultAcademicTrendSubTotal = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Sub Total:</strong></td>
 <?php 
 foreach ($resultAcademicTrendSubTotal as $resultsAmountSubtotal2) { 
 $academic_yearIDQR=$resultsAmountSubtotal2->disbursementBatch->academic_year_id;
 $SubTotalAmount2 = \common\models\LoanBeneficiary::getAmountSubtotalPerAccademicY($applicant_id,$academic_yearIDQR);
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($SubTotalAmount2->disbursed_amount > 0){
 echo number_format($SubTotalAmount2->disbursed_amount,2); 
 }else{
 echo "";
 }
 $subtitalAccq +=$SubTotalAmount2->disbursed_amount;
 ?></td>
 <?php 
 } ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAccq,2); ?></td>
 </tr>

 <?php
 //end
 $resultReturnCheck=\common\models\LoanBeneficiary::checkForReturnForLoanee($applicant_id);
 if($resultReturnCheck==1){
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Returns :</strong></td></tr>

 <?php

 $loanItemReturns = \common\models\LoanBeneficiary::getLoanItemsReturned($applicant_id);	
	foreach ($loanItemReturns as $loanItemReturnsResults) {
	?>
 <tr <?php echo" style=\"\"";?>><td ><?php 
 $returnedItem=$loanItemReturnsResults->loan_item_id;
 echo $loanItemReturnsResults->loanItem->item_name; ?></td>
 <?php
  $loanItemReturnsAcademicY = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
$loopItemReturn=0;
$totalReturn=0;	
 foreach($loanItemReturnsAcademicY as $generalAcademicYearResults){
 $loopItemReturn++;

  $academic_yearIDQ=$generalAcademicYearResults->disbursementBatch->academic_year_id;
 
 $amount1Return = \common\models\LoanBeneficiary::getLoanItemsAmountReturned($applicant_id,$returnedItem,$academic_yearIDQ);
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($amount1Return->disbursed_amount >0){
 echo number_format($amount1Return->disbursed_amount,2);
}else{
echo '';
}
 $totalReturn +=$amount1Return->disbursed_amount;
 ?></td>
 <?php }?>
  <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalReturn,2); ?></td>
 </tr>
 <?php }
//here for subtotal return 

 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Returns Sub Total</strong></td>
 <?php 
$subtitalReturnAcc=0;
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotal) { 
 $academic_yearIDQR=$resultsAmountSubtotal->disbursementBatch->academic_year_id;
 $ReturnsAmountSubTotal = \common\models\LoanBeneficiary::getAmountSubtotalReturned($applicant_id,$academic_yearIDQR);
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($ReturnsAmountSubTotal->disbursed_amount > 0){
 echo number_format($ReturnsAmountSubTotal->disbursed_amount,2); 
 }else{
 echo "";
 }
 $subtitalReturnAcc +=$ReturnsAmountSubTotal->disbursed_amount;
 ?></td>
 <?php 
 } ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalReturnAcc,2); ?></td>
 </tr>
 
 <?php
 //}
 //end
 
 //here after subtotal return 
 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Sub Total (After Returns)</strong></td>
 <?php 
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 $academic_yearIDQR=$resultsAmountSubtotalAcc->disbursementBatch->academic_year_id;

 $amountSubTtal = \common\models\LoanBeneficiary::getSubTotalAfterReturn($applicant_id,$academic_yearIDQR);
 //echo $amountSubTtal;
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($amountSubTtal > 0){
 echo number_format($amountSubTtal,2); 
 }else{
 echo "";
 }
 $subtitalAcc +=$amountSubTtal;
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAcc,2); ?></td>
 </tr>
 <?php
 }else{
 $subtitalAcc=$subtitalAccq;
 }
//here for additional charges 
 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Additional Charges :</strong></td></tr>
 <tr <?php echo" style=\"\"";?>><td>Administration Fee</td>
 <?php 
$LAF=backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicant_id,$date,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($LAF,2); ?></td>
 </tr>
 <tr <?php echo" style=\"\"";?>><td>Penalty</td>
 <?php 
$penalty=backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicant_id,$date,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($penalty,2); ?></td>
 </tr>
 <tr <?php echo" style=\"\"";?>><td>Value Retention Fee</td>
 <?php 
$vrf=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id,$date,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($vrf,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Additional Charges Sub Total</strong></td>
 <?php 
$additionalChargeSubTotal=$LAF+$penalty+$vrf;
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($additionalChargeSubTotal,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Total Loan</td>
 <?php 
//$totalLoan=$additionalChargeSubTotal+$subtitalAcc;
$totalLoan=$additionalChargeSubTotal+$subtitalAcc;
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalLoan,2); ?></td>
 </tr>
  <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Repayment :</strong></td></tr>
 <tr <?php echo" style=\"\"";?>><td>Amount Repaid</td>
 <?php 
$amountPaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id,$date,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($amountPaid,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Outstanding Loan :</strong></td>
 <?php 
$outstandingLoan=$totalLoan-$amountPaid;
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo "style=\"text-align:right;\"" ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($outstandingLoan,2); ?></td>
 </tr>
 </tbody>
</table>
<?php } ?>
<?php 


if($resultsCountThroughEmployer==1){ 
  $subtitalAccqThroughEmployer=0;
  $LAFthroughEmployer=0;
  $penaltyThroughEmployer=0;
  $vrfThroughEmployer=0;
  ?>
  <br/><br/>
  <?php if($bothExists==1){ ?>
<table> <tr><td><strong>SECTION B:&nbsp;&nbsp;&nbsp;</strong>EMPLOYER LOAN</td></tr></table>
  <?php } ?>  
<table width="100%" style="font-size: 8pt;">
 &nbsp;&nbsp;&nbsp;
 <tbody>
 <tr <?php 
 echo" style=\"font-weight:bold;\"";?>>
 <td><strong>Item/AC. Year</strong></td>
 <?php
	$resultAcademicThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
	foreach ($resultAcademicThroughEmployer as $disbursedbatchResults) {
	?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php 
  echo $disbursedbatchResults->disbursementBatch->academicYear->academic_year;
 ?></strong></td>
 <?php
$sn++;
 }
 $val=$sn + 1;
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total</strong></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Loan Items :</strong></td></tr>
 <?php
 $item1ThroughEmployer=1;
 $resultLoanItemsThroughEmployer = \common\models\LoanBeneficiary::getLoanItemsProvidedThroughEmployer($applicant_id);	
	foreach ($resultLoanItemsThroughEmployer as $resultLoanItemsResults) {
	?>
 <tr <?php

 if ($item1ThroughEmployer % 2 == 0) {
  $colorReq=$colorChange2;
}else{
  $colorReq=$colorChange1;
}

 echo" style=\"\"";?>><td ><?php 
 $loanItemThroughEmployer=$resultLoanItemsResults->loan_item_id;
 echo $resultLoanItemsResults->loanItem->item_name; ?></td>
 <?php
$loanItemReturnsAcademicY1ThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id); 
$loopItem=0;
$totalTrhoughEmployer=0;
 foreach($loanItemReturnsAcademicY1ThroughEmployer as $generalAcademicYearResults1){
 $loopItem++;
 $academic_yearIDThroughEmployer=$generalAcademicYearResults1->disbursementBatch->academic_year_id;
 
 
 $amount1ThroughEmployer = \common\models\LoanBeneficiary::getAmountPerLoanItemsProvidedThroughEmployer($applicant_id,$loanItemThroughEmployer,$academic_yearIDThroughEmployer);
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($amount1ThroughEmployer->disbursed_amount >0){
 echo number_format($amount1ThroughEmployer->disbursed_amount,2); 
$totalTrhoughEmployer +=$amount1ThroughEmployer->disbursed_amount;
 }else{
 echo '';
 }
 ?></td>
 <?php
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalTrhoughEmployer,2); ?></td>
 </tr>
 <?php
 ++$item1ThroughEmployer;
 } 
 
 //here for subtotal 

 $resultAcademicTrendSubTotalThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
 ?>
 <tr <?php  echo" style=\"font-weight:bold;\"";?>><td><strong>Sub Total:</strong></td>
 <?php 
 foreach ($resultAcademicTrendSubTotalThroughEmployer as $resultsAmountSubtotal2) { 
 $academic_yearIDQR=$resultsAmountSubtotal2->disbursementBatch->academic_year_id;
 $SubTotalAmount2ThroughEmployer = \common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYThroughEmployer($applicant_id,$academic_yearIDQR);
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($SubTotalAmount2ThroughEmployer->disbursed_amount > 0){
 echo number_format($SubTotalAmount2ThroughEmployer->disbursed_amount,2); 
 }else{
 echo "";
 }
 $subtitalAccqThroughEmployer +=$SubTotalAmount2ThroughEmployer->disbursed_amount;
 ?></td>
 <?php 
 } ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAccqThroughEmployer,2); ?></td>
 </tr>
 
 <?php
 //end
 $resultReturnCheckThroughEmployer=\common\models\LoanBeneficiary::checkForReturnForLoaneeThroughEmployer($applicant_id);
 if($resultReturnCheckThroughEmployer==1){
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Returns :</strong></td></tr>

 <?php

 $loanItemReturnsThroughEmployer = \common\models\LoanBeneficiary::getLoanItemsReturnedThroughEmployer($applicant_id);
$item2ThroughEmployer=1; 
	foreach ($loanItemReturnsThroughEmployer as $loanItemReturnsResults) {
	?>
 <tr <?php 
 
 if ($item2ThroughEmployer % 2 == 0) {
  $colorReq1=$colorChange2;
}else{
  $colorReq1=$colorChange1;
}
 
 echo" style=\"\"";?>><td ><?php 
 $returnedItem=$loanItemReturnsResults->loan_item_id;
 echo $loanItemReturnsResults->loanItem->item_name; ?></td>
 <?php
  $loanItemReturnsAcademicYThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
$loopItemReturn=0;
$totalReturn=0;	
 foreach($loanItemReturnsAcademicYThroughEmployer as $generalAcademicYearResults){
 $loopItemReturn++;

  $academic_yearIDQ=$generalAcademicYearResults->disbursementBatch->academic_year_id;
 
 $amount1Return = \common\models\LoanBeneficiary::getLoanItemsAmountReturnedThroughEmployer($applicant_id,$returnedItem,$academic_yearIDQ);

 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($amount1Return->disbursed_amount >0){
 echo number_format($amount1Return->disbursed_amount,2);
}else{
echo '';
}
 $totalReturn +=$amount1Return->disbursed_amount;
 ?></td>
 <?php }?>
  <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalReturn,2); ?></td>
 </tr>
 <?php 
 ++$item2ThroughEmployer;
 }
//here for subtotal return 

 $resultAcademicTrendReturnThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Returns Sub Total</strong></td>
 <?php 
$subtitalReturnAcc=0;
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotal) { 
 $academic_yearIDQR=$resultsAmountSubtotal->disbursementBatch->academic_year_id;
 $ReturnsAmountSubTotal = \common\models\LoanBeneficiary::getAmountSubtotalReturnedThroughEmployer($applicant_id,$academic_yearIDQR);
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($ReturnsAmountSubTotal->disbursed_amount > 0){
 echo number_format($ReturnsAmountSubTotal->disbursed_amount,2); 
 }else{
 echo "";
 }
 $subtitalReturnAcc +=$ReturnsAmountSubTotal->disbursed_amount;
 ?></td>
 <?php 
 } ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalReturnAcc,2); ?></td>
 </tr>
 
 <?php
 //}
 //end
 
 //here after subtotal return 
 $resultAcademicTrendReturnThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td><strong>Sub Total (After Returns)</strong></td>
 <?php 
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotalAcc) { 
 $academic_yearIDQR=$resultsAmountSubtotalAcc->disbursementBatch->academic_year_id;

 $amountSubTtalThroughEmployer = \common\models\LoanBeneficiary::getSubTotalAfterReturnThroughEmployer($applicant_id,$academic_yearIDQR);
 //echo $amountSubTtal;
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($amountSubTtalThroughEmployer > 0){
 echo number_format($amountSubTtalThroughEmployer,2); 
 }else{
 echo "";
 }
 $subtitalAccThroughEmployer +=$amountSubTtalThroughEmployer;
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAccThroughEmployer,2); ?></td>
 </tr>
 <?php
 }else{
 $subtitalAccThroughEmployer=$subtitalAccqThroughEmployer;
 }
 //here for additional charges 
 $resultAcademicTrendReturnThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Additional Charges :</strong></td></tr>
 <tr <?php echo" style=\"\"";?>><td>Value Retention Fee</td>
 <?php 
$vrfThroughEmployer=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginalGivenToApplicantTrhEmployer($applicant_id,$date,$loan_given_toThroughEmployer);
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($vrfThroughEmployer,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td><strong>Additional Charges Sub Total</strong></td>
 <?php 
$additionalChargeSubTotalThroughEmployer=$LAFthroughEmployer+$penaltyThroughEmployer+$vrfThroughEmployer;
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($additionalChargeSubTotalThroughEmployer,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Total Loan</td>
 <?php 
$totalLoanThroughEmployer=$additionalChargeSubTotalThroughEmployer+$subtitalAccThroughEmployer;
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalLoanThroughEmployer,2); ?></td>
 </tr>
  <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>"><strong>Repayment :</strong></td></tr>
 <tr <?php echo" style=\"\"";?>><td>Amount Repaid</td>
 <?php 
$amountPaidThroughEmployer=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id,$date,$loan_given_toThroughEmployer);
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($amountPaidThroughEmployer,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Outstanding Loan :</strong></td>
 <?php 
$outstandingLoanThroughEmployer=$totalLoanThroughEmployer-$amountPaidThroughEmployer;
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($outstandingLoanThroughEmployer,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td><strong>Overall Outstanding Loan :</strong></td>
 <?php 
$overallOutstandingLoan=$outstandingLoanThroughEmployer + $outstandingLoan;
 foreach ($resultAcademicTrendReturnThroughEmployer as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($overallOutstandingLoan,2); ?></td>
 </tr>
 </tbody>
 </table>
 <?php } ?>     
</table>
 