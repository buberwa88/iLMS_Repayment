<?php 
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;
use backend\modules\disbursement\models\Disbursement;
$stle_header='style="border: 1px solid #000000; border-collapse: collapse;\"';
$stle_headerNumb='style="border: 1px solid #000000; border-collapse: collapse;text-align: right;\"';
$stleTitle='style="font-weight:bold;width:100%;\"';

$subtitalAcc=0;
$subtitalAccq=0;
$date=date("Y-m-d");
?>
<table <?php echo" style=\"width:100%;font-family:Calibri;background-color:white;\"";?>>
 <th <?php echo "style=\"width:70%;background-color:white;text-align:center;\"" ?>>
 <hr>
 CUSTOMER STATEMEMNT
 <hr>
 </th>
 <tr>
 <td colspan="5">
 <?php 
$loanee = frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
$getProgramme = frontend\modules\application\models\application::findBySql("SELECT applicant.f4indexno,programme.programme_name,learning_institution.institution_code FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id WHERE application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();
/*
                ->joinWith(['disbursements','disbursements'])->groupBy(['disbursement.application_id'])
                ->joinWith(['disbursements','disbursements.programme'])
                ->joinWith(['disbursements','disbursements.programme','disbursements.programme.learningInstitution'])
	        ->where(['applicant_id'=>$applicant_id])->one();
 * 
 */
 ?>
 <table><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>LOANEE NAME:&nbsp;&nbsp;&nbsp;</td><td><?php echo $loanee->user->firstname.", ".$loanee->user->middlename." ".$loanee->user->surname; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INSTITUTION/COLLEGE:&nbsp;&nbsp;&nbsp;</td><td><?php 
 /*
 foreach ($loanee->applications as $appEduDetails2) {
                        $programme_name =$appEduDetails2->programme->programme_name; 
						foreach ($appEduDetails2->educations as $appLearningIns) {
						$institutionDetails =$appLearningIns->learningInstitution->institution_name;
                        $olevel_index =$appLearningIns->olevel_index;						
                        }						
                    }
  * 
  */
 echo $getProgramme->institution_code; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>COURSE:&nbsp;&nbsp;&nbsp;</td><td><?php echo $getProgramme->programme_name; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INDEX NUMBER:&nbsp;&nbsp;&nbsp;</td><td><?php echo $getProgramme->f4indexno; ?></td></tr></table>

<table style="font-size: 8pt; color: #123; font-family: Times;">
 &nbsp;&nbsp;&nbsp;
 <tr <?php echo" style=\"font-weight:bold;\"";?>>
 <td><strong>Item/AC. Year</strong></td>
 <?php
	$resultAcademic = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);	
	foreach ($resultAcademic as $disbursedbatchResults) {
	?>
 <td <?php echo" style=\"\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php 
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
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
$LAF=backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicant_id,$date);
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
$penalty=backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicant_id,$date);
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
$vrf=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id,$date);
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
$amountPaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id,$date);
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
</table>     
</table>
 