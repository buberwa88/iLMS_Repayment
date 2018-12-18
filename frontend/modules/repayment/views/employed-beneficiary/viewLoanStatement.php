<?php 
use \backend\modules\disbursement\models\Disbursement;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
$loan_given_toThroughEmployer=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
$postgraduate=0;
$mpdf = new mPDF();
$todate=date("Y-m-d");
if($applicantID !=''){
$applicant_id=$applicantID;
}
if($model->applicant_id !=''){
$applicant_id=$model->applicant_id;
}
$checkApproved=0;
if($checkApproved==0){
//$labeltittle="Provisional Loan Statement";
$labeltittle="Customer Statement as of ".date("d-m-Y");	
}else{
//$labeltittle="Verified Loan Statement";
$labeltittle="Customer Statement as of ".date("d-m-Y");	
}
$subtitalAcc=0;
$subtitalAccq=0;
$this->title = $labeltittle;
$headerColor='#D9EDF7';
$colorChange1='#F9F9F9';
$colorChange2='#FFFFFF';
$colorReqF='#F9F9F9';
$this->params['breadcrumbs'][] = $this->title;
$resultsCountNotThroughEmployer=\common\models\LoanBeneficiary::checkForBeneficiaryLoanNotThroughEmployer($applicant_id);
$resultsCountThroughEmployer=\common\models\LoanBeneficiary::checkForBeneficiaryLoanThroughEmployer($applicant_id);
if($resultsCountNotThroughEmployer ==1 && $resultsCountThroughEmployer==1){
$bothExists=1;	
}else{
$bothExists=0;	
}
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
<?php  //echo Html::a('Print', Url::toRoute(['/report/report/print-report-students','id' =>$applicant_id]),
                //['target' => '_blank']);
          ?>
        </div>
        <div class="panel-body">
		<?php	
		//create loan summary
		\frontend\modules\repayment\models\LoanSummary::createLoanSummaryIndividual($applicant_id,$loan_given_to);
		//end
		$loanee = frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
$getProgramme = frontend\modules\application\models\Application::findBySql("SELECT applicant.f4indexno,programme.programme_name,learning_institution.institution_code FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id WHERE application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();
$programmeResultd=\common\models\LoanBeneficiary::getAllProgrammeStudiedGeneral($applicant_id);
 ?>
 <table><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INSTITUTION/COLLEGE:&nbsp;&nbsp;&nbsp;</td><td><?php 
 echo $programmeResultd->institution_code; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>COURSE:&nbsp;&nbsp;&nbsp;</td><td><?php echo $programmeResultd->programme_name; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INDEX NUMBER:&nbsp;&nbsp;&nbsp;</td><td><?php echo $getProgramme->f4indexno; ?></td></tr></table>

<?php if($resultsCountNotThroughEmployer==1){	?> 
 <table >
 &nbsp;&nbsp;&nbsp;
 <?php if($bothExists==1){ ?>
 <p><strong>SECTION A :&nbsp;&nbsp;&nbsp;</strong>STUDENT LOAN</p>
 <?php } ?>
 <tr <?php 
 echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>>
 <td>Item/AC. Year</td>
 <?php
	$resultAcademic = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);	
	foreach ($resultAcademic as $disbursedbatchResults) {
	?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
  echo $disbursedbatchResults->disbursementBatch->academicYear->academic_year;
 ?></td>
 <?php
$sn++;
 }
 $val=$sn + 1;
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Loan Items :</td></tr>
 <?php
 $item1=1;
 $resultLoanItems = \common\models\LoanBeneficiary::getLoanItemsProvided($applicant_id);	
	foreach ($resultLoanItems as $resultLoanItemsResults) {
	?>
 <tr <?php

 if ($item1 % 2 == 0) {
  $colorReq=$colorChange2;
}else{
  $colorReq=$colorChange1;
}

 echo" style=\"background-color:$colorReq;\"";?>><td ><?php 
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
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
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
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($total,2); ?></td>
 </tr>
 <?php
 ++$item1;
 } 
 
 //here for subtotal 

 $resultAcademicTrendSubTotal = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php  echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Sub Total:</td>
 <?php 
 foreach ($resultAcademicTrendSubTotal as $resultsAmountSubtotal2) { 
 $academic_yearIDQR=$resultsAmountSubtotal2->disbursementBatch->academic_year_id;
 $SubTotalAmount2 = \common\models\LoanBeneficiary::getAmountSubtotalPerAccademicY($applicant_id,$academic_yearIDQR);
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 if($SubTotalAmount2->disbursed_amount > 0){
 echo number_format($SubTotalAmount2->disbursed_amount,2); 
 }else{
 echo "";
 }
 $subtitalAccq +=$SubTotalAmount2->disbursed_amount;
 ?></td>
 <?php 
 } ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAccq,2); ?></td>
 </tr>
 
 <?php
 //end
 $resultReturnCheck=\common\models\LoanBeneficiary::checkForReturnForLoanee($applicant_id);
 if($resultReturnCheck==1){
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Returns :</td></tr>

 <?php

 $loanItemReturns = \common\models\LoanBeneficiary::getLoanItemsReturned($applicant_id);
$item2=1; 
	foreach ($loanItemReturns as $loanItemReturnsResults) {
	?>
 <tr <?php 
 
 if ($item2 % 2 == 0) {
  $colorReq1=$colorChange2;
}else{
  $colorReq1=$colorChange1;
}
 
 echo" style=\"background-color:$colorReq1;\"";?>><td ><?php 
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
 ++$item2;
 }
//here for subtotal return 

 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Returns Sub Total</td>
 <?php 
$subtitalReturnAcc=0;
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotal) { 
 $academic_yearIDQR=$resultsAmountSubtotal->disbursementBatch->academic_year_id;
 $ReturnsAmountSubTotal = \common\models\LoanBeneficiary::getAmountSubtotalReturned($applicant_id,$academic_yearIDQR);
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
 $resultAcademicTrendReturn = \common\models\LoanBeneficiary::getAcademicYearTrend($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Sub Total (After Returns)</td>
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
$LAF=backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicant_id,$todate,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($LAF,2); ?></td>
 </tr>
 <tr <?php echo" style=\"background-color:$colorReqF;\"";?>><td>Penalty</td>
 <?php 
$penalty=backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicant_id,$todate,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($penalty,2); ?></td>
 </tr>
 <tr <?php echo" style=\"\"";?>><td>Value Retention Fee</td>
 <?php 
$vrf=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id,$todate,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($vrf,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Additional Charges Sub Total</td>
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
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($additionalChargeSubTotal,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Total Loan</td>
 <?php 
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
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalLoan,2); ?></td>
 </tr>
  <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Repayment :</td></tr>
 <tr <?php echo" style=\"\"";?>><td>Amount Repaid</td>
 <?php 
$amountPaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id,$todate,$loan_given_to);
 foreach ($resultAcademicTrendReturn as $resultsAmountSubtotalAcc) { 
 //echo $amountSubTtal;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo "";
 ?></td>
 <?php 
 }
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($amountPaid,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Outstanding Loan :</td>
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
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($outstandingLoan,2); ?></td>
 </tr>
 </table>
 <?php } ?>
  <?php if($resultsCountThroughEmployer==1){ 
  $subtitalAccqThroughEmployer=0;
  $LAFthroughEmployer=0;
  $penaltyThroughEmployer=0;
  $vrfThroughEmployer=0;
  ?>
  
<table >
 &nbsp;&nbsp;&nbsp;
 <?php if($bothExists==1){ ?>
 <p><strong>SECTION B:&nbsp;&nbsp;&nbsp;</strong>EMPLOYER LOAN</p>
 <?php } ?>
 <tr <?php 
 echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>>
 <td>Item/AC. Year</td>
 <?php
	$resultAcademicThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
	foreach ($resultAcademicThroughEmployer as $disbursedbatchResults) {
	?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
  echo $disbursedbatchResults->disbursementBatch->academicYear->academic_year;
 ?></td>
 <?php
$sn++;
 }
 $val=$sn + 1;
 ?>
 <td <?php echo" style=\"text-align:right;\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Loan Items :</td></tr>
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

 echo" style=\"background-color:$colorReq;\"";?>><td ><?php 
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
 <tr <?php  echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Sub Total:</td>
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
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Returns :</td></tr>

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
 
 echo" style=\"background-color:$colorReq1;\"";?>><td ><?php 
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
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Returns Sub Total</td>
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
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Sub Total (After Returns)</td>
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
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAccThroughEmployer,2); ?></td>
 </tr>
 <?php
 }else{
 $subtitalAccThroughEmployer=$subtitalAccqThroughEmployer;
 }
 //here for additional charges 
 $resultAcademicTrendReturnThroughEmployer = \common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicant_id);
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Additional Charges :</td></tr>
 <tr <?php echo" style=\"\"";?>><td>Value Retention Fee</td>
 <?php 
$vrfThroughEmployer=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginalGivenToApplicantTrhEmployer($applicant_id,$todate,$loan_given_toThroughEmployer);
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
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Additional Charges Sub Total</td>
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
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Total Loan</td>
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
  <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Repayment :</td></tr>
 <tr <?php echo" style=\"\"";?>><td>Amount Repaid</td>
 <?php 
$amountPaidThroughEmployer=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id,$todate,$loan_given_toThroughEmployer);
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
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Outstanding Loan :</td>
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
 <tr <?php echo" style=\"font-weight:bold;background-color:$headerColor;\"";?>><td>Overall Outstanding Loan :</td>
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
 </table>
 <?php } ?>
 </div>
    </div>
</div>