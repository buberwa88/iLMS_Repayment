<?php 
use backend\modules\disbursement\models\Disbursement;
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
 /*
 $getItem_acYear = frontend\modules\application\models\Applicant::find()
                                                               ->joinWith(['applications'])
															   ->joinWith(['applications','applications.disbursements'])
															   ->joinWith(['applications','applications.disbursements','applications.disbursements.disbursementBatch'])
															   ->groupBy(['disbursement.disbursement_batch_id'])
	                                                           ->where(['applicant.applicant_id'=>$applicant_id])
															   ->one();	
														   */
														   
	$getItem_acYear = frontend\modules\application\models\Application::findBySql("SELECT applicant.applicant_id AS 'applicant_id',disbursement_batch.academic_year_id AS 'academic_year_id',disbursed_amount,disbursement.disbursement_batch_id AS 'disbursement_batch_id',application.application_id AS 'application_id' FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id"
                        . " WHERE application.applicant_id='$applicant_id' GROUP BY disbursement.application_id ORDER BY disbursement.disbursement_batch_id ASC")->all();	
						
/*
$getItemacYear = frontend\modules\application\models\Application::findBySql("SELECT applicant.applicant_id,application.application_id FROM applicant  JOIN application ON application.  WHERE applicant.applicant_id='$applicant_id'")->all();						
*/															   
	$sn=0;
	$applicationArray=array();
    foreach ($getItem_acYear as $getApplicationsyurt) {
	
      $applicantion_id=$getApplicationsyurt->application_id;
      //echo $applicationArray[]=$getApplicationsyurt->application_id;
	  
	
     //echo $applicafvg=$getApplicationsyurt->applicant_id;
	 //var_dump($applicafvg);
	
	
	$resultAcademic = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursed_amount,disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id"
                        . " WHERE disbursement.application_id='$applicantion_id' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_batch_id ASC")->all();	
	foreach ($resultAcademic as $disbursedbatchResults) {
	?>
 <td <?php echo" style=\"\"";?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $getItem_acYearResults->disbursements->disbursementBatch->academicYear->academic_year;
  echo $disbursedbatchResults->disbursementBatch->academicYear->academic_year;
 ?></td>
 <?php
$sn++;
 }} 
 //print_r($applicationArray);
 //echo $applicationArray[];
 $val=$sn + 1;
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Loan Items:</td></tr>
 <?php

 $resultLoanItems = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' GROUP BY disbursement.loan_item_id ORDER BY disbursement.loan_item_id ASC")->all();	
	foreach ($resultLoanItems as $resultLoanItemsResults) {
	?>
 <tr <?php echo" style=\"\"";?>><td ><?php 
 $loanItem=$resultLoanItemsResults->loan_item_id;
 echo $resultLoanItemsResults->loanItem->item_name; ?></td>
 <?php
 $amount1 = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.loan_item_id='$loanItem' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_batch_id ASC")->all();
$loopItem=0;
$total=0;						
 foreach ($amount1 as $resultsAmount1) {
 $loopItem++;
 //for($check=$loopItem;$sn > $check;$check++){
 if($sn >= $loopItem){
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo number_format($resultsAmount1->disbursed_amount,2); 
 $total +=$resultsAmount1->disbursed_amount;
 ?></td>
 <?php }else{
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo '0.00'; ?></td>
 <?php
 }
 }
if($sn > $loopItem){
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo ''; ?></td>
 
 <?php }
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($total,2); ?></td>
 </tr>
 <?php } 
 
 $amountSubTotal = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->all();
 
 ?>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td>Sub Total:</td>
 <?php 
 $subttal=0;
 $subtitalAcc=0;
 foreach ($amountSubTotal as $resultsAmountSubtotal) { ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($resultsAmountSubtotal->disbursed_amount,2); 
 $subtitalAcc +=$resultsAmountSubtotal->disbursed_amount;
 ?></td>
 <?php 
 $subttal++;
 } ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($subtitalAcc,2); ?></td>
 </tr>
 <tr <?php echo" style=\"font-weight:bold;\"";?>><td colspan="<?php echo $val; ?>">Returns:</td></tr>

 <?php

 $loanItemReturns = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.status='5' GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->all();	
	foreach ($loanItemReturns as $loanItemReturnsResults) {
	?>
 <tr <?php echo" style=\"\"";?>><td ><?php 
 $returnedItem=$loanItemReturnsResults->loan_item_id;
 echo $loanItemReturnsResults->loanItem->item_name; ?></td>
 <?php
 $amount1Return = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.loan_item_id='$returnedItem' AND disbursement.status='5' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_batch_id ASC")->all();
$loopItemReturn=0;
$totalReturn=0;						
 foreach ($amount1Return as $resultsAmount1Return) {
 $loopItemReturn++;
 
 
 $loanItemReturnsAcademicY = \backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_batch_id ASC")->all();
 
 foreach($loanItemReturnsAcademicY as $generalAcademicYearResults){
 //echo $loopItemReturn."--".$resultsAmount1Return->disbursed_amount."--".$resultsAmount1Return->disbursementBatch->academic_year_id."<br/>";
 if($generalAcademicYearResults->disbursementBatch->academic_year_id==$resultsAmount1Return->disbursementBatch->academic_year_id){
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo number_format($resultsAmount1Return->disbursed_amount,2); 
 $totalReturn +=$resultsAmount1Return->disbursed_amount;
 ?></td>
 <?php }else{
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
 echo ''; ?></td>
 <?php
 }
 }
 }
 ?>
 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($totalReturn,2); ?></td>
 </tr>
 <?php }?>
 
 
 </table>
	</body>
</html>