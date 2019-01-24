<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use frontend\modules\repayment\models\LoanRepayment;
use frontend\modules\repayment\models\LoanSummary;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\EmployerPenalty;

/**
 * This is the model class for table "employer_penalty_payment".
 *
 * @property integer $employer_penalty_payment_id
 * @property integer $employer_id
 * @property string $amount
 * @property string $payment_date
 * @property string $created_at
 */
class EmployerPenaltyPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
    public static function tableName()
    {
        return 'employer_penalty_payment';
    }

    /**
     * @inheritdoc
     */
	 public $totalAmount;
	 public $outstandingAmount;
	 public $paidAmount;
	 public $employer_code;
	 public $employer_name;
	 public $phone_number;
    public function rules()
    {
        return [
            //[['employer_id', 'amount', 'payment_date', 'created_at'], 'required'],
			[['cancel_reason'], 'required','on'=>'Cancell_employer_penalty'],
			[['amount'], 'required','on'=>'employer_penalty_payment'],
            [['employer_id'], 'integer'],
            //[['amount'], 'number', 'min' => 1000],		
            //['age', 'integer', 'min' => 0],			
            [['payment_date', 'created_at','control_number','receipt_number','pay_method_id','date_control_requested','date_control_received','date_receipt_received','payment_status','totalAmount','outstandingAmount','paidAmount','employer_id', 'amount','employer_code','employer_name','phone_number','receipt_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employer_penalty_payment_id' => 'Employer Penalty Payment ID',
            'employer_id' => 'Employer ID',
            'amount' => 'Pay Amount',
            'payment_date' => 'Payment Date',
            'created_at' => 'Created At',
			'control_number'=>'Control Number',
			'pay_method_id'=>'Pay Method',
			'date_control_requested'=>'Date control requested',
			'date_control_received'=>'Date control received',
			'date_receipt_received'=>'Date receipt received',
			'payment_status'=>'Payment status',
			'totalAmount'=>'Total Amount',
			'outstandingAmount'=>'Outstanding Amount',
			'paidAmount'=>'Amount Paid',
        ];
    }
	/*
	public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
			
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
			
			
        ];
    }
	*/
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }
	public static function updatePenaltyPaymentAfterGePGconfirmPaymentDone($controlNumber,$amount){
        EmployerPenaltyPayment::updateAll(['payment_status' =>'1'], 'control_number ="'.$controlNumber.'" AND amount ="'.$amount.'" AND payment_status ="0"');
 }
 /*
	public static function getPenaltyToEmployer(){
	
	//check employer has active loan summary
	$loanSummaryDetailsEmployer = LoanSummary::findBySql("SELECT loan_summary_id,created_at,employer_id FROM loan_summary WHERE  (status='0' OR status='1') AND (employer_id IS NOT NULL OR employer_id <>'') ORDER BY loan_summary_id DESC")->all();
				    if((count($loanSummaryDetailsEmployer) > 0)){
					$penaltyAmount=0;
                    foreach ($loanSummaryDetailsEmployer as $loanSummaryDetailsResults) {
                    $employerID=$loanSummaryDetailsResults->employer_id; 
                    $employer_type_id=$loanSummaryDetailsResults->employer->employer_type_id;					
					$loan_summary_id=$loanSummaryDetailsResults->loan_summary_id;
					$dateLoanSummaryCreated=date("Y-m-d",strtotime($loanSummaryDetailsResults->created_at));
					if($loan_summary_id > 0){
                    $resultsEmplBeneficiary=\backend\modules\repayment\models\EmployedBeneficiary::getEmployerMontlyPenaltyRate($employer_type_id);
					$percent=$resultsEmplBeneficiary->penalty;
                    $payment_deadline_day_per_month=$resultsEmplBeneficiary->payment_deadline_day_per_month;					
                    $amount=EmployerPenaltyPayment::getAmountRequiredForMonthlyPaymentToEmployedBeneficiaryPerEmployer($employerID,$loan_summary_id);
					if($percent !='' OR $percent > 0){
					$penaltyAmount=$amount * $percent;
					}else{
					$penaltyAmount=0;
					}
					//$todateDate=date("Y-m-d");
					$todate = date("Y-m-d");
					
					//get lastpayment date
					$lastPaymentDate = LoanRepayment::findBySql("SELECT loan_repayment.payment_date AS 'payment_date' FROM loan_repayment INNER JOIN loan_repayment_detail ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id  WHERE  employer_id='$employerID' AND loan_repayment_detail.loan_summary_id='$loan_summary_id' AND loan_repayment.payment_status='1' ORDER BY loan_repayment.loan_repayment_id DESC")->one();
					$lastPaydateValue=$lastPaymentDate->payment_date;
					
					//get last penalty date
					$lastPenaltyRecorded = EmployerPenalty::findBySql("SELECT penalty_date,created_at FROM employer_penalty  WHERE  employer_id='$employerID' AND loan_summary_id='$loan_summary_id' ORDER BY employer_penalty_id DESC")->one();
					$lastPenaltyRecordedDate=$lastPenaltyRecorded->penalty_date;
                    $created_atP=date("Y-m-d",strtotime($lastPenaltyRecorded->created_at));					
					
					
					//check for penalty to be taken
					if($lastPaydateValue !='' && $lastPaydateValue !="0000:00:00"){

                    $date1 = $lastPaydateValue;
					$date2 = $todate;
					
					$ts1 = strtotime($date1);
					$ts2 = strtotime($date2);
					
					$year1 = date('Y', $ts1);
					$year2 = date('Y', $ts2);

					$month1 = date('m', $ts1);
					$month2 = date('m', $ts2);

					$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
					if($diff >1){				 
					//check the configured time for penalty
					$createdDate=date("Y-m-d H:i:s");
					$dateConfiguredPerMonth=date("Y-m")."-".$payment_deadline_day_per_month;
					$penaltyDate=date("Y-m-d", strtotime('-1 months', strtotime($dateConfiguredPerMonth)));
					$penaltyCheckResult=EmployerPenaltyPayment::checkIfPenaltyExists($employerID,$loan_summary_id,$penaltyDate);
					if($todate > $dateConfiguredPerMonth && $penaltyCheckResult==0 && $lastPenaltyRecordedDate < $penaltyDate){
					Yii::$app->db->createCommand()
					->insert('employer_penalty', [
					'employer_id' =>$employerID,
					'amount' =>$penaltyAmount,
					'penalty_date' =>$penaltyDate,
					'created_at' =>$createdDate, 
                    'loan_summary_id' =>$loan_summary_id,					
					])->execute();
					}
                    }					
					}else{                                   					
					//check last recorded in penalty table
					if($lastPenaltyRecordedDate !='' && $lastPenaltyRecordedDate !="0000-00-00"){					
					//check the configured time for penalty
					$createdDate=date("Y-m-d H:i:s");
					$dateConfiguredPerMonth=date("Y-m")."-".$payment_deadline_day_per_month;
					$penaltyDate=date("Y-m-d", strtotime('-1 months', strtotime($dateConfiguredPerMonth)));
					$penaltyCheckResult=EmployerPenaltyPayment::checkIfPenaltyExists($employerID,$loan_summary_id,$penaltyDate);
					if($todate > $dateConfiguredPerMonth && $penaltyCheckResult==0 && $lastPenaltyRecordedDate < $penaltyDate){
					//if($todate > $dateConfiguredPerMonth){
					Yii::$app->db->createCommand()
					->insert('employer_penalty', [
					'employer_id' =>$employerID,
					'amount' =>$penaltyAmount,
					'penalty_date' =>$penaltyDate,
					'created_at' =>$createdDate,
                    'loan_summary_id' =>$loan_summary_id,					
					])->execute();
					}
					
                     }else{					 
					 //check the configured time to start payment after loan summary posted
					$createdDate=date("Y-m-d H:i:s");
					$nowDate = strtotime($createdDate); // or your date as well
					$ydateLoanSummaryCreated = strtotime($dateLoanSummaryCreated);
					$datediff = $nowDate - $ydateLoanSummaryCreated;
				    $totalDays=round($datediff / (60 * 60 * 24));					
					$daysConfigured=Yii::$app->params['daysCounting'];
					//end					
					$createdDate=date("Y-m-d H:i:s");
					$dateConfiguredPerMonth=date("Y-m")."-".$payment_deadline_day_per_month;
					$penaltyDate=date("Y-m-d", strtotime('+'.$daysConfigured.'days', strtotime($dateLoanSummaryCreated)));
					$penaltyCheckResult=EmployerPenaltyPayment::checkIfPenaltyExists($employerID,$loan_summary_id,$penaltyDate);
					if($todate > $dateConfiguredPerMonth && $penaltyCheckResult==0){
					//if($todate > $dateConfiguredPerMonth){
					Yii::$app->db->createCommand()
					->insert('employer_penalty', [
					'employer_id' =>$employerID,
					'amount' =>$penaltyAmount,
					'penalty_date' =>$penaltyDate,
					'created_at' =>$createdDate,
                    'loan_summary_id' =>$loan_summary_id,					
					])->execute();
					}
					 
                    }					 					
					}					
					}
					}
					//end check employer has loan summary
	 }
	 }
	 */
	 public static function getPenaltyToEmployerIndividualMonths($loan_given_to){
	
	//check employer has active loan summary
	$todate=date("Y-m-d");
	$yeaAndMonth=date("Y-m");
	
	$duration=1;
	$duration_type="months";
	$getDeadlineDay=Yii::$app->params['deadlineDayForEmployerPenaltyEachMonth'];
	$yearandmonthCurrent=date("Y-m",strtotime($todate));
	$CurrentdeadlineDateOfMonth=$yearandmonthCurrent."-".$getDeadlineDay;
	
	if($todate > $CurrentdeadlineDateOfMonth){
	$allActivePenalty=\frontend\modules\repayment\models\EmployerPenalty::getActivePenalty();
	foreach ($allActivePenalty as $resultsActivePenalty){	
    /*	
	$dateCreated=date_create($todate);
	$dateDurationAndType=$duration." ".$duration_type;
	date_sub($dateCreated,date_interval_create_from_date_string($dateDurationAndType));
	$firstDayPreviousMonth1=date_format($dateCreated,"Y-m-d");
	*/
	$employerID=$resultsActivePenalty->employer_id; 
	$loan_summary_id=$resultsActivePenalty->loan_summary_id;
	$penaltyAmount=$resultsActivePenalty->amount;
	$penaltyDateOrgn=$resultsActivePenalty->penalty_date;
	$createdat=date("Y-m-d H:i:s");
	$employer_penalty_cycle_id=$resultsActivePenalty->employer_penalty_cycle_id;
	$penaltyID=$resultsActivePenalty->employer_penalty_id;

	
	//check employer special case in penalty
	$resultsSpecifcEmplPNT=\backend\modules\repayment\models\EmployedBeneficiary::getEmployerPenaltyCycleUsed($employer_penalty_cycle_id);
	
	if(count($resultsSpecifcEmplPNT) > 0){
	$percent=$resultsSpecifcEmplPNT->penalty;
	$payment_deadline_day_per_month=$resultsSpecifcEmplPNT->payment_deadline_day_per_month;//this is used as  repayment_deadline_day
	//$duration=$resultsSpecifcEmplPNT->duration;
	$duration_type1=$resultsSpecifcEmplPNT->duration_type;
	$employer_penalty_cycle_id=$resultsSpecifcEmplPNT->employer_penalty_cycle_id;
	if($duration_type1=='d'){$duration_type="days";}else if($duration_type1=='w'){$duration_type="weeks";}else if($duration_type1=='m'){$duration_type="months";}else if($duration_type1=='y'){$duration_type="years";}
	$deadlineDateOfMonth=$yeaAndMonth."-".$payment_deadline_day_per_month;
	$penaltyDate=$yeaAndMonth."-".$payment_deadline_day_per_month;	

	//end check
	$orignalPenaltyDate=date_create($resultsActivePenalty->penalty_date);
	$dateDurationAndType=$duration." ".$duration_type;
	date_sub($orignalPenaltyDate,date_interval_create_from_date_string($dateDurationAndType));
	$firstDayPreviousMonth1=date_format($orignalPenaltyDate,"Y-m-d");
	if($duration_type=="months"){
	$firstDayPreviousMonth2=date("Y-m",strtotime($firstDayPreviousMonth1));
	$firstDayPreviousMonth=$firstDayPreviousMonth2."-01";	
	}else{
	$firstDayPreviousMonth=date_format($orignalPenaltyDate,"Y-m-d");
	}
    $checkMonth=$firstDayPreviousMonth2;
	$checkCurrentMonth=date("Y-m",strtotime($todate));
	$resultsCheck=\frontend\modules\repayment\models\LoanRepayment::checkPaymentsEmployerAcruePenalty($employerID,$checkMonth,$loan_given_to);
	                if($resultsCheck==0){
					$penaltyCountCheckAcruedExist=self::checklastPenaltyEmployerAcrued($employerID,$penaltyDateOrgn,$checkCurrentMonth);
					if($penaltyCountCheckAcruedExist ==0){
	                Yii::$app->db->createCommand()
					->insert('employer_penalty', [
					'employer_id' =>$employerID,
					'amount' =>$penaltyAmount,
					'penalty_date' =>$penaltyDateOrgn,
					'created_at' =>$createdat,
                    'loan_summary_id' =>$loan_summary_id,
                    'employer_penalty_cycle_id'=>$employer_penalty_cycle_id,
                    'level'=>'2',	
                    'penalty_id'=>$penaltyID,					
					])->execute();
	
	}
	}
	}
	}
	 }
	 return true;
	 }
	 public static function getPenaltyToEmployer($loan_given_to){
	
	//check employer has active loan summary
	$todate=date("Y-m-d");
	$yeaAndMonth=date("Y-m");
	
	$getDeadlineDay=Yii::$app->params['deadlineDayForEmployerPenaltyEachMonth'];
	$yearandmonthCurrent=date("Y-m",strtotime($todate));
	$CurrentdeadlineDateOfMonth=$yearandmonthCurrent."-".$getDeadlineDay;	
	if($todate > $CurrentdeadlineDateOfMonth){
	
	
	$loanSummaryDetailsEmployer = \frontend\modules\repayment\models\LoanSummary::employerDetailsForPenalty($loan_given_to);
	if((count($loanSummaryDetailsEmployer) > 0)){
    foreach ($loanSummaryDetailsEmployer as $loanSummaryDetailsResults) {
    $employerID=$loanSummaryDetailsResults->employer_id; 
    $employer_type_id=$loanSummaryDetailsResults->employer->employer_type_id;					
	$loan_summary_id=$loanSummaryDetailsResults->loan_summary_id;
	$dateLoanSummaryCreated=date("Y-m-d",strtotime($loanSummaryDetailsResults->created_at));
	//get total days since the loan summary created
	$LoanSummaryCreatedAt = date_create($dateLoanSummaryCreated);
	$todateCheckLoanSummary = date_create($todate);
	$interval = date_diff($LoanSummaryCreatedAt, $todateCheckLoanSummary);
	$totalDaysSinceLoanSummaryCreated=$interval->format('%a');
	$totalgraceDaysForNewEmployerTostartRepayment=Yii::$app->params['daysSinceLoanSummaryCreatedCheck'];
	//end
	if($totalDaysSinceLoanSummaryCreated > $totalgraceDaysForNewEmployerTostartRepayment){	
					//check employer special case in penalty
	$resultsSpecifcEmplPNT=\backend\modules\repayment\models\EmployedBeneficiary::getEmployerMontlyPenaltySpecificEmployer($employerID);
	if(count($resultsSpecifcEmplPNT) > 0){
	$percent=$resultsSpecifcEmplPNT->penalty;
	$employer_penalty_cycle_id=$resultsSpecifcEmplPNT->employer_penalty_cycle_id;
	$payment_deadline_day_per_month=$resultsSpecifcEmplPNT->payment_deadline_day_per_month;//this is used as  repayment_deadline_day
	$duration=$resultsSpecifcEmplPNT->duration;
	$duration_type1=$resultsSpecifcEmplPNT->duration_type;
	if($duration_type1=='d'){$duration_type="days";}else if($duration_type1=='w'){$duration_type="weeks";}else if($duration_type1=='m'){$duration_type="months";}else if($duration_type1=='y'){$duration_type="years";}
	$deadlineDateOfMonth=$yeaAndMonth."-".$payment_deadline_day_per_month;
	$penaltyDate=$yeaAndMonth."-".$payment_deadline_day_per_month;	
					}else{
	$resultsEmplBeneficiary=\backend\modules\repayment\models\EmployedBeneficiary::getEmployerMontlyPenaltyRate();
	$percent=$resultsEmplBeneficiary->penalty;
	$employer_penalty_cycle_id=$resultsEmplBeneficiary->employer_penalty_cycle_id;
    $payment_deadline_day_per_month=$resultsEmplBeneficiary->payment_deadline_day_per_month;//this is used as  repayment_deadline_day
	$duration=$resultsEmplBeneficiary->duration;
	$duration_type1=$resultsEmplBeneficiary->duration_type;
	if($duration_type1=='d'){$duration_type="days";}else if($duration_type1=='w'){$duration_type="weeks";}else if($duration_type1=='m'){$duration_type="months";}else if($duration_type1=='y'){$duration_type="years";}
	$deadlineDateOfMonth=$yeaAndMonth."-".$payment_deadline_day_per_month;
	$penaltyDate=$yeaAndMonth."-".$payment_deadline_day_per_month;	
	}
	//end check	
	//$dateToCheck=$payment_deadline_day_per_month + 1;
	$checkingDate=$yeaAndMonth."-".$payment_deadline_day_per_month;
	
    if($todate > $checkingDate){
	$todate=date("Y-m-d");
	$dateCreated=date_create($todate);
	$dateDurationAndType=$duration." ".$duration_type;
	date_sub($dateCreated,date_interval_create_from_date_string($dateDurationAndType));
	$firstDayPreviousMonth1=date_format($dateCreated,"Y-m-d");
	if($duration_type=="months"){
	$firstDayPreviousMonth2=date("Y-m",strtotime($firstDayPreviousMonth1));
	$firstDayPreviousMonth=$firstDayPreviousMonth2."-01";	
	}else{
	$firstDayPreviousMonth=date_format($dateCreated,"Y-m-d");	
	}
	
	
	$resultsLoanRepaymentCheck=\frontend\modules\repayment\models\LoanRepayment::checkPaymentsEmployer($employerID,$firstDayPreviousMonth,$deadlineDateOfMonth,$loan_given_to);
	if($resultsLoanRepaymentCheck == 0){
					$penaltyCountCheck=self::checklastPenaltyEmployer($employerID,$penaltyDate);
					if($penaltyCountCheck==0){
				    $amount=EmployerPenaltyPayment::getAmountRequiredForMonthlyPaymentToEmployedBeneficiaryPerEmployer($employerID,$loan_summary_id,$loan_given_to);		
                    if($percent !='' OR $percent > 0){
					$penaltyAmount=$amount * $percent;
					}else{
					$penaltyAmount=0;
					}
                    $createdat=date("Y-m-d H:i:s");	
					if($duration_type=="months"){						
						for($count=0;$count < $duration; ++$count){
							$penaltyDatertr=$yeaAndMonth."-".$payment_deadline_day_per_month;
						$dateCreatedqq=date_create($penaltyDatertr);
						$dateDurationAndTypeqq=$count." ".$duration_type;
						date_sub($dateCreatedqq,date_interval_create_from_date_string($dateDurationAndTypeqq));
						$penaltyDate=date_format($dateCreatedqq,"Y-m-d");				
					
					$penaltyCountCheck=self::checklastPenaltyEmployer($employerID,$penaltyDate);
					if($penaltyCountCheck==0){
					    Yii::$app->db->createCommand()
					->insert('employer_penalty', [
					'employer_id' =>$employerID,
					'amount' =>$penaltyAmount,
					'penalty_date' =>$penaltyDate,
					'created_at' =>$createdat,
                    'loan_summary_id' =>$loan_summary_id,
                    'employer_penalty_cycle_id'=>$employer_penalty_cycle_id,
                    'level'=>'1',					
					])->execute();
						}
						}
					}else{									
					Yii::$app->db->createCommand()
					->insert('employer_penalty', [
					'employer_id' =>$employerID,
					'amount' =>$penaltyAmount,
					'penalty_date' =>$penaltyDate,
					'created_at' =>$createdat,
                    'loan_summary_id' =>$loan_summary_id,
                    'employer_penalty_cycle_id'=>$employer_penalty_cycle_id,
                    'level'=>'1',					
					])->execute();	
					}
					
					
					
					 /*Automatic bill
					if($duration_type=="months"){						
						for($count=0;$count < $duration; ++$count){
							$penaltyDatertr=$yeaAndMonth."-".$payment_deadline_day_per_month;
						$dateCreatedqq=date_create($penaltyDatertr);
						$dateDurationAndTypeqq=$count." ".$duration_type;
						date_sub($dateCreatedqq,date_interval_create_from_date_string($dateDurationAndTypeqq));
						$penaltyDate=date_format($dateCreatedqq,"Y-m-d");				
					\frontend\modules\repayment\models\LoanRepayment::createAutomaticBills($penaltyDate,$employerID);
						}
					}
					*/
                    }					
					}
	}
	}
	}
	 }
	 }
	 return true;
	 }
	 public static function getAmountRequiredForMonthlyPaymentToEmployedBeneficiaryPerEmployer($employerID,$loan_summary_id,$loan_given_to){	 
	 $details_applicant = EmployedBeneficiary::findBySql("SELECT  basic_salary,applicant_id  FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST' AND verification_status='1' AND salary_source IN(2,3)")->all();
        $moder=new EmployedBeneficiary();
		$MLREB=$moder->getEmployedBeneficiaryPaymentSetting();
        $totalAmount=0;        
        foreach ($details_applicant as $paymentCalculation) { 
           $applicantID=$paymentCalculation->applicant_id;
           $amount1=$MLREB*$paymentCalculation->basic_salary;           
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id,$loan_given_to);
           if($totalOutstandingAmount >= $amount1){
              $amount=$amount1;  
           }else{
              $amount=$totalOutstandingAmount;  
           }
        $totalAmount +=$amount;		   
	 }
	 return $totalAmount;
	
}

    public static function checkIfPenaltyExists($employerID,$loan_summary_id,$penaltyDate){	 
	 $details_penalty = EmployerPenalty::findBySql("SELECT  employer_penalty_id   FROM  employer_penalty WHERE  employer_penalty.employer_id='$employerID' AND employer_penalty.loan_summary_id='$loan_summary_id' AND employer_penalty.penalty_date='$penaltyDate'")->one();
        if($details_penalty->employer_penalty_id > 0){
		$employer_penaltyID=1;
		}else{
		$employer_penaltyID=0;
		}
	 return $employer_penaltyID;
	
}
    public static function getTotalPenaltyAmount($employerID){	 
	 $penaltyAmount = EmployerPenalty::findBySql("SELECT  SUM(amount) AS 'amount'  FROM  employer_penalty WHERE  employer_penalty.employer_id='$employerID' AND employer_penalty.is_active='1'")->one();
     if($penaltyAmount->amount > 0){
	$amount=$penaltyAmount->amount;	 
	 }else{
	$amount=0; 
	 }	 
	 return $amount;
}
    public static function getTotalPenaltyAmountPaid($employerID){	 
	 $penaltyAmountPaid = EmployerPenaltyPayment::findBySql("SELECT  SUM(amount) AS 'amount'  FROM  employer_penalty_payment WHERE  employer_penalty_payment.employer_id='$employerID' AND payment_status='1'")->one(); 
     if($penaltyAmountPaid->amount > 0){
	$amount=$penaltyAmountPaid->amount;	 
	 }else{
	$amount=0; 
	 }		 
	 return $amount;
	
}

public static function getAmountPendingPaymentPNTNotConfirmed($employerID){
	$paidAmount=\frontend\modules\repayment\models\EmployerPenaltyPayment::findBySql("SELECT  SUM(amount) AS 'amount'  FROM  employer_penalty_payment WHERE  employer_penalty_payment.employer_id='$employerID' AND (payment_status IS NULL OR payment_status='')")->one();
	if($paidAmount->amount > 0){
	$amount=$paidAmount->amount;	 
	 }else{
	$amount=0; 
	 }
	return $amount;
}
public static function checklastPenaltyEmployer($employerID,$penaltyDate){
	$penaltyCheckCount=EmployerPenalty::findBySql("SELECT  *  FROM  employer_penalty WHERE  employer_id='$employerID' AND penalty_date='$penaltyDate' AND level='1'")->count();
    return $penaltyCheckCount;
}
public static function checklastPenaltyEmployerAcrued($employerID,$penaltyDate,$checkCurrentMonth){
	$penaltyCheckCount=EmployerPenalty::findBySql("SELECT  *  FROM  employer_penalty WHERE  employer_id='$employerID' AND penalty_date='$penaltyDate' AND level='2' AND created_at like '$checkCurrentMonth%'")->count();
    return $penaltyCheckCount;
}
public static function getAmountTobePaidemployedBeneficiary($loan_summary_id,$applicantID,$loan_given_to){	 
	 $details_applicant = EmployedBeneficiary::findBySql("SELECT  basic_salary,applicant_id  FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND applicant_id='$applicantID' AND employment_status='ONPOST' AND verification_status='1' AND salary_source IN(2,3)")->one();
        $moder=new EmployedBeneficiary();
		$MLREB=$moder->getEmployedBeneficiaryPaymentSetting();
        $totalAmount=0; 
           $applicantID=$details_applicant->applicant_id;
           $amount1=$MLREB*$details_applicant->basic_salary;           
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id,$loan_given_to);
           if($totalOutstandingAmount >= $amount1){
              $amount=$amount1;  
           }else{
              $amount=$totalOutstandingAmount;  
           }
        $totalAmount +=$amount;		   
	 return $totalAmount;
}
public static function getEmployerPenaltyDetails($employer_penalty_payment_id){
        $details = self::findBySql("SELECT  employer_penalty_payment.bill_number,employer_penalty_payment.amount,employer.employer_code,employer.employer_name,employer_penalty_payment.date_control_requested,employer.phone_number  FROM employer_penalty_payment INNER JOIN employer ON employer_penalty_payment.employer_id=employer.employer_id  WHERE  employer_penalty_payment.employer_penalty_payment_id='$employer_penalty_payment_id'")->one();

		if(count($details) > 0){
    $dataToQueue = [
        "bill_number" => $details->bill_number,
        "amount"=>$details->amount,
        "bill_type"=>\frontend\modules\repayment\models\LoanRepayment::EMPLOYER_PENALTY_GFSCODE,
        "bill_description"=>\frontend\modules\repayment\models\LoanRepayment::EMPLOYER_PENALTY_BILL_DESC,
        "bill_gen_date"=>date('Y-m-d' . '\T' . 'H:i:s',strtotime($details->date_control_requested)),
        "bill_gernerated_by"=>$details->employer_name,
        "bill_payer_id"=>$details->employer_code,
        "payer_name"=>$details->employer_name,
        "payer_phone_number"=>$details->phone_number,
        "bill_expiry_date"=>\frontend\modules\repayment\models\LoanRepayment::BILL_EXPIRE_DATE_EMPLOYER_PENALTY,
        "bill_reference_table_id"=>$employer_penalty_payment_id,
        "bill_reference_table"=>"employer_penalty_payment",
		"primary_keycolumn"=>"employer_penalty_payment_id",
    ];

        return $dataToQueue;
		}else{
		return '';	
		}
}
public static function getBillPenaltyEmployer($employerID,$year){
	return self::findBySql("SELECT * FROM employer_penalty_payment WHERE  payment_date LIKE '$year%' AND employer_id='$employerID'")->count();
}
public static function updateControlngepgrealy($control_number,$bill_number,$date_control_received){	
        self::updateAll(['date_control_received'=>$date_control_received,'control_number'=>$control_number,'payment_status'=>0], 'bill_number ="'.$bill_number.'" AND (control_number="" OR control_number IS NULL)');        
    }
public static function updatePaymentAfterGePGconfirmPaymentDonepenaltylive($controlNumber,$paid_amount,$date_receipt_received,$receiptDate,$receiptNumber){
        self::updateAll(['payment_status' =>'1','receipt_date'=>$receiptDate,'date_receipt_received'=>$date_receipt_received,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND payment_status ="0"');

    }
}
