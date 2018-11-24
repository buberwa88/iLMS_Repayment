<?php 
use backend\modules\disbursement\models\Disbursement;
$subtitalAcc=0;
$subtitalAccq=0;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
</head>
<body>
<table <?php echo" style=\"width:100%;font-family:Calibri;background-color:white;\"";?>>
 <th <?php echo "style=\"width:70%;background-color:white;text-align:center;\"" ?>>
 <hr>
 CUSTOMER STATEMEMNT
 <hr>
 </th>
 <tr>
 <td colspan="5">
 <?php 
 //get loanee details
$loanee = frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
 ?>
 <table><tr><td <?php echo" style=\"text-align:right;font-weight:bold;\"";?>>LOANEE NAME:&nbsp;&nbsp;&nbsp;</td><td><?php echo $loanee->user->firstname.", ".$loanee->user->middlename." ".$loanee->user->surname; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;\"";?>>INSTITUTION/COLLEGE:&nbsp;&nbsp;&nbsp;</td><td><?php 
 foreach ($loanee->applications as $appEduDetails2) {
                        $programme_name =$appEduDetails2->programme->programme_name; 
						foreach ($appEduDetails2->educations as $appLearningIns) {
						$institutionDetails =$appLearningIns->learningInstitution->institution_name;
                        $olevel_index =$appLearningIns->olevel_index;						
                        }						
                    }
 echo $institutionDetails; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;\"";?>>COURSE:&nbsp;&nbsp;&nbsp;</td><td><?php echo $programme_name; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;\"";?>>INDEX NUMBER:&nbsp;&nbsp;&nbsp;</td><td><?php echo $olevel_index; ?></td></tr></table>
 <table>
 &nbsp;&nbsp;&nbsp;
 <tr <?php echo" style=\"font-weight:bold;\"";?>>
 <td>Item/AC. Year</td>
 <?php
	$resultAcademic = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);	
	foreach ($resultAcademic as $disbursedbatchResults) {
	?>
 <td <?php echo" style=\"\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
  echo $disbursedbatchResults->disbursementBatch->academicYear->academic_year;
 ?></td>
 <?php
$sn++;
 }
 $val=$sn + 1;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Loan Items :</td></tr>
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($total,2); ?></td>
 </tr>
 <?php
 } 
 
 //here for subtotal 

 $resultAcademicTrendSubTotal = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Sub Total:</td>
 <?php 
 foreach ($resultAcademicTrendSubTotal as $resultsAmountSubtotal2) { 
 $academic_yearIDQR=$resultsAmountSubtotal2->disbursementBatch->academic_year_id;
 $SubTotalAmount2 = \common\models\LoanBeneficiary::getAmountSubtotalPerAccademicY($applicant_id,$academic_yearIDQR);
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($SubTotalAmount2->disbursed_amount > 0){
 echo number_format($SubTotalAmount2->disbursed_amount,2); 
 }else{
 echo "";
 }
 $subtitalAccq +=$SubTotalAmount2->disbursed_amount;
 ?></td>
 <?php 
 } ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAccq,2); ?></td>
 </tr>
 
 <?php
 //end
 $resultReturnCheck=\common\models\LoanBeneficiary::checkForReturnForLoanee($applicant_id);
 if($resultReturnCheck==1){
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Returns :</td></tr>

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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($amount1Return->disbursed_amount >0){
 echo number_format($amount1Return->disbursed_amount,2);
}else{
echo '';
}
 $totalReturn +=$amount1Return->disbursed_amount;
 ?></td>
 <?php }?>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalReturn,2); ?></td>
 </tr>
 <?php }
//here for subtotal return 

 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Returns Sub Total</td>
 <?php 
$subtitalReturnAcc=0;
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotal) { 
 $academic_yearIDQR=$resultsAmountSubtotal->disbursementBatch->academic_year_id;
 $ReturnsAmountSubTotal = \common\models\LoanBeneficiary::getAmountSubtotalReturned($applicant_id,$academic_yearIDQR);
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($ReturnsAmountSubTotal->disbursed_amount > 0){
 echo number_format($ReturnsAmountSubTotal->disbursed_amount,2); 
 }else{
 echo "";
 }
 $subtitalReturnAcc +=$ReturnsAmountSubTotal->disbursed_amount;
 ?></td>
 <?php 
 } ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalReturnAcc,2); ?></td>
 </tr>
 
 <?php
 //}
 //end
 
 //here after subtotal return 
 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Sub Total (After Returns)</td>
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAcc,2); ?></td>
 </tr>
 <?php
 }else{
 $subtitalAcc=$subtitalAccq;
 }
 //here for additional charges 
 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Additional Charges :</td></tr>
 <tr <?php echo" style=\"\"";?>><td>Administration Fee</td>
 <?php 
$LAF=backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicant_id);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($LAF,2); ?></td>
 </tr>
 <tr <?php echo" style=\"\"";?>><td>Penalty</td>
 <?php 
$penalty=backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicant_id);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($penalty,2); ?></td>
 </tr>
 <tr <?php echo" style=\"\"";?>><td>Value Retention Fee</td>
 <?php 
$vrf=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($vrf,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Additional Charges Sub Total</td>
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($additionalChargeSubTotal,2); ?></td>
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalLoan,2); ?></td>
 </tr>
  <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Repayment :</td></tr>
 <tr <?php echo" style=\"\"";?>><td>Amount Repaid</td>
 <?php 
$amountPaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($amountPaid,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Outstanding Loan :</td>
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($outstandingLoan,2); ?></td>
 </tr>
 </table>
 <br/>
 <hr>
  <?php 
 $loggedin=Yii::$app->user->identity->firstname.", ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;
 echo "Printed By : ".$loggedin."<br/>";
 echo "Verified By : ______________________________________________ ";
 ?>
	</body>
</html>