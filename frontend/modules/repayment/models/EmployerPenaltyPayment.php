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
    public function rules()
    {
        return [
            //[['employer_id', 'amount', 'payment_date', 'created_at'], 'required'],
			[['cancel_reason'], 'required','on'=>'Cancell_employer_penalty'],
            [['employer_id'], 'integer'],
            [['amount'], 'number', 'min' => 1000],		
            //['age', 'integer', 'min' => 0],			
            [['payment_date', 'created_at','control_number','receipt_number','pay_method_id','date_control_requested','date_control_received','date_receipt_received','payment_status','totalAmount','outstandingAmount','paidAmount','employer_id', 'amount',], 'safe'],
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
	 public static function getAmountRequiredForMonthlyPaymentToEmployedBeneficiaryPerEmployer($employerID,$loan_summary_id){	 
	 $details_applicant = EmployedBeneficiary::findBySql("SELECT  basic_salary,applicant_id  FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST' AND verification_status='1'")->all();
        $moder=new EmployedBeneficiary();
		$MLREB=$moder->getEmployedBeneficiaryPaymentSetting();
        $totalAmount=0;        
        foreach ($details_applicant as $paymentCalculation) { 
           $applicantID=$paymentCalculation->applicant_id;
           $amount1=$MLREB*$paymentCalculation->basic_salary;           
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
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
	 $penaltyAmount = EmployerPenalty::findBySql("SELECT  SUM(amount) AS 'amount'  FROM  employer_penalty WHERE  employer_penalty.employer_id='$employerID'")->one();        
	 return $penaltyAmount->amount;
	
}
    public static function getTotalPenaltyAmountPaid($employerID){	 
	 $penaltyAmountPaid = EmployerPenaltyPayment::findBySql("SELECT  SUM(amount) AS 'amount'  FROM  employer_penalty_payment WHERE  employer_penalty_payment.employer_id='$employerID' AND payment_status='1'")->one();        
	 return $penaltyAmountPaid->amount;
	
}
}
