<?php 
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;
use backend\modules\disbursement\models\Disbursement;
$headerSchedule=0;
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
$style1='style="text-align: right;font-size: 10pt;"';
$style2='style="text-align:right;font-size: 10pt;"';
$style3='style="text-align:left;font-size: 10pt;"';
$style4='style="text-align: right;font-size: 13pt;"';
$style5HeaderS='style="text-align: right;font-size: 7pt;"';
$style5HeaderEmpC='style="text-align: right;font-size: 7pt;"';
$style5HeaderPayD='style="text-align: right;font-size: 7pt;"';
$style5HeaderAmount='style="text-align: right;font-size: 7pt;"';

$style5DataS='style="text-align: right;font-size: 8pt;"';
$style5DataEmpC='style="text-align: right;font-size: 8pt;"';
$style5DataPayD='style="text-align: right;font-size: 8pt;"';
$style5DataAmount='style="text-align: right;font-size: 8pt;"';
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;

$subtitalAcc=0;
$subtitalAccq=0;
$date=date("Y-m-d");
$duration_type="months";
?>
 <?php 
$loanee = frontend\modules\application\models\Applicant::find()
	                                                           ->where(['applicant_id'=>$applicant_id])->one();
$getProgramme = frontend\modules\application\models\Application::findBySql("SELECT applicant.sex,applicant.f4indexno,programme.programme_name,learning_institution.institution_code FROM application INNER JOIN applicant ON applicant.applicant_id=application.applicant_id INNER JOIN disbursement ON disbursement.application_id=application.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id WHERE application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();

$programmeResultd=\common\models\LoanBeneficiary::getAllProgrammeStudiedGeneral($applicant_id);
 ?>
 <?php if($headerSchedule==1){ ?>
 <table witdth='100%'><tr>
         <td <?php echo $style2; ?>>FULL NAME:&nbsp;&nbsp;&nbsp;</td>
         <td <?php echo $style3; ?>><?php echo $loanee->user->firstname.", ".$loanee->user->middlename." ".$loanee->user->surname; ?></td>
         <td <?php echo $style1; ?>></td><td <?php echo $style4; ?>></td>
         </tr><tr>
         <td <?php echo $style2; ?>>INDEXNO:&nbsp;&nbsp;&nbsp;</td>
         <td <?php echo $style3; ?>><?php echo $getProgramme->f4indexno; ?></td>
         <td <?php echo $style1; ?>></td>
         <td <?php echo $style4; ?>></td></tr>
         <tr>
             <td <?php echo $style2; ?>>GENDER:&nbsp;&nbsp;&nbsp;</td>
             <td <?php echo $style3; ?>><?php echo $getProgramme->sex; ?></td>
             <td <?php echo $style1; ?>></td>
             <td <?php echo $style4; ?>></td></tr>
         <tr>
             <td <?php echo $style2; ?>>INSTITUTION(S):&nbsp;&nbsp;&nbsp;</td>
             <td <?php echo $style3; ?>><?php echo $programmeResultd->institution_code; ?></td>
             <td <?php 
             $balance=\frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($applicant_id,$date,$loan_given_to);
             echo $style1; ?>></td>
             <td <?php echo $style4; ?>></td>
         </tr></table>
 <?php } 
 $this->title="My Re-Payment Schedule";
 ?>
 <div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
            <em>
       <?= Html::encode($this->title) ?>
                </em>
        </div>
        <div class="panel-body">
<?php
$balance=\frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($applicant_id,$date,$loan_given_to);
$getPaymentsOfLoanee = \backend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount,loan_repayment.payment_date,employer.employer_code,employer.short_name,loan_repayment_detail.applicant_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id LEFT JOIN employer ON employer.employer_id=loan_repayment.employer_id LEFT JOIN applicant ON applicant.applicant_id=loan_repayment.applicant_id WHERE loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.payment_status='1' AND loan_repayment_detail.applicant_id=:applicant_id GROUP BY loan_repayment.payment_date ORDER BY loan_repayment.payment_date ASC",[':applicant_id'=>$applicant_id])->all();
$sno=1;
?>
<br/><br/>
     <table width='100%'>
         <tr><th <?php echo $style5HeaderAmount; ?>>SNO</th><th <?php echo $style5HeaderAmount; ?>>Pay Period</th><th <?php echo $style5HeaderAmount; ?>>Amount</th><th <?php echo $style5HeaderAmount; ?>>Laf Portion</th><th <?php echo $style5HeaderAmount; ?>>Penalty Portion</th><th <?php echo $style5HeaderAmount; ?>>Vrf Portion</th><th <?php echo $style5HeaderAmount; ?>>Principal Portion</th><th <?php echo $style5HeaderAmount; ?>>Vrf Applicable</th><th <?php echo $style5HeaderAmount; ?>>Oustanding Principal</th></tr>

<?php
$amountPTotal=0;
$amountPTotalAccumulated=0;
$totalLAFLoop=0;
$totalPNTLoop=0;
$totalVRFLoop=0;
$totalPRCLoop=0;
$totalPrinciplePaid=0;
$totalAcruedVRF=0;
$totalAcruedVRFfirst=0;
$totalAcruedVRF1First=0;
$acruedVRFBefore=0;
$amountPerMonth=0;

$TotalamountPerMonth =0;
$amountPerMonthLAF =0;
$amountPerMonthPNT =0;
$amountPerMonthVRF =0;
$amountPerMonthPRC =0;
$totalAcruedVRF =0;
$TotalPRCGeneral =0;
##############added 04-02-2019################
$overallVRFinPayment=0;
#################end#############################
$factor=2;//the possible payment loop
//check if employed
     $MLREB=\frontend\modules\repayment\models\EmployedBeneficiary::getEmployedBeneficiaryPaymentSetting();	
	 $paymentCalculation = \frontend\modules\repayment\models\EmployedBeneficiary::findBySql("SELECT  basic_salary,applicant_id  FROM employed_beneficiary WHERE  employed_beneficiary.applicant_id='$applicant_id' AND employment_status='ONPOST' AND verification_status='1' AND loan_summary_id >'0'")->one();
	 if($paymentCalculation->applicant_id > 0){
	$amount1=$MLREB*$paymentCalculation->basic_salary;	 
	 }else{
	$amount1=\frontend\modules\repayment\models\EmployedBeneficiary::getNonEmployedBeneficiaryPaymentSetting();
	 }	 
//end check if employed

//check the last payment of beneficiary
$paymentLoanRepayment = \frontend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT  loan_repayment.payment_date  FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id WHERE  loan_repayment_detail.applicant_id='$applicant_id' AND loan_repayment.payment_status='1' AND loan_repayment_detail.loan_given_to='$loan_given_to'")->orderBy(['loan_repayment_detail'=>SORT_DESC])->one();
$lastPaydate = date_create($paymentLoanRepayment->payment_date);
$todate = date_create($date);
$interval = date_diff($lastPaydate, $todate);
$dateDifferenceInMonth=$interval->format('%m');

if($paymentLoanRepayment->payment_date !=''){
	if($dateDifferenceInMonth > 0){
$payment_date=date("Y-m-d");
	}else{
				$payment_date=$paymentLoanRepayment->payment_date;
	}
}else{
$payment_date=date("Y-m-d");	
}
//end last payment

//get total intervals of payment
$totalMonths=$balance/$amount1;
//end get total intervals of payment
        $totalAmount=0; 
        $constantPaymentDate=date("Y-m-d",strtotime($payment_date));
		
//check ORIGINAL AMOUNT PER Items
$totalPrincipalORGN=backend\modules\repayment\models\LoanSummaryDetail::getTotalPrincipleLoanOriginal($applicant_id,$date,$loan_given_to);
$totalVRFORGN=backend\modules\repayment\models\LoanSummaryDetail::getTotalVRFOriginal($applicant_id,$date,$loan_given_to);
$totalPNTORGN=backend\modules\repayment\models\LoanSummaryDetail::getTotalPenaltyOriginal($applicant_id,$date,$loan_given_to);
$totalLAFORGN=backend\modules\repayment\models\LoanSummaryDetail::getTotalLAFOriginal($applicant_id,$date,$loan_given_to);
//end check amount per item		
//check loan repayment item balances
//-------------Items ID------
    $itemCodeLAF="LAF";
	$LAF_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeLAF);
	$itemCodePNT="PNT";
	$PNT_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePNT);
	$itemCodeVRF="VRF";
	$VRF_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);
	$itemCodePRC="PRC";
	$PRC_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePRC);
//------------end items ID------------

    $AmountPaidPerItemTotalLAF=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$LAF_id,$loan_given_to);
	$totalAmountAlreadyPaidLAF=$AmountPaidPerItemTotalLAF->amount;
	$AmountPaidPerItemTotalPNT=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$PNT_id,$loan_given_to);
	$totalAmountAlreadyPaidPNT=$AmountPaidPerItemTotalPNT->amount;
	$AmountPaidPerItemTotalVRF=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$VRF_id,$loan_given_to);
	$totalAmountAlreadyPaidVRF=$AmountPaidPerItemTotalVRF->amount;
	$AmountPaidPerItemTotalPRC=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerItemtoBeneficiary($applicant_id,$PRC_id,$loan_given_to);
	$totalAmountAlreadyPaidPRC=$AmountPaidPerItemTotalPRC->amount;
	$balanceLAF=$totalLAFORGN-$totalAmountAlreadyPaidLAF;
	$balancePNT=$totalPNTORGN-$totalAmountAlreadyPaidPNT;
	$balanceVRF=$totalVRFORGN-$totalAmountAlreadyPaidVRF;
	$balancePRC=$totalPrincipalORGN-$totalAmountAlreadyPaidPRC;
	if($balanceLAF > 0){$balanceLAF=$balanceLAF;$balanceLAFfirst=$balanceLAF;}else{$balanceLAF=0;$balanceLAFfirst=0;}
	if($balancePNT > 0){$balancePNT=$balancePNT;$balancePNTFirst=$balancePNT;}else{$balancePNT=0;$balancePNTFirst=0;}
	if($balanceVRF > 0){$balanceVRF=$balanceVRF;$balanceVRFfirst=$balanceVRF;}else{$balanceVRF=0;$balanceVRFfirst=0;}
	if($balancePRC > 0){$balancePRC=$balancePRC;$balancePRCFirst=$balancePRC;}else{$balancePRC=0;$balancePRCFirst=0;}
	$resultsVRFRepaymentRate=\backend\modules\repayment\models\LoanRepaymentSetting::getLoanRepaymentRateVRF($VRF_id);
	$vrfRepaymentRate=$resultsVRFRepaymentRate->loan_repayment_rate*0.01;
	$resultsLAFRepaymentRate=\backend\modules\repayment\models\LoanRepaymentSetting::getLoanRepaymentRateOtherItems($LAF_id);
	$LAFRepaymentRate=$resultsLAFRepaymentRate->loan_repayment_rate*0.01;
	$resultsPNTRepaymentRate=\backend\modules\repayment\models\LoanRepaymentSetting::getLoanRepaymentRateOtherItems($PNT_id);
	$PNTRepaymentRate=$resultsPNTRepaymentRate->loan_repayment_rate*0.01;
	$numberOfDaysPerYear=\backend\modules\repayment\models\EmployedBeneficiary::getTotaDaysPerYearSetting();
//end  check loan repayment item balances       
//get VRF before schedule
			    $dateConstantForPaymentbe=$constantPaymentDate;
				$dateCreatedqqbe=date_create($dateConstantForPaymentbe);
				$dateDurationAndTypeqqbe="1"." ".$duration_type;
				date_add($dateCreatedqqbe,date_interval_create_from_date_string($dateDurationAndTypeqqbe));
				$payment_dateBe=date_format($dateCreatedqqbe,"Y-m-d");
				$totalNumberOfDaysBe=round((strtotime($payment_dateBe)-strtotime($date))/(60*60*24));
				$acruedVRFBefore=$balancePRC*$vrfRepaymentRate*$totalNumberOfDaysBe/$numberOfDaysPerYear;
				
//end get VRF before schedule        		
        //foreach ($details_applicant as $paymentCalculation) { 			   
           $totalOutstandingAmount=$balance;
		   if($totalOutstandingAmount > 0){
			$countForPaymentDate=1;
			$countForPaymentDateFirst=1;
			$countForPaymentDate1First=1;
			
			$totalMonths=((($balancePRC + $balanceLAF + $balancePNT + $balanceVRF)/$amount1)*$factor);
			$totalOutstandingAmount=($balancePRC + $balanceLAF + $balancePNT + $balanceVRF);
			$balanceVRF +=$acruedVRFBefore;
        for($countP=1;$countP <= $totalMonths; ++$countP){
			$amountPTotal +=$amount1;
			//if($totalOutstandingAmount >= $amountPTotal){
				if(($balanceVRF >=$overallVRFinPayment) OR ($balancePRC >= $totalPrinciplePaid)){
			//get payment date
			    $dateConstantForPayment=$constantPaymentDate;
				$dateCreatedqq=date_create($dateConstantForPayment);
				$dateDurationAndTypeqq=$countForPaymentDate." ".$duration_type;
				date_add($dateCreatedqq,date_interval_create_from_date_string($dateDurationAndTypeqq));
				$payment_date=date_format($dateCreatedqq,"Y-m-d");
				//end	
			$amountPTotalAccumulated=$amountPTotal;
			$payment_dateLast=$payment_date;
			$mnc=0;
			//distribute amount in respective item according to the repayment rate
			//----here for LAF portion----
			if($balanceLAF > 0){
				if($amount1 >=$balanceLAF ){
				$LAFportion=$balanceLAF;
                $remainingAmount=$amount1-$balanceLAF;			
				}else{
				$LAFportion=$amount1;
                $remainingAmount=0;				
				}
			}else{
			$remainingAmount=$amount1;	
			}
			
			$totalLAFPaymentTotal=$totalLAFLoop;
			$totalLAFLoop +=$LAFportion;
			if($balanceLAF >= $totalLAFLoop){$LAFportion=$LAFportion;}else{
				$LAFportion1=$balanceLAF - $totalLAFPaymentTotal;
				if($LAFportion1 > 0){
				$LAFportion=$LAFportion1;	
				}else{
					$LAFportion=0;
				}
				}
			
			$amount_remained=$amount1-$LAFportion;
			
			//----here for penalty portion----	
         $penalty_portion = $amount_remained * $PNTRepaymentRate;
            if(($balancePNT >= $penalty_portion) && $balancePNT > 0){
             $penalty_portion=$penalty_portion;   
            }else if((($balancePNT < $penalty_portion) && $balancePNT > 0)){
             $penalty_portion=$balancePNT;   
            }else{
             $penalty_portion=0;   
            }
		 
			$totalPNTPaymentTotal=$totalPNTLoop;
			$totalPNTLoop +=$penalty_portion;
			if($balancePNT >= $totalPNTLoop){$penalty_portion=$penalty_portion;}else{
				$penalty_portion1=$balancePNT - $totalPNTPaymentTotal;
				if($penalty_portion1 > 0){
				$penalty_portion=$penalty_portion1;	
				}else{
					$penalty_portion=0;
				}
				}
		$amount_remained1=$amount_remained-$penalty_portion;		
        //---end for penalty----
		$totalPRCPaymentTotal=$totalPRCLoop;
		$principleBalancePreviousFirst=$balancePRC-$totalPRCPaymentTotal;
		//here VRF ACRUE 
			if($countP > 1){
				
			    $dateConstantForPayment1First=$constantPaymentDate;
				$dateCreatedqq1First=date_create($dateConstantForPayment1First);
				$dateDurationAndTypeqqFirst=$countForPaymentDate1First." ".$duration_type;
				date_add($dateCreatedqq1First,date_interval_create_from_date_string($dateDurationAndTypeqqFirst));
				$payment_date1First=date_format($dateCreatedqq1First,"Y-m-d");	
			$totalNumberOfDaysFirst=round((strtotime($payment_date)-strtotime($payment_date1First))/(60*60*24));
			if($principleBalancePreviousFirst > 0){
			$totalAcruedVRF1First=$principleBalancePreviousFirst*$vrfRepaymentRate*$totalNumberOfDaysFirst/$numberOfDaysPerYear;
			}else{
			$totalAcruedVRF1First=0;	
			}
            //$totalAcruedVRFFirst .=$totalAcruedVRF1First."----".$principleBalancePreviousFirst."---".$payment_date1First."--".$payment_dateFirst."--".$totalNumberOfDaysFirst."<br/>";
            //$totalAcruedVRFfirst +=$totalAcruedVRF1First;			
			++$countForPaymentDate1First;
			//echo  $totalNumberOfDaysFirst."tele";exit;
			}			
			$balanceVRF +=$totalAcruedVRF1First;
			//END VRF ACRUE
		
		
		//-----here for VRF portion----
		$principleBalance=$balancePRC-$totalPrinciplePaid;
        if($balancePRC > 0 && $principleBalance > 0){
         $vrf_portion=$amount_remained1 * $vrfRepaymentRate;		 
         if($balanceVRF >=$totalVRFLoop){
			 if($balanceVRF >=$vrf_portion){
         $vrfTopay=$vrf_portion;
         $amount_remained22=$amount_remained1-$vrfTopay;
          ##########added 04-02-2019#######
		 if($amount_remained22 > $principleBalance){
			 $amountUnassigned=$amount_remained22-$principleBalance;
			 $vrfTopay=$vrfTopay+$amountUnassigned;
		 } 
          ##end#######################		  
		 }else{
         $vrfTopay=$balanceVRF; 
         $amount_remained22=$amount_remained1-$vrfTopay;
		 }         
         }else{
         $vrfTopay=0; 
         $amount_remained22=$amount_remained1-$vrfTopay;
         }         
        }else{
            if($balanceVRF >=$amount_remained1){
         $vrfTopay=$amount_remained1;
         $amount_remained22=0; 
         }else{
         $vrfTopay=$balanceVRF; 
         $amount_remained22=0;
         }
        }
	
		$totalVRFPaymentTotal=$totalVRFLoop;

	        
			if($balanceVRF >= $totalVRFLoop){
				if($balanceVRF >=($totalVRFLoop + $vrfTopay)){
				$vrfTopay=$vrfTopay;
			}else{$vrfTopay=$vrfTopay-(($totalVRFLoop + $vrfTopay)-$balanceVRF);}}else{
				$vrfTopay1=$balanceVRF - $totalVRFPaymentTotal;
				if($vrfTopay1 > 0){
				$vrfTopay=$vrfTopay1;	
				}else{
					$vrfTopay=0;
				}
				}
				$totalVRFLoop +=$vrfTopay; 
					
				
		$amount_remained2=$amount_remained1-$vrfTopay;		
		//end here for VRF portion----
		
		//check if principal amount exceed
        if($balancePRC >= $amount_remained2){
        $amount_remained2=$amount_remained2;    
        }else if($balancePRC < $amount_remained2 && $balancePRC >'0'){
        $amount_remained2=$balancePRC;    
        }else{
        $amount_remained2='0';    
        }
		
			$totalPRCLoop +=$amount_remained2;
			
			if($balancePRC >= $totalPRCLoop){$amount_remained2=$amount_remained2;}else{
				$amount_remained211=$balancePRC - $totalPRCPaymentTotal;
				if($amount_remained211 > 0){
				//$amount_remained2=$amount_remained211;
                $amount_remained2=$amount_remained2;				
				}else{
					$amount_remained2=0;
				}
				}	
        // end check principle amount exceed
			//end
			//first check principalbalance and incoming balance
			$principleBalance=$balancePRC-$totalPrinciplePaid;
			if($principleBalance > $amount_remained2){
				$amount_remained2=$amount_remained2;
			}else{
				$amount_remained2=$principleBalance;
			}
            //end check			
			
			$totalPrinciplePaid +=$amount_remained2;
			$principleBalance=$balancePRC-$totalPrinciplePaid;
			if($principleBalance > 0){
				$principleBalance=$principleBalance;
			}else{
			$principleBalance=0;	
			}
			
			
			$overallLAFinPayment +=$LAFportion;
			$overallPNTinPayment +=$penalty_portion;
			$overallVRFinPayment +=$vrfTopay;
            if($countP==1){
				$totalAcruedVRF1First=$acruedVRFBefore + $balanceVRFfirst;				
			}else{
			$totalAcruedVRF1First=$totalAcruedVRF1First;	
			}
			$vrfTopayCheckIf=number_format($vrfTopay,2);$checkLAFportionIf=number_format($LAFportion,2);$checkpenalty_portionIf=number_format($penalty_portion,2);$checkamount_remained2If=number_format($amount_remained2,2);$checktotalAcruedVRF1FirstIf=number_format(($totalAcruedVRF1First),2);$checkprincipleBalanceIf=number_format(($principleBalance),2);
if($checkLAFportionIf > 0 || $checkpenalty_portionIf > 0 || $vrfTopayCheckIf > 0 || $checkamount_remained2If > 0 || $checktotalAcruedVRF1FirstIf > 0 || $checkprincipleBalanceIf > 0){			
			?>
			
	<tr>
	<td <?php echo $style5DataAmount; ?>><?php echo $countP; ?></td>
    <td <?php echo $style5DataAmount; ?>><?php echo date("d-m-Y",strtotime($payment_date)); ?></td>
    <td <?php echo $style5DataAmount; ?>><?php 
	$amount1=$LAFportion + $penalty_portion + $vrfTopay + $amount_remained2;
	echo number_format(($amount1),2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format($LAFportion,2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format($penalty_portion,2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format($vrfTopay,2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format($amount_remained2,2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format(($totalAcruedVRF1First),2); ?></td>
    <td <?php echo $style5DataAmount; ?>><?php echo number_format(($principleBalance),2); ?></td>
    </tr>
			
			<?php
			$TotalamountPerMonth +=$amount1;
			$amountPerMonthLAF +=$LAFportion;
			$amountPerMonthPNT +=$penalty_portion;
			$amountPerMonthVRF +=$vrfTopay;
			$amountPerMonthPRC +=$amount_remained2;
			$totalAcruedVRF +=$totalAcruedVRF1First;
			$TotalPRCGeneral +=$principleBalance;
}
			}
			//echo  $totalAcruedVRF1First;exit;
			++$countForPaymentDate;
		}
		}
?>
<tr>
	<td colspan="2" <?php echo $style5DataAmount; ?>><strong>Total</strong></td>
    <td <?php echo $style5DataAmount; ?>><?php echo number_format(($TotalamountPerMonth),2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format(($amountPerMonthLAF),2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format(($amountPerMonthPNT),2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format(($amountPerMonthVRF),2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format(($amountPerMonthPRC),2); ?></td>
	<td <?php echo $style5DataAmount; ?>><?php echo number_format(($totalAcruedVRF),2); ?></td>
	<td <?php echo $style5DataAmount; ?>></td>
    </tr>
<?php
?>
<?php

 ?>


</table>
        </div>
        </div>
</div>    

 