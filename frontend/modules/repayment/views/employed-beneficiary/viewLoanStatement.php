<?php 
use \backend\modules\disbursement\models\Disbursement;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

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
$labeltittle="Provisional Loan Statement";	
}else{
$labeltittle="Verified Loan Statement";
}
$subtitalAcc=0;
$subtitalAccq=0;
$this->title = $labeltittle;
$headerColor='#D9EDF7';
$colorChange1='#F9F9F9';
$colorChange2='#FFFFFF';
$colorReqF='#F9F9F9';
$this->params['breadcrumbs'][] = $this->title;
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
		\frontend\modules\repayment\models\LoanSummary::createLoanSummaryIndividual($applicant_id);
		//end
		$loanee = frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
$getProgramme = frontend\modules\application\models\application::findBySql("SELECT applicant.f4indexno,programme.programme_name,learning_institution.institution_code FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id WHERE application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();
$programmeResultd=\common\models\LoanBeneficiary::getAllProgrammeStudied($applicant_id);
 ?>
 <table><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INSTITUTION/COLLEGE:&nbsp;&nbsp;&nbsp;</td><td><?php 
 echo $programmeResultd->institution_code; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>COURSE:&nbsp;&nbsp;&nbsp;</td><td><?php echo $programmeResultd->programme_name; ?></td></tr><tr><td <?php echo" style=\"text-align:right;font-weight:bold;font-family: Times;\"";?>>INDEX NUMBER:&nbsp;&nbsp;&nbsp;</td><td><?php echo $getProgramme->f4indexno; ?></td></tr></table>
		
 <table >
 &nbsp;&nbsp;&nbsp;
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
$LAF=backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicant_id,$todate);
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
$penalty=backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicant_id,$todate);
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
$vrf=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id,$todate);
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
$amountPaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicant_id,$todate);
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
 </div>
    </div>
</div>