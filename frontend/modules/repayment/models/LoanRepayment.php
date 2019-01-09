<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use backend\modules\repayment\models\PayMethod;
use frontend\modules\repayment\models\LoanRepayment;
use frontend\modules\repayment\models\LoanRepaymentDetailSearch;
use frontend\modules\repayment\models\LoanRepaymentPrepaid;
use frontend\modules\repayment\models\EmployerPenaltyPayment;

/**
 * This is the model class for table "loan_repayment".
 *
 * @property integer $loan_repayment_id
 * @property integer $employer_id
 * @property integer $applicant_id
 * @property string $bill_number
 * @property string $control_number
 * @property double $amount
 * @property string $receipt_number
 * @property integer $pay_method_id
 * @property string $pay_phone_number
 * @property string $date_bill_generated
 * @property string $date_control_received
 * @property string $date_receipt_received
 *
 * @property Applicant $applicant
 * @property Employer $employer
 * @property PayMethod $payMethod
 * @property LoanRepaymentDetail[] $LoanRepaymentDetails
 */
class LoanRepayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 const DEDUCTION_DATE_REQUEST=26;
	 const TREAURY_BILL_FORMAT="TRES";
	 
    public static function tableName()
    {
        return 'loan_repayment';
    }

    /**
     * @inheritdoc
     */
    public $totalEmployees;
    public $amountApplicant;
    public $total_loan;
    public $amount_paid;
    public $balance;
    public $f4indexno;
    public $principal;
    public $penalty;
    public $LAF;
    public $vrf;
    public $totalLoan;
    public $outstandingDebt;
    public $repaymentID;
    public $loan_summary_id;
    public $amountx;
    public $print;
    public $employerId_bulk;
	public $salarySource;
	public $outstandingAmount;
	public $payment_date2;
	public $payCategory;

    public function rules()
    {
        return [
            [['employer_id', 'applicant_id', 'pay_method_id'], 'integer'],
            [['amount','repaymentID'], 'required','on'=>'paymentAdjustmentLoanee'],
            [['amount'], 'number','on'=>'paymentAdjustmentLoanee'],
	    [['payment_date'], 'required','on'=>'billGeneration'],
		[['control_number','amount','payCategory'], 'required','on'=>'gepgPayment'],
            [['employerId_bulk'], 'required','on'=>'bulkBillTreasury'],
            [['payment_date'], 'required','on'=>'billConfirmationTreasury'],
			[['payment_date'], 'required','on'=>'gspp_monthly_deduction_request'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received','totalEmployees','payment_status','amount', 'pay_method_id', 'amountApplicant', 'total_loan', 'amount_paid', 'balance','f4indexno','principal','penalty','LAF','vrf','totalLoan','outstandingDebt','repaymentID','loan_summary_id','amountx','payment_date','print','treasury_user_id','employerId_bulk','salarySource','receipt_date','vote_number','Vote_name','gepg_lawson_id','lowason_check_date'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
            [['pay_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\PayMethod::className(), 'targetAttribute' => ['pay_method_id' => 'pay_method_id']],
            [['treasury_payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanRepayment::className(), 'targetAttribute' => ['treasury_payment_id' => 'loan_repayment_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employerId_bulk'=>'Employer Bill',
            'loan_repayment_id' => 'Employer Bill',
            'employer_id' => 'Employer',
            'applicant_id' => 'Applicant ID',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'amount' => 'Amount',
            'receipt_number' => 'Receipt Number',
            'pay_method_id' => 'Pay Method ID',
            'pay_phone_number' => 'Pay Phone Number',
            'date_bill_generated' => 'Date Bill Generated',
            'date_control_received' => 'Date Control Received',
            'date_receipt_received' => 'Date Receipt Received',
            'totalEmployees'=>'Total Employees',
            'payment_status'=>'Payment Status',
            'amountApplicant'=>'Amount(TZS)',
            'total_loan'=>'Total Loan(TZS)',
            'amount_paid'=>'Total Amount Paid(TZS)',
            'balance'=>'Total Balance(TZS)',
			'principal'=>'Principal Amount',
            'penalty'=>'Penalty',
            'LAF'=>'Loan Adm. Fee',
            'vrf'=>'Value Retention Fee',
            'totalLoan'=>'Total Loan Amount',
            'outstandingDebt'=>'Outstanding Debt',
			'repaymentID'=>'Repayment ID',
			'loan_summary_id'=>'Loan Summary ID',
			'amountx'=>'Amount',
			'payment_date'=>'Month',
            'print'=>'Print',
			'payCategory'=>'Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant()
    {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayMethod()
    {
        return $this->hasOne(\backend\modules\repayment\models\PayMethod::className(), ['pay_method_id' => 'pay_method_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentDetails()
    {
        return $this->hasMany(LoanRepaymentDetail::className(), ['loan_repayment_id' => 'loan_repayment_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreasuryPayment()
    {
        return $this->hasOne(LoanRepayment::className(), ['loan_repayment_id' => 'treasury_payment_id']);
    }
    public function checkControlNumberStatus($employerID,$loan_given_to){
        $existPendingControlNumber = $this->findBySql("SELECT loan_repayment.loan_repayment_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id"
                . " WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.employer_id='$employerID' AND loan_repayment_detail.loan_given_to='$loan_given_to'")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        }
    public function checkControlNumberStatusLoanee($applicantID){
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                . " WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.applicant_id='$applicantID'")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($existPendingControlNumber) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        } 
        
    public static function getPaymentMethod(){
        $results = PayMethod::findBySql("SELECT pay_method_id FROM pay_method "
                . "WHERE  method_desc='GePG'")->one();
        $pay_method_id=$results->pay_method_id; 
        $value = (count($pay_method_id) == 0) ? '0' : $pay_method_id;
        return $value;
        } 
        
    public function getAmountRequiredForPayment($loan_repayment_id,$loan_given_to){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 
       $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id' AND loan_repayment_detail.loan_given_to='$loan_given_to'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
		
		
    
    public function getAllEmployeesUnderBillunderEmployer($loan_repayment_id){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS);
        $totalLoanees =  LoanRepaymentDetail::findBySql("SELECT COUNT(DISTINCT applicant_id) AS 'totalLoanees' FROM loan_repayment_detail WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $totalLoanees_v=$totalLoanees->totalLoanees;
   
        $value = (count($totalLoanees_v) == 0) ? '0' : $totalLoanees_v;
        return $value;
        }
    public function updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id){
        $date=date("Y-m-d H:i:s");
        $this->updateAll(['bill_number' =>$repaymnet_reference_number,'amount'=>$totalAmount1,'date_bill_generated'=>$date], 'loan_repayment_id ="'.$loan_repayment_id.'"'); 
    }
	public static function updateTotalAmountPrepaid($totalAmount1,$loan_repayment_id){
        self::updateAll(['amount'=>$totalAmount1], 'loan_repayment_id ="'.$loan_repayment_id.'"'); 
    }
	public static function updateMonthlyDeductionStatus($payment_date,$employer_id){
		$date=date("Y-m-d H:i:s");
        LoanRepaymentPrepaid::updateAll(['monthly_deduction_status'=>1,'date_deducted'=>$date], 'payment_date="'.$payment_date.'" AND employer_id="'.$employer_id.'"'); 
    }
    public function updateConfirmPaymentandControlNo($loan_repayment_id,$controlNumber){
        //$date=date("Y-m-d H:i:s");
		if($controlNumber !=''){
		$date=date("Y-m-d H:i:s");
        $paymentStatus=0;		
		}else{
		$date=null;	
		$paymentStatus=null;
		}
     $this->updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>$paymentStatus], 'loan_repayment_id ="'.$loan_repayment_id.'" AND (control_number="" OR control_number IS NULL)');       
        }
        // used twice
    public function getLoanRepayment($loan_repayment_id){
        $batchDetails = $this->findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.loan_repayment_id='$loan_repayment_id'")->one();
        $details=$batchDetails->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $batchDetails;
        return $value;
        }
    public function checkWaitingConfirmationFromGePG($employerID){
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status='0' AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.employer_id='$employerID'")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        }
    public function checkWaitingConfirmationFromGePGLoanee($applicantID){
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status='0' AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.applicant_id='$applicantID'")->one();
        //$value = (count($details) == 0) ? '0' : $existPendingControlNumber;
		if(count($existPendingControlNumber)>0){
		$details=$existPendingControlNumber->loan_repayment_id; 
		}else{
		$details=0;
		}
        return $details;
        }
    public function getDataUnderLoanRepaymentId($employerID){
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                . "WHERE  (loan_repayment.payment_status='0' OR loan_repayment.payment_status IS NULL OR loan_repayment.payment_status='1') AND loan_repayment.employer_id='$employerID' ORDER BY loan_repayment_id DESC")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        } 
    public function getDataUnderLoanRepaymentIdLoanee($applicantID){
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                . "WHERE  (loan_repayment.payment_status='0' OR loan_repayment.payment_status IS NULL OR loan_repayment.payment_status='1') AND loan_repayment.applicant_id='$applicantID' ORDER BY loan_repayment_id DESC")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        }    
    public function updatePaymentAfterGePGconfirmPaymentDone($controlNumber,$amount){
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
		$model=new LoanSummary();
		$date_control_received=date("Y-m-d H:i:s");
		$receiptDate=date("Y-m-d H:i:s");
		$receiptNumber=rand(100,1000);
		
		//here to update the acrued VRF from last payment after payment confirmed
		$detailsAllApplicantVRF = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id',loan_repayment_detail.applicant_id,loan_repayment_detail.loan_repayment_id,loan_repayment_detail.loan_repayment_item_id,loan_repayment.receipt_date  FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber' GROUP BY loan_repayment_detail.applicant_id ORDER BY loan_repayment_detail.loan_repayment_detail_id DESC")->all();
				foreach($detailsAllApplicantVRF AS $resultsAppvrf){
        $loan_summary_id=$resultsAppvrf->loan_summary_id;
		$applicantID=$resultsAppvrf->applicant_id;
		$loanRepaymentId=$resultsAppvrf->loan_repayment_id;
		$loan_repayment_item_id=$resultsAppvrf->loan_repayment_item_id;
		$Currentpayment_date=date("Y-m-d",strtotime($receiptDate));
		//check if there is any payment before
		if (LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.amount FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.payment_status='1'")->exists()) {					
					$detailsww = LoanRepaymentDetail::findBySql("SELECT loan_repayment.receipt_date FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.payment_status='1' ORDER BY loan_repayment.loan_repayment_id DESC")->one();
				$Previousrepayment_date=date("Y-m-d",strtotime($detailsww->receipt_date));			
                \frontend\modules\repayment\models\LoanRepaymentDetail::updateAcruedVRFToBeneficiaryOnEveryPayment($loan_summary_id,$applicantID,$loan_given_to,$loanRepaymentId,$Currentpayment_date,$Previousrepayment_date);
		}
		//end check
		
	}
		//end
		
		
        
        //$this->updateAll(['payment_status' =>'1','date_control_received'=>$date_control_received,'receipt_date'=>$receiptDate,'date_receipt_received'=>$receiptDate,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND amount ="'.$amount.'" AND payment_status ="0"');
		$this->updateAll(['payment_status' =>'1','date_control_received'=>$date_control_received,'receipt_date'=>$receiptDate,'date_receipt_received'=>$receiptDate,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND payment_status ="0"');
        $details = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id',loan_repayment_detail.applicant_id,loan_repayment_detail.loan_repayment_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber'")->one();
        $loan_summary_id=$details->loan_summary_id;
        $model->updateAll(['status' =>'1'], 'loan_summary_id ="'.$loan_summary_id.'" AND status<>2 AND status<>5 AND status<>4');
		
		//here to update the loan balance after payment confirmed
		$detailsAllApplicants = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id',loan_repayment_detail.applicant_id,loan_repayment_detail.loan_repayment_id,loan_repayment_detail.loan_repayment_item_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber' GROUP BY loan_repayment_detail.applicant_id ORDER BY loan_repayment_detail.loan_repayment_detail_id DESC")->all();
				foreach($detailsAllApplicants AS $resultsApp){
        $loan_summary_id=$resultsApp->loan_summary_id;
		$applicantID=$resultsApp->applicant_id;
		$loanRepaymentId=$resultsApp->loan_repayment_id;
		$loan_repayment_item_id=$resultsApp->loan_repayment_item_id;
		\frontend\modules\repayment\models\LoanRepaymentDetail::updateLoanBalanceToBeneficiaryAfterEveryPayment($loan_summary_id,$applicantID,$loan_given_to,$loanRepaymentId,$loan_repayment_item_id);
		
		$loanPaidExistsCount=LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_repayment_id,loan_repayment_detail.amount FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.payment_status='1' GROUP BY loan_repayment_detail.applicant_id")->count();
		if($loanPaidExistsCount== 1){
		\frontend\modules\repayment\models\LoanRepaymentDetail::updateVRFBeforeRepayment($loan_summary_id,$applicantID,$loan_given_to);
				}
	}
		//end
 }
public function updatePaymentAfterGePGconfirmPaymentEmployerPenalty($controlNumber,$amount){
		$date_control_received=date("Y-m-d H:i:s");
		$receiptDate=date("Y-m-d H:i:s");
		$receiptNumber=rand(100,1000);
        EmployerPenaltyPayment::updateAll(['payment_status' =>'1','date_control_received'=>$date_control_received,'receipt_date'=>$receiptDate,'date_receipt_received'=>$receiptDate,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND amount ="'.$amount.'" AND payment_status ="0"');
 }
public function updatePaymentAfterGePGconfirmPaymentEmployerPrepaid($controlNumber,$amount){
		$date_control_received=date("Y-m-d H:i:s");
		$receiptDate=date("Y-m-d H:i:s");
		$receiptNumber=rand(100,1000);
        LoanRepaymentPrepaid::updateAll(['payment_status' =>'1','date_control_received'=>$date_control_received,'receipt_date'=>$receiptDate,'date_receipt_received'=>$receiptDate,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND payment_status ="0"');
 } 
 public function getTotalAmountPaidLoaneeUnderTransaction($loan_repayment_id){
        $model=new EmployerSearch();
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS);
        $loggedin=Yii::$app->user->identity->user_id;
        $loggeninApplicant=$model->getApplicant($loggedin);
        $applicantID=$loggeninApplicant->applicant_id;
        
        $total =  LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount FROM loan_repayment_detail "
                . "WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $totalAmount=$total->amount;
        if($totalAmount >0 ){
        $value=$totalAmount;    
        }else{
        $value=0;    
        }
   
        //$value = (count($totalAmount) == 0) ? '0' : $totalAmount;
        return $value;
        }
        
    public function updateLoaneeAdjustedPaymentAmount($totalAmount1,$loan_repayment_id){
        $date=date("Y-m-d H:i:s");
        $this->updateAll(['amount'=>$totalAmount1], 'loan_repayment_id ="'.$loan_repayment_id.'"'); 
    }
	public function updateNewTotaAmountAfterPaymentAdjustment($totalAmount1,$loan_repayment_id){
        LoanRepayment::updateAll(['amount'=>$totalAmount1], 'loan_repayment_id ="'.$loan_repayment_id.'"'); 
    }
	public function resetTheOldAmountOnPaymentAdjustmentAccepted($loan_repayment_id,$applicantID){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 		
		LoanRepaymentDetail::updateAll(['amount'=>'0'], 'loan_repayment_id ="'.$loan_repayment_id.'" AND applicant_id="'.$applicantID.'" AND loan_repayment_item_id<>"'.$CFBS_id.'"');
        }
	public function getAmountRequiredForPaymentSelfBeneficiary($loan_repayment_id,$applicantID){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 
       $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id' AND applicant_id='$applicantID'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
	public static function getDetailsUsingRepaymentID($loan_repayment_id){ 
       $details = LoanRepaymentDetail::findBySql("SELECT * FROM loan_repayment_detail  WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id'")->one();
        return $details;
        }
	public function checkUnCompleteBill($applicantID){
        $existIncompleteBill = LoanRepayment::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.applicant_id='$applicantID'")->one();
		if(count($existIncompleteBill)>0){
		$details=$existIncompleteBill; 
		}else{
		$details=0;
		}
        return $details;
        }
    public function checkUnCompleteBillEmployer($employerID){
        $existIncompleteBill = LoanRepayment::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.employer_id='$employerID'")->one();
		if(count($existIncompleteBill)>0){
		$details=$existIncompleteBill; 
		}else{
		$details=0;
		}
        return $details;
        }
        
    public static function checkBillPendingGovernmentEmployers(){
        $existPendingControlNumber = LoanRepayment::findBySql("SELECT loan_repayment.loan_repayment_id AS loan_repayment_id FROM loan_repayment INNER JOIN employer ON loan_repayment.employer_id=employer.employer_id "
                . "WHERE  (loan_repayment.control_number IS NULL OR loan_repayment.control_number='') AND loan_repayment.payment_status='0' AND employer.salary_source='1'")->one();
		if(count($existPendingControlNumber)>0){
		$results=1;
		}else{
		$results=0;
		}	
        return $results;
        }
     public static function checkUnCompleteBillTreasury(){
        $existIncompleteBill = LoanRepayment::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.employer_id IS NULL AND loan_repayment.applicant_id IS NULL")->one();
		if(count($existIncompleteBill)>0){
		$details=$existIncompleteBill; 
		}else{
		$details=0;
		}
        return $details;
        }
    public static function checkControlNumberStatusTreasury(){
        $existPendingControlNumber = LoanRepayment::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.employer_id IS NULL AND loan_repayment.applicant_id IS NULL")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        }
    public static function getAmountRequiredForPaymentTreasury($treasury_payment_id){
       $details_amount = LoanRepayment::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_repayment  WHERE  loan_repayment.treasury_payment_id='$treasury_payment_id'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
    public function updateReferenceNumberTreasury($repaymnet_reference_number,$totalAmount1,$treasury_payment_id){
        $date=date("Y-m-d H:i:s");
        LoanRepayment::updateAll(['bill_number' =>$repaymnet_reference_number,'amount'=>$totalAmount1,'date_bill_generated'=>$date], 'loan_repayment_id ="'.$treasury_payment_id.'"'); 
    }
    public function updateConfirmPaymentandControlNoTreasury($treasury_payment_id,$controlNumber){
        $date=date("Y-m-d H:i:s");
     LoanRepayment::updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'loan_repayment_id ="'.$treasury_payment_id.'" AND (control_number="" OR control_number IS NULL)');  
      
	  $details_treasuryPayment = LoanRepayment::findBySql("SELECT * FROM loan_repayment WHERE  treasury_payment_id='$treasury_payment_id'")->all();
        
        foreach ($details_treasuryPayment as $paymentTreasuryDetails) { 
           $loan_repayment_id=$paymentTreasuryDetails->loan_repayment_id;           
      LoanRepayment::updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'loan_repayment_id ="'.$loan_repayment_id.'" AND (control_number="" OR control_number IS NULL)');
	  }
    }
    
    public function updatePaymentAfterGePGconfirmPaymentDoneTreasury($controlNumber,$amount){
        $model=new LoanSummary();
		$date_control_received=date("Y-m-d H:i:s");
                $receiptNumber="T898".mt_rand (10,100);
        LoanRepayment::updateAll(['payment_status' =>'1','date_receipt_received'=>$date_control_received,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND amount ="'.$amount.'" AND payment_status ="0"');
        //check if treasury payment is done successful
        $detailsBillStatus = LoanRepayment::findBySql("SELECT loan_repayment.payment_status AS 'payment_status',loan_repayment.loan_repayment_id AS 'loan_repayment_id' FROM loan_repayment WHERE  loan_repayment.control_number='$controlNumber' AND employer_id IS NULL AND applicant_id IS NULL")->one();
        $status=$detailsBillStatus->payment_status;
        $treasury_payment_id=$detailsBillStatus->loan_repayment_id;
        //end
        if($status==1){
            LoanRepayment::updateAll(['payment_status' =>'1','date_receipt_received'=>$date_control_received,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND treasury_payment_id="'.$treasury_payment_id.'" AND payment_status ="0"');
            
            
        $detailsLoanSummary = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id' FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber' AND loan_repayment.treasury_payment_id='$treasury_payment_id'")->all();
        foreach($detailsLoanSummary AS $loanSummaryD){
        $loan_summary_id=$loanSummaryD->loan_summary_id;
        $model->updateAll(['status' =>'1'], 'loan_summary_id ="'.$loan_summary_id.'" AND status<>2 AND status<>5');
        }
        }
 }
  
 public static function getSelectedBillsTreasuryPending() {
        $condition = ["payment_status" => '2','date_bill_generated'=>NULL];
        return self::find()
                        ->select("loan_repayment.loan_repayment_id AS loan_repayment_id")
                        ->where($condition)
                        ->one();
    }
public static function getReceiptDetails($loanRepaymentID){
    $condition = ["loan_repayment_id" =>$loanRepaymentID];
        return self::find()                        
                        ->where($condition)
                        ->one();
}
public function getAllEmployeesUnderBillunderTreasury($loan_repayment_id){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS);
        $totalLoanees =  LoanRepaymentDetail::findBySql("SELECT COUNT(DISTINCT applicant_id) AS 'totalLoanees' FROM loan_repayment_detail WHERE  loan_repayment_detail.treasury_payment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
        $totalLoanees_v=$totalLoanees->totalLoanees;
   
        $value = (count($totalLoanees_v) == 0) ? '0' : $totalLoanees_v;
        return $value;
        }
public static function checkPaymentsEmployer($employerID,$firstDayPreviousMonth,$deadlineDateOfMonth,$loan_given_to){
	$details =  LoanRepayment::findBySql("SELECT * FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id WHERE  employer_id='$employerID' AND payment_status='1' AND payment_date >='$firstDayPreviousMonth' AND payment_date <='$deadlineDateOfMonth' AND loan_repayment_detail.loan_given_to='$loan_given_to'")->count();
	return $details;
}
public static function checkPaymentsEmployerAcruePenalty($employerID,$checkMonth,$loan_given_to){
	$details =  LoanRepayment::findBySql("SELECT * FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id WHERE  employer_id='$employerID' AND loan_repayment_detail.loan_given_to='$loan_given_to' AND payment_status='1' AND payment_date like '%$checkMonth%'")->count();
	return $details;
}
public static function createAutomaticBills($payment_date,$employerID){
	        $modelLoanRepaymentDetail=new LoanRepaymentDetailSearch();
			$modelLoanRepayment = new LoanRepayment();
	        $ActiveBill=\frontend\modules\repayment\models\LoanSummary::getActiveBill($employerID);
            $billID=$ActiveBill->loan_summary_id;
            $loan_summary_id=$billID;
			$modelLoanRepayment->amount=0;
			$modelLoanRepayment->employer_id=$employerID;
			$modelLoanRepayment->payment_date=$payment_date;
			$modelLoanRepayment->save();
			$employerDetails=\frontend\modules\repayment\models\Employer::findOne($employerID);
            //$totalAmount1=$model2->getAmountRequiredForPayment($loan_summary_id);          
            $repaymnet_reference_number=$employerDetails->employer_code."-".$modelLoanRepayment->loan_repayment_id;
            $loan_repayment_id=$modelLoanRepayment->loan_repayment_id;
            //$model2->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$controlNumber);
            $salarySource==2;
			$modelLoanRepaymentDetail->insertAllPaymentsofAllLoaneesUnderBillSalarySourceBases($loan_summary_id,$loan_repayment_id,$salarySource);

            $totalAmount1=$modelLoanRepayment->getAmountRequiredForPayment($loan_repayment_id);
            $modelLoanRepayment->updateReferenceNumber($repaymnet_reference_number,$totalAmount1,$loan_repayment_id);
			
			return true;
}
public static function getAmountRequiredForMonthlyRepaymentBeneficiary($employerID,$loan_summary_id,$bill_number,$created_by,$payment_date,$totalMonths,$created_at){
$amountPTotal=0;
$amountPTotalAccumulated=0;	
	 $details_applicant = EmployedBeneficiary::findBySql("SELECT  basic_salary,applicant_id  FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST' AND employed_beneficiary.employer_id='$employerID' AND verification_status='1' AND salary_source IN(2,3)")->all();
        $moder=new EmployedBeneficiary();
		$MLREB=$moder->getEmployedBeneficiaryPaymentSetting();
        $totalAmount=0; 
        $yeaAndMonth=date("Y-m",strtotime($payment_date));
        $duration_type="months";		
        foreach ($details_applicant as $paymentCalculation) { 
           $applicantID=$paymentCalculation->applicant_id;
           $amount1=$MLREB*$paymentCalculation->basic_salary; 
           $TotalAmountUnderRange=$amount1 * $totalMonths;			   
           $totalOutstandingAmount=$moder->getIndividualEmployeeTotalLoanUnderBill($applicantID,$loan_summary_id);
		   if($totalOutstandingAmount >= $TotalAmountUnderRange){
			   $countForPaymentDate=0;
           for($count=1;$count <= $totalMonths; ++$count){
			   //get payment date
			    $dateConstantForPayment=$yeaAndMonth."-10";
				$dateCreatedqq=date_create($dateConstantForPayment);
				$dateDurationAndTypeqq=$countForPaymentDate." ".$duration_type;
				date_add($dateCreatedqq,date_interval_create_from_date_string($dateDurationAndTypeqq));
				$payment_date=date_format($dateCreatedqq,"Y-m-d");
				//end			   
			self::insertprepaidAmount($employerID,$applicantID,$loan_summary_id,$amount1,$created_by,$bill_number,$payment_date,$created_at);
			++$countForPaymentDate;
		}
		}else{
			$countForPaymentDate=0;
        for($countP=1;$countP <= $totalMonths; ++$countP){
			$amountPTotal +=$amount1;
			if($totalOutstandingAmount >= $amountPTotal){
			//get payment date
			    $dateConstantForPayment=$yeaAndMonth."-10";
				$dateCreatedqq=date_create($dateConstantForPayment);
				$dateDurationAndTypeqq=$countForPaymentDate." ".$duration_type;
				date_add($dateCreatedqq,date_interval_create_from_date_string($dateDurationAndTypeqq));
				$payment_date=date_format($dateCreatedqq,"Y-m-d");
				//end	
			self::insertprepaidAmount($employerID,$applicantID,$loan_summary_id,$amount1,$created_by,$bill_number,$payment_date,$created_at);
			$amountPTotalAccumulated=$amountPTotal;
			$payment_dateLast=$payment_date;
			}
			++$countForPaymentDate;
		}
        $OverallBalance=$totalOutstandingAmount-$amountPTotalAccumulated;
        if($OverallBalance > 0){
			    //get payment date
			    $dateConstantForPayment=$payment_dateLast;
				$dateCreatedqq=date_create($dateConstantForPayment);
				$dateDurationAndTypeqq="1"." ".$duration_type;
				date_add($dateCreatedqq,date_interval_create_from_date_string($dateDurationAndTypeqq));
				$payment_date=date_format($dateCreatedqq,"Y-m-d");
				//end			
        self::insertprepaidAmount($employerID,$applicantID,$loan_summary_id,$OverallBalance,$created_by,$bill_number,$payment_date,$created_at);		
		}
		}
        	   
	 }
	 return true;	
}
public static function insertprepaidAmount($employerID,$applicantID,$loan_summary_id,$amount,$created_by,$bill_number,$payment_date,$created_at){
	Yii::$app->db->createCommand()
        ->insert('loan_repayment_prepaid', [
        'employer_id' =>$employerID,
        'applicant_id' =>$applicantID,
        'loan_summary_id' =>$loan_summary_id,
        'monthly_amount' =>$amount,
        'created_by' =>$created_by,
        'bill_number' =>$bill_number,
        'payment_date'=>$payment_date,
        'created_at'=>$created_at,
        'date_bill_generated'=>$created_at,		
        ])->execute();
}
public static function updatePaymentAfterGePGconfirmPaymentDonePrePaid($controlNumber){
        $model=new LoanSummary();
		$date_control_received=date("Y-m-d H:i:s");
		$receiptDate=date("Y-m-d H:i:s");
		$receiptNumber=rand(100,1000);
        LoanRepaymentPrepaid::updateAll(['payment_status' =>'1','date_control_received'=>$date_control_received,'receipt_date'=>$receiptDate,'date_receipt_received'=>$receiptDate,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND payment_status ="0"');
 }
public static function createAutomaticBillsPrepaid(){
	        $modelLoanRepaymentDetail=new LoanRepaymentDetailSearch();
			$modelLoanRepayment = new LoanRepayment();
			$todate=date("Y-m-d");
			$yeaAndMonth=date("Y-m");
			$checkingDate=$yeaAndMonth."-10";
    if($todate > $checkingDate){
		$prepaidDetails = LoanRepaymentPrepaid::findBySql("SELECT employer_id,payment_date,bill_number,loan_summary_id,control_number,receipt_number,date_bill_generated,date_control_received,receipt_date,date_receipt_received,payment_status FROM loan_repayment_prepaid WHERE  payment_date='$checkingDate' AND monthly_deduction_status='0' AND payment_status='1'")->groupBy('employer_id')->all();
	        foreach($prepaidDetails AS $prepaidDetailsResults){
			$modelLoanRepayment = new LoanRepayment();	
            $loan_summary_id=$prepaidDetailsResults->loan_summary_id;
			$modelLoanRepayment->amount=0;
			$modelLoanRepayment->employer_id=$prepaidDetailsResults->employer_id;
			$modelLoanRepayment->payment_date=$prepaidDetailsResults->payment_date;
			$modelLoanRepayment->bill_number=$prepaidDetailsResults->bill_number;
			$modelLoanRepayment->control_number=$prepaidDetailsResults->control_number;
			$modelLoanRepayment->receipt_number=$prepaidDetailsResults->receipt_number;
			$modelLoanRepayment->date_bill_generated=$prepaidDetailsResults->date_bill_generated;
			$modelLoanRepayment->date_control_received=$prepaidDetailsResults->date_control_received;
			$modelLoanRepayment->receipt_date=date("Y-m-d H:i:s",strtotime($prepaidDetailsResults->payment_date));
			$modelLoanRepayment->date_receipt_received=date("Y-m-d H:i:s",strtotime($prepaidDetailsResults->payment_date));
			$modelLoanRepayment->payment_status=$prepaidDetailsResults->payment_status;
			$payment_date=$prepaidDetailsResults->payment_date;
			$modelLoanRepayment->save();
            $loan_repayment_id=$modelLoanRepayment->loan_repayment_id;
			$employer_id=$prepaidDetailsResults->employer_id;
			$modelLoanRepaymentDetail->insertAllPaymentsofAllLoaneesUnderPrepaidMonthly($loan_summary_id,$loan_repayment_id,$payment_date,$employer_id);

            $totalAmount1=$modelLoanRepayment->getAmountRequiredForPayment($loan_repayment_id);
            $modelLoanRepayment->updateTotalAmountPrepaid($totalAmount1,$loan_repayment_id);
			
			}
	}	
			return true;
} 
public static function checkGePGlawsonBill($deduction_month,$bill_number,$amount,$control_number_date,$CheckDate){
	if(\frontend\modules\repayment\models\GepgLawson::find()->where(['deduction_month'=>$deduction_month,'check_date'=>$CheckDate])->count()==0){
 Yii::$app->db->createCommand("INSERT IGNORE INTO  gepg_lawson(bill_number,amount,deduction_month,control_number_date,check_date) VALUES('$bill_number','$amount','$deduction_month','$control_number_date','$CheckDate')")->execute();	
}	
	}
public static function createBillPerEmployer($amount,$deduction_month,$Votecode,$VoteName,$CheckDate,$paymentStatus){
	if(self::find()->where(['lowason_check_date'=>$CheckDate,'vote_number'=>$Votecode])->count()==0){
	$getEmployerID=\frontend\modules\repayment\models\Employer::find()->where(['vote_number'=>$Votecode])->one();
	$getEmployerIDx=$getEmployerID->employer_id;
	$getBillDetails=\frontend\modules\repayment\models\GepgLawson::find()->where(['deduction_month'=>$deduction_month])->one();
	$gepg_lawson_id=$getBillDetails->gepg_lawson_id;
	$bill_number=$getBillDetails->bill_number;
	$date_bill_generated=$getBillDetails->control_number_date;
 Yii::$app->db->createCommand("INSERT INTO  loan_repayment(employer_id,bill_number,amount,payment_date,date_bill_generated,vote_number,Vote_name,gepg_lawson_id,lowason_check_date,payment_status,payment_category) VALUES('$getEmployerIDx','$bill_number','$amount','$deduction_month','$date_bill_generated','$Votecode','$VoteName','$gepg_lawson_id','$CheckDate','$paymentStatus','1')")->execute();	
}	
	}
public static function updateTotalAmountUnderEmployerBillGSPP($totalAmount1,$loan_repayment_id){
        self::updateAll(['amount'=>$totalAmount1], 'loan_repayment_id ="'.$loan_repayment_id.'"'); 
    }
	
public static function generalFunctControlNumber($billNumber,$controlNumber,$date_control_received){
	 \frontend\modules\repayment\models\GepgLawson::updateAll(['gepg_date'=>$date_control_received,'control_number'=>$controlNumber,'status'=>'1'], 'bill_number ="'.$billNumber.'"');	
     self::updateAll(['date_control_received'=>$date_control_received,'control_number'=>$controlNumber], 'bill_number ="'.$billNumber.'"');      
        }
public static function requestMonthlyDeduction($fileDeductions){
$fileDeductions='<ArrayOfDeductions xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/GPP.Models">
    <Deductions>
        <ActualBalanceAmount>4044600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791785</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Dodoma           </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>YUSUPH                        </FirstName>
        <LastName>FADHILI                        </LastName>
        <MiddleName>MAX                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8504400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791794</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Arusha           </DeptName>
        <Deptcode>2004 </Deptcode>
        <FirstName>TARSILA                       </FirstName>
        <LastName>ASENGA                        </LastName>
        <MiddleName>GERVAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1177050.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10989847</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Internal Audit                </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Selina                        </FirstName>
        <LastName>Wangilisasi                   </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ethics Secretariat            </VoteName>
        <Votecode>33   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13791587.78</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10087743</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sylvester</FirstName>
        <LastName>Mwashilindi                   </LastName>
        <MiddleName>Raphael                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6632680.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11994356</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>Joseph                        </FirstName>
        <LastName>Ndumuka                       </LastName>
        <MiddleName>Philemon                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8034750.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111066695</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Mwambani Hospital             </DeptName>
        <Deptcode>1015 </Deptcode>
        <FirstName>EDDAH                         </FirstName>
        <LastName>BWAKILA                       </LastName>
        <MiddleName>GERALD                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Designated District Hospitals </VoteName>
        <Votecode>N1   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5029460.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11494867</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>GS2 and Above                 </DeptName>
        <Deptcode>5004 </Deptcode>
        <FirstName>Abdallah                      </FirstName>
        <LastName>Mvungi                        </LastName>
        <MiddleName>Mohamed                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5607293.91</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426029</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>MAGRETH                       </FirstName>
        <LastName>KHALIFA                       </LastName>
        <MiddleName>AZIZI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2847460.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110609868</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>HERMAN                        </FirstName>
        <LastName>KESSY                         </LastName>
        <MiddleName>GEORGE                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8220200.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111119859</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SULEKHA                       </FirstName>
        <LastName>AHMED                         </LastName>
        <MiddleName>ABDI                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5517780.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11733047</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>138150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Weight &amp; Measure              </DeptName>
        <Deptcode>3003 </Deptcode>
        <FirstName>Maneno                        </FirstName>
        <LastName>Mwakibete                     </LastName>
        <MiddleName>Popati                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Weights &amp; Measures Agency     </VoteName>
        <Votecode>S3   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2149675.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110804039</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>60150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>JACKSON                       </FirstName>
        <LastName>VENANCE                       </LastName>
        <MiddleName>ESTER                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Coast Region                  </VoteName>
        <Votecode>71   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9049893.65</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111301706</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DAVID                         </FirstName>
        <LastName>MWANI                         </LastName>
        <MiddleName>EZEKIEL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5732600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111256025</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Irene                         </FirstName>
        <LastName>Kihwelo                       </LastName>
        <MiddleName>Gerald                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2672872.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12236524</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Atukuzwe                      </FirstName>
        <LastName>Mwanjala                      </LastName>
        <MiddleName>ISSACK                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4677927.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110841206</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Steven                        </FirstName>
        <LastName>Kibona                        </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>884954.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9254585</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Grace                         </FirstName>
        <LastName>Bwaye                         </LastName>
        <MiddleName>PASCHAL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10627065.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10738698</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Dionista                      </FirstName>
        <LastName>Thomas                        </LastName>
        <MiddleName>Donasian                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7393225.50</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11286417</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ramadhani                     </FirstName>
        <LastName>Msuya                         </LastName>
        <MiddleName>Shabani                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2685237.66</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001697</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Ruvuma           </DeptName>
        <Deptcode>2013 </Deptcode>
        <FirstName>HELLEN                        </FirstName>
        <LastName>CHUMA                         </LastName>
        <MiddleName>MARTIN                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>19396059.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10583500</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Halima                        </FirstName>
        <LastName>Kassim                        </LastName>
        <MiddleName>MOHAMED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6652400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494583</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Optatus                       </FirstName>
        <LastName>Mtitu                         </LastName>
        <MiddleName>MARCUS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7382555.20</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110572087</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MODESTA                       </FirstName>
        <LastName>NJOBO                         </LastName>
        <MiddleName>LUCAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>17186806.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111505876</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Preventive Services           </DeptName>
        <Deptcode>5011 </Deptcode>
        <FirstName>JULIUS                        </FirstName>
        <LastName>JOSEPHAT                      </LastName>
        <MiddleName>KEHONGO                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8585400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426013</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LONGINO                       </FirstName>
        <LastName>KUMUGISHA                     </LastName>
        <MiddleName>RWEGOSHORA                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9237874.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10925854</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aneth                         </FirstName>
        <LastName>Shoo                          </LastName>
        <MiddleName>Elimuu                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10542095.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111712431</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MASOUD                        </FirstName>
        <LastName>MASOUD                        </LastName>
        <MiddleName>HAMAD                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9089700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10512023</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Hussein                       </FirstName>
        <LastName>Lufulondama                   </LastName>
        <MiddleName>Nteminyanda                                       </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11662745.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111294853</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>LEOCARDIA                     </FirstName>
        <LastName>HENRY                         </LastName>
        <MiddleName>PELANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11722445.55</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12308306</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SALOME                        </FirstName>
        <LastName>GULENGA                       </LastName>
        <MiddleName>SOLOMON                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12571034.22</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10227673</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Daniela                       </FirstName>
        <LastName>Nyoni                         </LastName>
        <MiddleName>Simon                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12109170.16</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110770405</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture                   </DeptName>
        <Deptcode>5033 </Deptcode>
        <FirstName>Underson                      </FirstName>
        <LastName>Said                          </LastName>
        <MiddleName>Ahadi                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>564190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11972707</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Crop Development              </DeptName>
        <Deptcode>2001 </Deptcode>
        <FirstName>Juma                          </FirstName>
        <LastName>Mwinyimkuu                    </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7494470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111227790</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aldo                          </FirstName>
        <LastName>Mbilinyi                      </LastName>
        <MiddleName>Aldo                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14205098.33</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12267878</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>WILSON                        </FirstName>
        <LastName>SENKORO                       </LastName>
        <MiddleName>EXAUDY                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12698124.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10705764</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Yustina                       </FirstName>
        <LastName>Lyandala                      </LastName>
        <MiddleName>Henry                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13570337.67</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10703623</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Gerald                        </FirstName>
        <LastName>Mwakyuse                      </LastName>
        <MiddleName>ALFRED                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6500010.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8874599</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Patrisia                      </FirstName>
        <LastName>Kahwili                       </LastName>
        <MiddleName>MANFRED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13173142.19</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111912034</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Zerafina                      </FirstName>
        <LastName>Gotora                        </LastName>
        <MiddleName>Boaz                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Cooperative Dev. Commision    </VoteName>
        <Votecode>24   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12392942.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494480</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sihaba                        </FirstName>
        <LastName>ngole                         </LastName>
        <MiddleName>TWAHA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1490969.18</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9823767</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>184650.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Leonida                       </FirstName>
        <LastName>Tawa                          </LastName>
        <MiddleName>CHIPANHA                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2829900.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791866</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Mbeya            </DeptName>
        <Deptcode>2010 </Deptcode>
        <FirstName>PRIVA                         </FirstName>
        <LastName>MAZULA                        </LastName>
        <MiddleName>PRIMI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7364340.41</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111911271</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Lushoto  </DeptName>
        <Deptcode>1008 </Deptcode>
        <FirstName>NICODEMAS                     </FirstName>
        <LastName>MWIKOZI                       </LastName>
        <MiddleName>TAMBO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8038760.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111000817</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Pendaeli                      </FirstName>
        <LastName>Massay                        </LastName>
        <MiddleName>Elibariki                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Singida Region                </VoteName>
        <Votecode>84   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16842409.81</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9285183</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Vumilia                       </FirstName>
        <LastName>Paulo                         </LastName>
        <MiddleName>NKABO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6210825.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111470973</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Odilia                        </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Ditrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>994700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110575656</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>BENADETHA                     </FirstName>
        <LastName>TIIBUZA                       </LastName>
        <MiddleName> PETER                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5497342.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8704898</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>421500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Wilfred                       </FirstName>
        <LastName>Magige                        </LastName>
        <MiddleName>WAISARILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9246875.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111531318</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Shabani                       </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Sharifu                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8660100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111424869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>115500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>HUSSEIN                       </FirstName>
        <LastName>MKWILI                        </LastName>
        <MiddleName>IBRAHIM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3593855.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111086003</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>TSC-Districts                 </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>SOPHIA                        </FirstName>
        <LastName>MSANGI                        </LastName>
        <MiddleName>ABDALLAH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanzania Teachers Commission  </VoteName>
        <Votecode>02   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11302347.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111026936</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Hospitali Teule ya Rufaa -Mkoa</DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>JOSEPH                        </FirstName>
        <LastName>EDWARD                        </LastName>
        <MiddleName>MALIMA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Region                  </VoteName>
        <Votecode>63   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10548850.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110499655</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>103350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Igogwe Hospital               </DeptName>
        <Deptcode>1012 </Deptcode>
        <FirstName>Jane                          </FirstName>
        <LastName>Mahenge                       </LastName>
        <MiddleName>Yusuph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Voluntary Agency Hospitals    </VoteName>
        <Votecode>N0   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3004280.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10967276</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Neema                         </FirstName>
        <LastName>Duwe                          </LastName>
        <MiddleName>Gulmay                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>47144332.54</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111714422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LUFUNYO                       </FirstName>
        <LastName>LIHWEULI                      </LastName>
        <MiddleName>EDSON                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3158433.36</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791896</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Morogoro         </DeptName>
        <Deptcode>2025 </Deptcode>
        <FirstName>EVELYNE                       </FirstName>
        <LastName>NDUNGURU                      </LastName>
        <MiddleName>NARCIS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8131470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001730</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Shinyanga        </DeptName>
        <Deptcode>2017 </Deptcode>
        <FirstName>UPENDO                        </FirstName>
        <LastName>SHEMKOLE                      </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3206030.46</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805364</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AGNES                         </FirstName>
        <LastName>BIMBOMA                       </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7436092.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111691877</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JENESTA                       </FirstName>
        <LastName>GREVASE                       </LastName>
        <MiddleName>BASIMAKI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8378412.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111536757</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Resta                         </FirstName>
        <LastName>Nyava                         </LastName>
        <MiddleName>Joshua                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9163812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111575750</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Fredy                         </FirstName>
        <LastName>Edwin                         </LastName>
        <MiddleName>Mwasalanga                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10104151.64</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715505</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ahiadu                        </FirstName>
        <LastName>Sangoda                       </LastName>
        <MiddleName>Amiri                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>629100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8997078</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Probation and Community Servic</DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Hamisi                        </FirstName>
        <LastName>Jengela                       </LastName>
        <MiddleName>ANDREA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ministry of Home Affairs      </VoteName>
        <Votecode>51   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2826627.53</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110923004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JEMA                          </FirstName>
        <LastName>MPESA                         </LastName>
        <MiddleName>WILLIAM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6726190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715996</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Theresia                      </FirstName>
        <LastName>Shokole                       </LastName>
        <MiddleName>Yusti                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2402434.05</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11978525</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>179700.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Tanz. Fisheries Research Inst </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Asilatu                       </FirstName>
        <LastName>Shechonge                     </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanz. Fisheries Research Inst </VoteName>
        <Votecode>TR07 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16189344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111507937</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>GOODLUCK                      </FirstName>
        <LastName>MBWILLO                       </LastName>
        <MiddleName>YOHANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8635475.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111717386</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Bestina                       </FirstName>
        <LastName>Murobi                        </LastName>
        <MiddleName>Ladislaus                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14872120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11529400</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Livestock                     </DeptName>
        <Deptcode>5034 </Deptcode>
        <FirstName>Isdory                        </FirstName>
        <LastName>Karia                         </LastName>
        <MiddleName>Jacob                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13406327.70</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110748594</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Paskalia                      </FirstName>
        <LastName>Sitembela                     </LastName>
        <MiddleName>Chrispin                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1108339.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111595848</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JACOB                         </FirstName>
        <LastName>JONH                          </LastName>
        <MiddleName>NHAMANILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7806462.47</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110987869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Njombe   </DeptName>
        <Deptcode>1005 </Deptcode>
        <FirstName>Emmanuel                      </FirstName>
        <LastName>George                        </LastName>
        <MiddleName>Deogratius                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Njombe Region                 </VoteName>
        <Votecode>54   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11576145.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111594173</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AMOS                          </FirstName>
        <LastName>MATHIAS                       </LastName>
        <MiddleName>LENGOKO                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3828720.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11997748</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>188250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Planning Division             </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Vonyvaco                      </FirstName>
        <LastName>Luvanda                       </LastName>
        <MiddleName>HEBELI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3239470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8794004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Ales                          </FirstName>
        <LastName>Mahelela                      </LastName>
        <MiddleName>LUGANO                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9485245.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111710447</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MARIAM                        </FirstName>
        <LastName>JILASA                        </LastName>
        <MiddleName>ELIAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7775930.93</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110687528</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CHRISTINA                     </FirstName>
        <LastName>KIANGIO                       </LastName>
        <MiddleName>JOHN                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Municipal Council      </VoteName>
        <Votecode>7205 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8534436.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10228728</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Eliya                         </FirstName>
        <LastName>Malila                        </LastName>
        <MiddleName>MARIO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12576215.37</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10333196</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>182250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Hilda                         </FirstName>
        <LastName>Mushi                         </LastName>
        <MiddleName>HONORATH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha Region                 </VoteName>
        <Votecode>70   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3781667.07</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11281102</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Angela                        </FirstName>
        <LastName>Tarimo                        </LastName>
        <MiddleName>Joseph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9492590.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9500422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Majaliwa                      </FirstName>
        <LastName>Mawazo                        </LastName>
        <MiddleName>COSMAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13381364.01</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9478824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Rukia                         </FirstName>
        <LastName>Kombo                         </LastName>
        <MiddleName>SAIDI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1709316.40</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9730270</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>479250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dentistry                     </DeptName>
        <Deptcode>0018 </Deptcode>
        <FirstName>OMAR                          </FirstName>
        <LastName>MAALIM                        </LastName>
        <MiddleName>HAMZA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Muhimbili Medical Centre      </VoteName>
        <Votecode>TR129</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7378812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111562715</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Benitha                       </FirstName>
        <LastName>Ngimbudzi                     </LastName>
        <MiddleName>Ben                                               </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9711127.56</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9783874</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Gaudencia                     </FirstName>
        <LastName>Wapalila                      </LastName>
        <MiddleName>EPHRAHIM                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9709190.97</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10894286</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Tumaini                       </FirstName>
        <LastName>Mgina                         </LastName>
        <MiddleName>YESSE                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6301320.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8572312</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Justine                       </FirstName>
        <LastName>Lisulile                      </LastName>
        <MiddleName>YIHOSWA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4806120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805332</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CATHERINE                     </FirstName>
        <LastName>PAHALI                        </LastName>
        <MiddleName>FELICIAN                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2925256.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12240421</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DOMINICK                      </FirstName>
        <LastName>MWEMUTSI                      </LastName>
        <MiddleName>BONIFASI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2393282.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12270993</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ALOYCE                        </FirstName>
        <LastName>MURUNGU                       </LastName>
        <MiddleName>ELLY                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6601990.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10661297</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ghati                         </FirstName>
        <LastName>Ryoba                         </LastName>
        <MiddleName>Magoiga                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9305294.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12056454</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Witness                       </FirstName>
        <LastName>Bashaka                       </LastName>
        <MiddleName>JASSON                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2712344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12296177</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MAGDALENA                     </FirstName>
        <LastName>MBOYA                         </LastName>
        <MiddleName>LINDA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13671860.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111741598</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Tabora           </DeptName>
        <Deptcode>2015 </Deptcode>
        <FirstName>TITO                          </FirstName>
        <LastName>MWAKALINGA                    </LastName>
        <MiddleName>AMBANGILE                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9509300.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110972155</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>ABRAHAM                       </FirstName>
        <LastName>MWAKASUNGULA                  </LastName>
        <MiddleName>NEHEMIA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10348898.75</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111589824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ORESTO                        </FirstName>
        <LastName>MLIGO                         </LastName>
        <MiddleName>JOSEPH                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8572822.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10481156</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Patrick                       </FirstName>
        <LastName>Kastomu                       </LastName>
        <MiddleName>nzowa                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9720600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10347494</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>114000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>District Court                </DeptName>
        <Deptcode>2306 </Deptcode>
        <FirstName>Sabato                        </FirstName>
        <LastName>Mwangwa                       </LastName>
        <MiddleName>Mukaka                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
</ArrayOfDeductions>';

$results = json_decode(json_encode((array)simplexml_load_string($fileDeductions)),true);
		$ArrayOfDeductions = $results['Deductions'];
		//$cavaca=$results['Deductions'];
		$employeeCount=simplexml_load_string($fileDeductions);
		$countEmployees=count($employeeCount->Deductions);
		//exit;
		if($countEmployees > 1){
$si=0;			
    foreach ($ArrayOfDeductions as $Deductions) {

    $trans_date = date('Y-m-d H:i:s');	
    $ActualBalanceAmount = trim($Deductions['ActualBalanceAmount']);
	$CheckDate = date("Y-m-d",strtotime(trim($Deductions['CheckDate'])));
	$CheckNumber = trim($Deductions['CheckNumber']);
	$DateHired = trim($Deductions['DateHired']);
	$DeductionAmount = trim($Deductions['DeductionAmount']);
	$DeductionCode = trim($Deductions['DeductionCode']);
	$DeductionDesc = trim($Deductions['DeductionDesc']);
	$DeptName = trim($Deductions['DeptName']);
	$Deptcode = trim($Deductions['Deptcode']);
	$FirstName = trim($Deductions['FirstName']);
	$LastName = trim($Deductions['LastName']);
	$MiddleName = trim($Deductions['MiddleName']);
	$NationalId = trim($Deductions['NationalId']);
	$Sex = trim($Deductions['Sex']);
	$VoteName = trim($Deductions['VoteName']);
	$Votecode = trim($Deductions['Votecode']);
    
   //echo 'ActualBalanceAmount: '.$ActualBalanceAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."CheckNumber: ".$CheckNumber."<br/>"."DateHired: ".$DateHired."<br/>"."DeductionAmount".$DeductionAmount."<br/>"."DeductionCode".$DeductionCode."<br/>"."DeductionDesc: ".$DeductionDesc."<br/>"."DeptName: ".$DeptName."<br/>"."FirstName: ".$FirstName."<br/>"."LastName: ".$LastName."<br/>"."MiddleName: ".$MiddleName."<br/>"."NationalId: ".$NationalId."<br/>"."Sex: ".$Sex."<br/>"."VoteName: ".$VoteName."<br/>"."Votecode: ".$Votecode."<br/>"."Done1";

   $deduction_month=date("Y-m")."-".\frontend\modules\repayment\models\LoanRepayment::DEDUCTION_DATE_REQUEST;
   $yearT=date("Y");
   $resultsCount=\frontend\modules\repayment\models\GepgLawson::getBillTreasuryPerYear($yearT) + 1;
   $bill_number=\frontend\modules\repayment\models\LoanRepayment::TREAURY_BILL_FORMAT.$yearT."-".$resultsCount;
   $amountBill=0;
   $amount=0;
   $control_number_date=date("Y-m-d H:i:s");$created_at=date("Y-m-d H:i:s");
   \frontend\modules\repayment\models\LawsonMonthlyDeduction::insertGSPPdeductionsDetails($ActualBalanceAmount,$CheckDate,$CheckNumber,$DateHired,$DeductionAmount,$DeductionCode,$DeductionDesc,$DeptName,$FirstName,$LastName,$MiddleName,$NationalId,$Sex,$VoteName,$Votecode,$created_at,$deduction_month,$Deptcode);
   \frontend\modules\repayment\models\LoanRepayment::checkGePGlawsonBill($deduction_month,$bill_number,$amountBill,$control_number_date,$CheckDate);   $paymentStatus=0;
   \frontend\modules\repayment\models\LoanRepayment::createBillPerEmployer($amount,$deduction_month,$Votecode,$VoteName,$CheckDate,$paymentStatus);
   \frontend\modules\repayment\models\LoanRepaymentDetail::insertRepaymentDetailsGSPP($DeductionAmount,$CheckNumber,$Votecode,$CheckDate,$Votecode,$VoteName,$Deptcode,$DeptName,$ActualBalanceAmount,$DeductionCode,$DeductionDesc,$FirstName,$MiddleName,$LastName);
  ++$si; 
 
}
	}else{
		
	$ActualBalanceAmount = trim($ArrayOfDeductions['ActualBalanceAmount']);
	$CheckDate = trim($ArrayOfDeductions['CheckDate']);
	$CheckNumber = trim($ArrayOfDeductions['CheckNumber']);
	$DateHired = trim($ArrayOfDeductions['DateHired']);
	$DeductionAmount = trim($ArrayOfDeductions['DeductionAmount']);
	$DeductionCode = trim($ArrayOfDeductions['DeductionCode']);
	$DeductionDesc =trim($ArrayOfDeductions['DeductionDesc']);
	$DeptName = trim($ArrayOfDeductions['DeptName']);
	$Deptcode = trim($ArrayOfDeductions['Deptcode']);
	$FirstName = trim($ArrayOfDeductions['FirstName']);
	$LastName = trim($ArrayOfDeductions['LastName']);
	$MiddleName = trim($ArrayOfDeductions['MiddleName']);
	$NationalId = trim($ArrayOfDeductions['NationalId']);
	$Sex = trim($ArrayOfDeductions['Sex']);
	$VoteName = trim($ArrayOfDeductions['VoteName']);
	$Votecode = trim($ArrayOfDeductions['Votecode']);

  //echo 'ActualBalanceAmount: '.$ActualBalanceAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."CheckNumber: ".$CheckNumber."<br/>"."DateHired: ".$DateHired."<br/>"."DeductionAmount".$DeductionAmount."<br/>"."DeductionCode".$DeductionCode."<br/>"."DeductionDesc: ".$DeductionDesc."<br/>"."DeptName: ".$DeptName."<br/>"."FirstName: ".$FirstName."<br/>"."LastName: ".$LastName."<br/>"."MiddleName: ".$MiddleName."<br/>"."NationalId: ".$NationalId."<br/>"."Sex: ".$Sex."<br/>"."VoteName: ".$VoteName."<br/>"."Votecode: ".$Votecode."<br/>"."Done2";
  
   $deduction_month=date("Y-m")."-".\frontend\modules\repayment\models\LoanRepayment::DEDUCTION_DATE_REQUEST;
   $yearT=date("Y");
   $resultsCount=\frontend\modules\repayment\models\GepgLawson::getBillTreasuryPerYear($yearT) + 1;
   $bill_number=\frontend\modules\repayment\models\LoanRepayment::TREAURY_BILL_FORMAT.$yearT."-".$resultsCount;
   $amountBill=0;
   $amount=0;
   $control_number_date=date("Y-m-d H:i:s");$created_at=date("Y-m-d H:i:s");
   \frontend\modules\repayment\models\LawsonMonthlyDeduction::insertGSPPdeductionsDetails($ActualBalanceAmount,$CheckDate,$CheckNumber,$DateHired,$DeductionAmount,$DeductionCode,$DeductionDesc,$DeptName,$FirstName,$LastName,$MiddleName,$NationalId,$Sex,$VoteName,$Votecode,$created_at,$deduction_month,$Deptcode);
   \frontend\modules\repayment\models\LoanRepayment::checkGePGlawsonBill($deduction_month,$bill_number,$amountBill,$control_number_date,$CheckDate);   $paymentStatus=0;
   \frontend\modules\repayment\models\LoanRepayment::createBillPerEmployer($amount,$deduction_month,$Votecode,$VoteName,$CheckDate,$paymentStatus);
   \frontend\modules\repayment\models\LoanRepaymentDetail::insertRepaymentDetailsGSPP($DeductionAmount,$CheckNumber,$Votecode,$CheckDate,$Votecode,$VoteName,$Deptcode,$DeptName,$ActualBalanceAmount,$DeductionCode,$DeductionDesc,$FirstName,$MiddleName,$LastName);  
	}

	\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidGSPP($CheckDate);
	\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerLoanRepayment($CheckDate);
}
public static function requestMonthlyDeductionSummary($fileDeductionsSummary){
$fileDeductionsSummary='<ArrayOfDeductionSummary xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/GPP.Models">
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>3593855.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>108750.00</TotalDeductionAmount>
        <VoteName>Tanzania Teachers Commission  </VoteName>
        <Votecode>02   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>22852793.91</TotalActualBalanceAmount>
        <TotalDeductionAmount>354600.00</TotalDeductionAmount>
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>13173142.19</TotalActualBalanceAmount>
        <TotalDeductionAmount>142500.00</TotalDeductionAmount>
        <VoteName>Cooperative Dev. Commision    </VoteName>
        <Votecode>24   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>19970700.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>476100.00</TotalDeductionAmount>
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>1177050.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>145350.00</TotalDeductionAmount>
        <VoteName>Ethics Secretariat            </VoteName>
        <Votecode>33   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>7</NumEmployee>
        <TotalActualBalanceAmount>43025901.02</TotalActualBalanceAmount>
        <TotalDeductionAmount>1300650.00</TotalDeductionAmount>
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>2</NumEmployee>
        <TotalActualBalanceAmount>17662522.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>287700.00</TotalDeductionAmount>
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>24566900.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>331500.00</TotalDeductionAmount>
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>23275811.70</TotalActualBalanceAmount>
        <TotalDeductionAmount>402300.00</TotalDeductionAmount>
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>12</NumEmployee>
        <TotalActualBalanceAmount>104031074.09</TotalActualBalanceAmount>
        <TotalDeductionAmount>2389050.00</TotalDeductionAmount>
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>25801800.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>365250.00</TotalDeductionAmount>
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>4</NumEmployee>
        <TotalActualBalanceAmount>32798424.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>439800.00</TotalDeductionAmount>
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>629100.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>145350.00</TotalDeductionAmount>
        <VoteName>Ministry of Home Affairs      </VoteName>
        <Votecode>51   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>7806462.47</TotalActualBalanceAmount>
        <TotalDeductionAmount>529500.00</TotalDeductionAmount>
        <VoteName>Njombe Region                 </VoteName>
        <Votecode>54   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>29734457.16</TotalActualBalanceAmount>
        <TotalDeductionAmount>362400.00</TotalDeductionAmount>
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>5</NumEmployee>
        <TotalActualBalanceAmount>49487148.53</TotalActualBalanceAmount>
        <TotalDeductionAmount>584250.00</TotalDeductionAmount>
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>11302347.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>225000.00</TotalDeductionAmount>
        <VoteName>Geita Region                  </VoteName>
        <Votecode>63   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>20006937.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>329850.00</TotalDeductionAmount>
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>12576215.37</TotalActualBalanceAmount>
        <TotalDeductionAmount>182250.00</TotalDeductionAmount>
        <VoteName>Arusha Region                 </VoteName>
        <Votecode>70   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>4</NumEmployee>
        <TotalActualBalanceAmount>23309814.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>504750.00</TotalDeductionAmount>
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>4</NumEmployee>
        <TotalActualBalanceAmount>32881062.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>572550.00</TotalDeductionAmount>
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>2149675.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>60150.00</TotalDeductionAmount>
        <VoteName>Coast Region                  </VoteName>
        <Votecode>71   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>3</NumEmployee>
        <TotalActualBalanceAmount>68031360.72</TotalActualBalanceAmount>
        <TotalDeductionAmount>634650.00</TotalDeductionAmount>
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>7775930.93</TotalActualBalanceAmount>
        <TotalDeductionAmount>109950.00</TotalDeductionAmount>
        <VoteName>Dodoma Municipal Council      </VoteName>
        <Votecode>7205 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>10</NumEmployee>
        <TotalActualBalanceAmount>82532566.41</TotalActualBalanceAmount>
        <TotalDeductionAmount>1357200.00</TotalDeductionAmount>
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>9</NumEmployee>
        <TotalActualBalanceAmount>58058710.79</TotalActualBalanceAmount>
        <TotalDeductionAmount>1143900.00</TotalDeductionAmount>
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>8038760.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>148950.00</TotalDeductionAmount>
        <VoteName>Singida Region                </VoteName>
        <Votecode>84   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>2</NumEmployee>
        <TotalActualBalanceAmount>23553684.41</TotalActualBalanceAmount>
        <TotalDeductionAmount>754500.00</TotalDeductionAmount>
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>10548850.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>103350.00</TotalDeductionAmount>
        <VoteName>Voluntary Agency Hospitals    </VoteName>
        <Votecode>N0   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>8034750.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>108750.00</TotalDeductionAmount>
        <VoteName>Designated District Hospitals </VoteName>
        <Votecode>N1   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>5517780.00</TotalActualBalanceAmount>
        <TotalDeductionAmount>138150.00</TotalDeductionAmount>
        <VoteName>Weights &amp; Measures Agency     </VoteName>
        <Votecode>S3   </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>2402434.05</TotalActualBalanceAmount>
        <TotalDeductionAmount>179700.00</TotalDeductionAmount>
        <VoteName>Tanz. Fisheries Research Inst </VoteName>
        <Votecode>TR07 </Votecode>
    </DeductionSummary>
    <DeductionSummary>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <DeductionCode>465 </DeductionCode>
        <NumEmployee>1</NumEmployee>
        <TotalActualBalanceAmount>1709316.40</TotalActualBalanceAmount>
        <TotalDeductionAmount>479250.00</TotalDeductionAmount>
        <VoteName>Muhimbili Medical Centre      </VoteName>
        <Votecode>TR129</Votecode>
    </DeductionSummary>
</ArrayOfDeductionSummary>';

$results = json_decode(json_encode((array)simplexml_load_string($fileDeductionsSummary)),true);
		$ArrayOfDeductionSummary = $results['DeductionSummary'];
		//$cavaca=$results['DeductionSummary'];
		$DeductionSummaryCount=simplexml_load_string($fileDeductionsSummary);
		$countDeductionSummary=count($DeductionSummaryCount->DeductionSummary);
		//exit;
$finalTotalDeductions=0;		
		if($countDeductionSummary > 1){
$si=0;			
    foreach ($ArrayOfDeductionSummary as $summaryDeductions) {

    $trans_date = date('Y-m-d H:i:s');	
	$CheckDate = date("Y-m-d",strtotime(trim($summaryDeductions['CheckDate'])));
	$TotalDeductionAmount = trim($summaryDeductions['TotalDeductionAmount']);	
	$finalTotalDeductions +=$TotalDeductionAmount;
    
   //echo 'TotalDeductionAmount: '.$TotalDeductionAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."Done1"."<br/>";
  ++$si; 
 
}
	}else{
		
	$CheckDate = date("Y-m-d",strtotime(trim($ArrayOfDeductionSummary['CheckDate'])));
	$TotalDeductionAmount = trim($ArrayOfDeductionSummary['TotalDeductionAmount']);	
    $finalTotalDeductions=$TotalDeductionAmount;
  //echo 'TotalDeductionAmount: '.$TotalDeductionAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."Done2";
  
	}
	//the below function to run after receiving summary
	$GSPPamountSummary=$finalTotalDeductions;
	\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidGSPPsummary($CheckDate,$GSPPamountSummary);
	\frontend\modules\repayment\models\LoanRepaymentDetail::checkRepaymentAndGSPPamount($CheckDate);	
	\frontend\modules\repayment\models\LoanRepaymentDetail::checkGepgStatus();
	//end
}
public static function requestAllEmployeesMonthly($fileAllEmployMonthly){
$fileAllEmployMonthly='<ArrayOfDeductions xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/GPP.Models">
    <Deductions>
        <ActualBalanceAmount>4044600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791785</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Dodoma           </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>YUSUPH                        </FirstName>
        <LastName>FADHILI                        </LastName>
        <MiddleName>MAX                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8504400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791794</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Arusha           </DeptName>
        <Deptcode>2004 </Deptcode>
        <FirstName>TARSILA                       </FirstName>
        <LastName>ASENGA                        </LastName>
        <MiddleName>GERVAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1177050.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10989847</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Internal Audit                </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Selina                        </FirstName>
        <LastName>Wangilisasi                   </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ethics Secretariat            </VoteName>
        <Votecode>33   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13791587.78</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10087743</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sylvester</FirstName>
        <LastName>Mwashilindi                   </LastName>
        <MiddleName>Raphael                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6632680.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11994356</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>Joseph                        </FirstName>
        <LastName>Ndumuka                       </LastName>
        <MiddleName>Philemon                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8034750.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111066695</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Mwambani Hospital             </DeptName>
        <Deptcode>1015 </Deptcode>
        <FirstName>EDDAH                         </FirstName>
        <LastName>BWAKILA                       </LastName>
        <MiddleName>GERALD                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Designated District Hospitals </VoteName>
        <Votecode>N1   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5029460.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11494867</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>GS2 and Above                 </DeptName>
        <Deptcode>5004 </Deptcode>
        <FirstName>Abdallah                      </FirstName>
        <LastName>Mvungi                        </LastName>
        <MiddleName>Mohamed                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5607293.91</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426029</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>MAGRETH                       </FirstName>
        <LastName>KHALIFA                       </LastName>
        <MiddleName>AZIZI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2847460.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110609868</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>HERMAN                        </FirstName>
        <LastName>KESSY                         </LastName>
        <MiddleName>GEORGE                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8220200.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111119859</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SULEKHA                       </FirstName>
        <LastName>AHMED                         </LastName>
        <MiddleName>ABDI                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5517780.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11733047</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>138150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Weight &amp; Measure              </DeptName>
        <Deptcode>3003 </Deptcode>
        <FirstName>Maneno                        </FirstName>
        <LastName>Mwakibete                     </LastName>
        <MiddleName>Popati                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Weights &amp; Measures Agency     </VoteName>
        <Votecode>S3   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2149675.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110804039</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>60150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>JACKSON                       </FirstName>
        <LastName>VENANCE                       </LastName>
        <MiddleName>ESTER                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Coast Region                  </VoteName>
        <Votecode>71   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9049893.65</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111301706</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DAVID                         </FirstName>
        <LastName>MWANI                         </LastName>
        <MiddleName>EZEKIEL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5732600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111256025</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Irene                         </FirstName>
        <LastName>Kihwelo                       </LastName>
        <MiddleName>Gerald                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2672872.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12236524</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Atukuzwe                      </FirstName>
        <LastName>Mwanjala                      </LastName>
        <MiddleName>ISSACK                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4677927.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110841206</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Steven                        </FirstName>
        <LastName>Kibona                        </LastName>
        <MiddleName>Patrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>884954.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9254585</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Grace                         </FirstName>
        <LastName>Bwaye                         </LastName>
        <MiddleName>PASCHAL                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10627065.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10738698</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Dionista                      </FirstName>
        <LastName>Thomas                        </LastName>
        <MiddleName>Donasian                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7393225.50</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11286417</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ramadhani                     </FirstName>
        <LastName>Msuya                         </LastName>
        <MiddleName>Shabani                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2685237.66</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001697</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Ruvuma           </DeptName>
        <Deptcode>2013 </Deptcode>
        <FirstName>HELLEN                        </FirstName>
        <LastName>CHUMA                         </LastName>
        <MiddleName>MARTIN                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>19396059.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10583500</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Halima                        </FirstName>
        <LastName>Kassim                        </LastName>
        <MiddleName>MOHAMED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6652400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494583</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Optatus                       </FirstName>
        <LastName>Mtitu                         </LastName>
        <MiddleName>MARCUS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7382555.20</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110572087</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MODESTA                       </FirstName>
        <LastName>NJOBO                         </LastName>
        <MiddleName>LUCAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>17186806.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111505876</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Preventive Services           </DeptName>
        <Deptcode>5011 </Deptcode>
        <FirstName>JULIUS                        </FirstName>
        <LastName>JOSEPHAT                      </LastName>
        <MiddleName>KEHONGO                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8585400.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111426013</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>119550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LONGINO                       </FirstName>
        <LastName>KUMUGISHA                     </LastName>
        <MiddleName>RWEGOSHORA                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9237874.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10925854</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aneth                         </FirstName>
        <LastName>Shoo                          </LastName>
        <MiddleName>Elimuu                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10542095.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111712431</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MASOUD                        </FirstName>
        <LastName>MASOUD                        </LastName>
        <MiddleName>HAMAD                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9089700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10512023</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Hussein                       </FirstName>
        <LastName>Lufulondama                   </LastName>
        <MiddleName>Nteminyanda                                       </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11662745.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111294853</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>LEOCARDIA                     </FirstName>
        <LastName>HENRY                         </LastName>
        <MiddleName>PELANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11722445.55</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12308306</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>SALOME                        </FirstName>
        <LastName>GULENGA                       </LastName>
        <MiddleName>SOLOMON                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Bariadi Town Council          </VoteName>
        <Votecode>47BB1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12571034.22</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10227673</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Daniela                       </FirstName>
        <LastName>Nyoni                         </LastName>
        <MiddleName>Simon                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12109170.16</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110770405</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture                   </DeptName>
        <Deptcode>5033 </Deptcode>
        <FirstName>Underson                      </FirstName>
        <LastName>Said                          </LastName>
        <MiddleName>Ahadi                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>564190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11972707</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Crop Development              </DeptName>
        <Deptcode>2001 </Deptcode>
        <FirstName>Juma                          </FirstName>
        <LastName>Mwinyimkuu                    </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7494470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111227790</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Aldo                          </FirstName>
        <LastName>Mbilinyi                      </LastName>
        <MiddleName>Aldo                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14205098.33</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12267878</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>141000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>WILSON                        </FirstName>
        <LastName>SENKORO                       </LastName>
        <MiddleName>EXAUDY                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12698124.80</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10705764</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Yustina                       </FirstName>
        <LastName>Lyandala                      </LastName>
        <MiddleName>Henry                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13570337.67</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10703623</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Gerald                        </FirstName>
        <LastName>Mwakyuse                      </LastName>
        <MiddleName>ALFRED                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6500010.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8874599</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Patrisia                      </FirstName>
        <LastName>Kahwili                       </LastName>
        <MiddleName>MANFRED                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13173142.19</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111912034</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Zerafina                      </FirstName>
        <LastName>Gotora                        </LastName>
        <MiddleName>Boaz                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Cooperative Dev. Commision    </VoteName>
        <Votecode>24   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12392942.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10494480</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>107400.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Sihaba                        </FirstName>
        <LastName>ngole                         </LastName>
        <MiddleName>TWAHA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1490969.18</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9823767</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>184650.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Leonida                       </FirstName>
        <LastName>Tawa                          </LastName>
        <MiddleName>CHIPANHA                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2829900.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791866</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Mbeya            </DeptName>
        <Deptcode>2010 </Deptcode>
        <FirstName>PRIVA                         </FirstName>
        <LastName>MAZULA                        </LastName>
        <MiddleName>PRIMI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7364340.41</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111911271</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Lushoto  </DeptName>
        <Deptcode>1008 </Deptcode>
        <FirstName>NICODEMAS                     </FirstName>
        <LastName>MWIKOZI                       </LastName>
        <MiddleName>TAMBO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8038760.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111000817</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Pendaeli                      </FirstName>
        <LastName>Massay                        </LastName>
        <MiddleName>Elibariki                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Singida Region                </VoteName>
        <Votecode>84   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16842409.81</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9285183</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Vumilia                       </FirstName>
        <LastName>Paulo                         </LastName>
        <MiddleName>NKABO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6210825.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111470973</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Odilia                        </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Ditrick                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>994700.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110575656</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>BENADETHA                     </FirstName>
        <LastName>TIIBUZA                       </LastName>
        <MiddleName> PETER                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>5497342.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8704898</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>421500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Wilfred                       </FirstName>
        <LastName>Magige                        </LastName>
        <MiddleName>WAISARILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9246875.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111531318</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Shabani                       </FirstName>
        <LastName>Mapunda                       </LastName>
        <MiddleName>Sharifu                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8660100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111424869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>115500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Fire &amp; Rescue services        </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>HUSSEIN                       </FirstName>
        <LastName>MKWILI                        </LastName>
        <MiddleName>IBRAHIM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Jeshi la Zimamoto na Uokoaji  </VoteName>
        <Votecode>14   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3593855.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111086003</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>TSC-Districts                 </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>SOPHIA                        </FirstName>
        <LastName>MSANGI                        </LastName>
        <MiddleName>ABDALLAH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanzania Teachers Commission  </VoteName>
        <Votecode>02   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11302347.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111026936</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Hospitali Teule ya Rufaa -Mkoa</DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>JOSEPH                        </FirstName>
        <LastName>EDWARD                        </LastName>
        <MiddleName>MALIMA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Region                  </VoteName>
        <Votecode>63   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10548850.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110499655</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>103350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Igogwe Hospital               </DeptName>
        <Deptcode>1012 </Deptcode>
        <FirstName>Jane                          </FirstName>
        <LastName>Mahenge                       </LastName>
        <MiddleName>Yusuph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Voluntary Agency Hospitals    </VoteName>
        <Votecode>N0   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3004280.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10967276</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Neema                         </FirstName>
        <LastName>Duwe                          </LastName>
        <MiddleName>Gulmay                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha City Council           </VoteName>
        <Votecode>7003 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>47144332.54</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111714422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>LUFUNYO                       </FirstName>
        <LastName>LIHWEULI                      </LastName>
        <MiddleName>EDSON                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Region                 </VoteName>
        <Votecode>72   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3158433.36</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110791896</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>212550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Morogoro         </DeptName>
        <Deptcode>2025 </Deptcode>
        <FirstName>EVELYNE                       </FirstName>
        <LastName>NDUNGURU                      </LastName>
        <MiddleName>NARCIS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8131470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111001730</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Shinyanga        </DeptName>
        <Deptcode>2017 </Deptcode>
        <FirstName>UPENDO                        </FirstName>
        <LastName>SHEMKOLE                      </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3206030.46</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805364</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AGNES                         </FirstName>
        <LastName>BIMBOMA                       </LastName>
        <MiddleName>LEONARD                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7436092.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111691877</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JENESTA                       </FirstName>
        <LastName>GREVASE                       </LastName>
        <MiddleName>BASIMAKI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8378412.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111536757</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Resta                         </FirstName>
        <LastName>Nyava                         </LastName>
        <MiddleName>Joshua                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Makambako Town Council        </VoteName>
        <Votecode>54S5 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9163812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111575750</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Fredy                         </FirstName>
        <LastName>Edwin                         </LastName>
        <MiddleName>Mwasalanga                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10104151.64</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715505</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>240000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ahiadu                        </FirstName>
        <LastName>Sangoda                       </LastName>
        <MiddleName>Amiri                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>629100.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8997078</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>145350.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Probation and Community Servic</DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Hamisi                        </FirstName>
        <LastName>Jengela                       </LastName>
        <MiddleName>ANDREA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Ministry of Home Affairs      </VoteName>
        <Votecode>51   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2826627.53</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110923004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JEMA                          </FirstName>
        <LastName>MPESA                         </LastName>
        <MiddleName>WILLIAM                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6726190.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9715996</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Theresia                      </FirstName>
        <LastName>Shokole                       </LastName>
        <MiddleName>Yusti                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2402434.05</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11978525</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>179700.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Tanz. Fisheries Research Inst </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Asilatu                       </FirstName>
        <LastName>Shechonge                     </LastName>
        <MiddleName>Hamisi                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanz. Fisheries Research Inst </VoteName>
        <Votecode>TR07 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>16189344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111507937</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>225000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>GOODLUCK                      </FirstName>
        <LastName>MBWILLO                       </LastName>
        <MiddleName>YOHANA                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Tanga Region                  </VoteName>
        <Votecode>86   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8635475.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111717386</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Administration &amp; General      </DeptName>
        <Deptcode>1001 </Deptcode>
        <FirstName>Bestina                       </FirstName>
        <LastName>Murobi                        </LastName>
        <MiddleName>Ladislaus                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>14872120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11529400</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Livestock                     </DeptName>
        <Deptcode>5034 </Deptcode>
        <FirstName>Isdory                        </FirstName>
        <LastName>Karia                         </LastName>
        <MiddleName>Jacob                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13406327.70</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110748594</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>108750.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Paskalia                      </FirstName>
        <LastName>Sitembela                     </LastName>
        <MiddleName>Chrispin                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1108339.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111595848</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>JACOB                         </FirstName>
        <LastName>JONH                          </LastName>
        <MiddleName>NHAMANILO                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7806462.47</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110987869</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>529500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dist. AdminSecretary Njombe   </DeptName>
        <Deptcode>1005 </Deptcode>
        <FirstName>Emmanuel                      </FirstName>
        <LastName>George                        </LastName>
        <MiddleName>Deogratius                                        </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Njombe Region                 </VoteName>
        <Votecode>54   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>11576145.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111594173</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>AMOS                          </FirstName>
        <LastName>MATHIAS                       </LastName>
        <MiddleName>LENGOKO                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Geita Town Council            </VoteName>
        <Votecode>63CC1</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3828720.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11997748</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>188250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Planning Division             </DeptName>
        <Deptcode>1006 </Deptcode>
        <FirstName>Vonyvaco                      </FirstName>
        <LastName>Luvanda                       </LastName>
        <MiddleName>HEBELI                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3239470.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8794004</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Ales                          </FirstName>
        <LastName>Mahelela                      </LastName>
        <MiddleName>LUGANO                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9485245.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111710447</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MARIAM                        </FirstName>
        <LastName>JILASA                        </LastName>
        <MiddleName>ELIAS                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Busega District Council       </VoteName>
        <Votecode>47BB5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7775930.93</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110687528</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CHRISTINA                     </FirstName>
        <LastName>KIANGIO                       </LastName>
        <MiddleName>JOHN                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Dodoma Municipal Council      </VoteName>
        <Votecode>7205 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8534436.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10228728</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Eliya                         </FirstName>
        <LastName>Malila                        </LastName>
        <MiddleName>MARIO                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>12576215.37</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10333196</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>182250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Curative Services             </DeptName>
        <Deptcode>3001 </Deptcode>
        <FirstName>Hilda                         </FirstName>
        <LastName>Mushi                         </LastName>
        <MiddleName>HONORATH                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arusha Region                 </VoteName>
        <Votecode>70   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>3781667.07</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>11281102</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Angela                        </FirstName>
        <LastName>Tarimo                        </LastName>
        <MiddleName>Joseph                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9492590.26</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9500422</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>190200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Majaliwa                      </FirstName>
        <LastName>Mawazo                        </LastName>
        <MiddleName>COSMAS                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13381364.01</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9478824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>School Inspectorate           </DeptName>
        <Deptcode>2002 </Deptcode>
        <FirstName>Rukia                         </FirstName>
        <LastName>Kombo                         </LastName>
        <MiddleName>SAIDI                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>1709316.40</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9730270</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>479250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Dentistry                     </DeptName>
        <Deptcode>0018 </Deptcode>
        <FirstName>OMAR                          </FirstName>
        <LastName>MAALIM                        </LastName>
        <MiddleName>HAMZA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Muhimbili Medical Centre      </VoteName>
        <Votecode>TR129</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>7378812.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111562715</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Benitha                       </FirstName>
        <LastName>Ngimbudzi                     </LastName>
        <MiddleName>Ben                                               </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa District               </VoteName>
        <Votecode>73D1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9711127.56</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>9783874</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Schools               </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Gaudencia                     </FirstName>
        <LastName>Wapalila                      </LastName>
        <MiddleName>EPHRAHIM                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9709190.97</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10894286</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Tumaini                       </FirstName>
        <LastName>Mgina                         </LastName>
        <MiddleName>YESSE                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6301320.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>8572312</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>149550.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Primary Education             </DeptName>
        <Deptcode>5007 </Deptcode>
        <FirstName>Justine                       </FirstName>
        <LastName>Lisulile                      </LastName>
        <MiddleName>YIHOSWA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>4806120.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110805332</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>CATHERINE                     </FirstName>
        <LastName>PAHALI                        </LastName>
        <MiddleName>FELICIAN                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2925256.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12240421</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>DOMINICK                      </FirstName>
        <LastName>MWEMUTSI                      </LastName>
        <MiddleName>BONIFASI                                          </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Iringa Municipal Council      </VoteName>
        <Votecode>7309 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2393282.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12270993</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ALOYCE                        </FirstName>
        <LastName>MURUNGU                       </LastName>
        <MiddleName>ELLY                                              </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>6601990.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10661297</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>185250.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Teacher Education             </DeptName>
        <Deptcode>5001 </Deptcode>
        <FirstName>Ghati                         </FirstName>
        <LastName>Ryoba                         </LastName>
        <MiddleName>Magoiga                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Min. of Educ &amp; Voc. Training  </VoteName>
        <Votecode>46   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9305294.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12056454</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>148200.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Agriculture Training Institut </DeptName>
        <Deptcode>1004 </Deptcode>
        <FirstName>Witness                       </FirstName>
        <LastName>Bashaka                       </LastName>
        <MiddleName>JASSON                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Agri. , Food Security &amp; Co-op </VoteName>
        <Votecode>43   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>2712344.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>12296177</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>MAGDALENA                     </FirstName>
        <LastName>MBOYA                         </LastName>
        <MiddleName>LINDA                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Arumeru District              </VoteName>
        <Votecode>70A1 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>13671860.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111741598</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>150150.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Zonal Office Tabora           </DeptName>
        <Deptcode>2015 </Deptcode>
        <FirstName>TITO                          </FirstName>
        <LastName>MWAKALINGA                    </LastName>
        <MiddleName>AMBANGILE                                         </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Division of Public Prosecution</VoteName>
        <Votecode>35   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9509300.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>110972155</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>142500.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Human Capital Management      </DeptName>
        <Deptcode>2005 </Deptcode>
        <FirstName>ABRAHAM                       </FirstName>
        <LastName>MWAKASUNGULA                  </LastName>
        <MiddleName>NEHEMIA                                           </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Pres.Office-Public Service Mgt</VoteName>
        <Votecode>32   </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>10348898.75</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>111589824</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>109950.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>ORESTO                        </FirstName>
        <LastName>MLIGO                         </LastName>
        <MiddleName>JOSEPH                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Wangingombe District Council </VoteName>
        <Votecode>54S6 </Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>8572822.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10481156</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>143850.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>Secondary Education           </DeptName>
        <Deptcode>5008 </Deptcode>
        <FirstName>Patrick                       </FirstName>
        <LastName>Kastomu                       </LastName>
        <MiddleName>nzowa                                             </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Mpimbwe District Council      </VoteName>
        <Votecode>36AA5</Votecode>
    </Deductions>
    <Deductions>
        <ActualBalanceAmount>9720600.00</ActualBalanceAmount>
        <CheckDate>2018-10-31T00:00:00</CheckDate>
        <CheckNumber>10347494</CheckNumber>
        <DateHired i:nil="true" />
        <DeductionAmount>114000.00</DeductionAmount>
        <DeductionCode>465 </DeductionCode>
        <DeductionDesc>New HESLB Loan                </DeductionDesc>
        <DeptName>District Court                </DeptName>
        <Deptcode>2306 </Deptcode>
        <FirstName>Sabato                        </FirstName>
        <LastName>Mwangwa                       </LastName>
        <MiddleName>Mukaka                                            </MiddleName>
        <NationalId i:nil="true" />
        <Sex i:nil="true" />
        <VoteName>Judiciary Department          </VoteName>
        <Votecode>40   </Votecode>
    </Deductions>
</ArrayOfDeductions>';

$results = json_decode(json_encode((array)simplexml_load_string($fileAllEmployMonthly)),true);
		$ArrayOfDeductions = $results['Deductions'];
		//$cavaca=$results['Deductions'];
		$employeeCount=simplexml_load_string($fileAllEmployMonthly);
		$countEmployees=count($employeeCount->Deductions);
		//exit;
		if($countEmployees > 1){
$si=0;			
    foreach ($ArrayOfDeductions as $Deductions) {

    $trans_date = date('Y-m-d H:i:s');	
    $ActualBalanceAmount = trim($Deductions['ActualBalanceAmount']);
	$CheckDate = date("Y-m-d",strtotime(trim($Deductions['CheckDate'])));
	$CheckNumber = trim($Deductions['CheckNumber']);
	$DateHired = trim($Deductions['DateHired']);
	$DeductionAmount = trim($Deductions['DeductionAmount']);
	$DeductionCode = trim($Deductions['DeductionCode']);
	$DeductionDesc = trim($Deductions['DeductionDesc']);
	$DeptName = trim($Deductions['DeptName']);
	$Deptcode = trim($Deductions['Deptcode']);
	$FirstName = trim($Deductions['FirstName']);
	$LastName = trim($Deductions['LastName']);
	$MiddleName = trim($Deductions['MiddleName']);
	$NationalId = trim($Deductions['NationalId']);
	$Sex = trim($Deductions['Sex']);
	$VoteName = trim($Deductions['VoteName']);
	$Votecode = trim($Deductions['Votecode']);
    $created_at=date("Y-m-d H:i:s");
   //echo 'ActualBalanceAmount: '.$ActualBalanceAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."CheckNumber: ".$CheckNumber."<br/>"."DateHired: ".$DateHired."<br/>"."DeductionAmount".$DeductionAmount."<br/>"."DeductionCode".$DeductionCode."<br/>"."DeductionDesc: ".$DeductionDesc."<br/>"."DeptName: ".$DeptName."<br/>"."FirstName: ".$FirstName."<br/>"."LastName: ".$LastName."<br/>"."MiddleName: ".$MiddleName."<br/>"."NationalId: ".$NationalId."<br/>"."Sex: ".$Sex."<br/>"."VoteName: ".$VoteName."<br/>"."Votecode: ".$Votecode."<br/>"."Done1";


   \frontend\modules\repayment\models\GvtEmployee::insertGSPPallEmployeesMonthly($CheckDate,$CheckNumber,$DateHired,$DeductionAmount,$DeductionCode,$DeductionDesc,$DeptName,$FirstName,$MiddleName,$LastName,$NationalId,$Sex,$VoteName,$Votecode,$created_at);
  ++$si; 
 
}
	}else{
		
	$ActualBalanceAmount = trim($ArrayOfDeductions['ActualBalanceAmount']);
	$CheckDate = trim($ArrayOfDeductions['CheckDate']);
	$CheckNumber = trim($ArrayOfDeductions['CheckNumber']);
	$DateHired = trim($ArrayOfDeductions['DateHired']);
	$DeductionAmount = trim($ArrayOfDeductions['DeductionAmount']);
	$DeductionCode = trim($ArrayOfDeductions['DeductionCode']);
	$DeductionDesc =trim($ArrayOfDeductions['DeductionDesc']);
	$DeptName = trim($ArrayOfDeductions['DeptName']);
	$FirstName = trim($ArrayOfDeductions['FirstName']);
	$LastName = trim($ArrayOfDeductions['LastName']);
	$MiddleName = trim($ArrayOfDeductions['MiddleName']);
	$NationalId = trim($ArrayOfDeductions['NationalId']);
	$Sex = trim($ArrayOfDeductions['Sex']);
	$VoteName = trim($ArrayOfDeductions['VoteName']);
	$Votecode = trim($ArrayOfDeductions['Votecode']);
    $created_at=date("Y-m-d H:i:s");
	
  //echo 'ActualBalanceAmount: '.$ActualBalanceAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."CheckNumber: ".$CheckNumber."<br/>"."DateHired: ".$DateHired."<br/>"."DeductionAmount".$DeductionAmount."<br/>"."DeductionCode".$DeductionCode."<br/>"."DeductionDesc: ".$DeductionDesc."<br/>"."DeptName: ".$DeptName."<br/>"."FirstName: ".$FirstName."<br/>"."LastName: ".$LastName."<br/>"."MiddleName: ".$MiddleName."<br/>"."NationalId: ".$NationalId."<br/>"."Sex: ".$Sex."<br/>"."VoteName: ".$VoteName."<br/>"."Votecode: ".$Votecode."<br/>"."Done2";
  
   \frontend\modules\repayment\models\GvtEmployee::insertGSPPallEmployeesMonthly($CheckDate,$CheckNumber,$DateHired,$DeductionAmount,$DeductionCode,$DeductionDesc,$DeptName,$FirstName,$MiddleName,$LastName,$NationalId,$Sex,$VoteName,$Votecode,$created_at);
	}
}
}
