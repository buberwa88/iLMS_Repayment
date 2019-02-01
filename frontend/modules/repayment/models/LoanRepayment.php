<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use backend\modules\repayment\models\PayMethod;
//use frontend\modules\repayment\models\LoanRepayment;
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
	 const EMPLOYER_BILL_FORMAT="RPEMP";
	 const BENEFICIARY_BILL_FORMAT="RPBEN";
	 const TREAURY_BILL_FORMAT="RPTRE";
	 const EMPLOYER_PENALTY_BILL_FORMAT="EPPNT";
     const LOAN_REPAYMENT_GFSCODE="140314";//TO ASK HESLB
	 const EMPLOYER_PENALTY_GFSCODE="140315";//TO ASK HESLB
     const LOAN_REPAYMENT_BILL_DESC="Loan Repayment";//TO ASK HESLB
	 const EMPLOYER_PENALTY_BILL_DESC="Employer Penalty";//to ask HESLB
     const BILL_EXPIRE_DATE_LOAN_REPAYMENT=90;//TO ASK HESLB
	 const BILL_EXPIRE_DATE_EMPLOYER_PENALTY=90;//TO ASK HESL
	 const TESTING_REPAYMENT_LOCAL="T";//N
	 
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
	public $employer_code;
	public $employer_name;
	public $phone_number;
	public $email_address;
	public $name;

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
            [['date_bill_generated', 'date_control_received', 'date_receipt_received','totalEmployees','payment_status','amount', 'pay_method_id', 'amountApplicant', 'total_loan', 'amount_paid', 'balance','f4indexno','principal','penalty','LAF','vrf','totalLoan','outstandingDebt','repaymentID','loan_summary_id','amountx','payment_date','print','treasury_user_id','employerId_bulk','salarySource','receipt_date','vote_number','Vote_name','gepg_lawson_id','lowason_check_date','employer_code','employer_name','phone_number','email_address','name'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 100],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
            [['pay_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\PayMethod::className(), 'targetAttribute' => ['pay_method_id' => 'pay_method_id']],
            [['treasury_payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['treasury_payment_id' => 'loan_repayment_id']],
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
                . "WHERE  loan_repayment.control_number='$controlNumber' AND loan_repayment_detail.applicant_id > 0 GROUP BY loan_repayment_detail.applicant_id ORDER BY loan_repayment_detail.loan_repayment_detail_id DESC")->all();
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
                . "WHERE  loan_repayment.control_number='$controlNumber' AND loan_repayment_detail.applicant_id > 0 GROUP BY loan_repayment_detail.applicant_id ORDER BY loan_repayment_detail.loan_repayment_detail_id DESC")->all();
				foreach($detailsAllApplicants AS $resultsApp){
        $loan_summary_id=$resultsApp->loan_summary_id;
		$applicantID=$resultsApp->applicant_id;
		$loanRepaymentId=$resultsApp->loan_repayment_id;
		$loan_repayment_item_id=$resultsApp->loan_repayment_item_id;
		\frontend\modules\repayment\models\LoanRepaymentDetail::updateLoanBalanceToBeneficiaryAfterEveryPayment($loan_summary_id,$applicantID,$loan_given_to,$loanRepaymentId,$loan_repayment_item_id);
		
		$loanPaidExistsCount=LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_repayment_id,loan_repayment_detail.amount FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.payment_status='1' GROUP BY loan_repayment_detail.applicant_id,loan_repayment.bill_number")->count();
		if($loanPaidExistsCount== 1){
		\frontend\modules\repayment\models\LoanRepaymentDetail::updateVRFBeforeRepayment($loan_summary_id,$applicantID,$loan_given_to);
				}
	}
		//end
 }

public static function updatePaymentAfterGePGconfirmPaymentDonelive($controlNumber,$paid_amount,$date_receipt_received,$receiptDate,$receiptNumber){
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
		$model=new LoanSummary();		
		//here to update the acrued VRF from last payment after payment confirmed
		$detailsAllApplicantVRF = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id',loan_repayment_detail.applicant_id,loan_repayment_detail.loan_repayment_id,loan_repayment_detail.loan_repayment_item_id,loan_repayment.receipt_date  FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber' AND loan_repayment_detail.applicant_id > 0 GROUP BY loan_repayment_detail.applicant_id ORDER BY loan_repayment_detail.loan_repayment_detail_id DESC")->all();
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
		self::updateAll(['payment_status' =>'1','receipt_date'=>$receiptDate,'date_receipt_received'=>$date_receipt_received,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND payment_status ="0"');
        $details = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id',loan_repayment_detail.applicant_id,loan_repayment_detail.loan_repayment_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber'")->one();
        $loan_summary_id=$details->loan_summary_id;       $model->updateAll(['status' =>'1'], 'loan_summary_id ="'.$loan_summary_id.'" AND status<>2 AND status<>5 AND status<>4');
		
		//here to update the loan balance after payment confirmed
		$detailsAllApplicants = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id',loan_repayment_detail.applicant_id,loan_repayment_detail.loan_repayment_id,loan_repayment_detail.loan_repayment_item_id FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber' AND loan_repayment_detail.applicant_id > 0 GROUP BY loan_repayment_detail.applicant_id ORDER BY loan_repayment_detail.loan_repayment_detail_id DESC")->all();
				foreach($detailsAllApplicants AS $resultsApp){
        $loan_summary_id=$resultsApp->loan_summary_id;
		$applicantID=$resultsApp->applicant_id;
		$loanRepaymentId=$resultsApp->loan_repayment_id;
		$loan_repayment_item_id=$resultsApp->loan_repayment_item_id;
		\frontend\modules\repayment\models\LoanRepaymentDetail::updateLoanBalanceToBeneficiaryAfterEveryPayment($loan_summary_id,$applicantID,$loan_given_to,$loanRepaymentId,$loan_repayment_item_id);
		
		$loanPaidExistsCount=LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_repayment_id,loan_repayment_detail.amount FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_given_to='$loan_given_to' AND loan_repayment.payment_status='1' GROUP BY loan_repayment_detail.applicant_id AND loan_repayment.bill_number")->count();
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
        self::updateAll(['amount'=>$totalAmount1], 'loan_repayment_id ="'.$loan_repayment_id.'"');
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
        $existIncompleteBill = self::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.applicant_id='$applicantID'")->one();
		if(count($existIncompleteBill)>0){
		$details=$existIncompleteBill; 
		}else{
		$details=0;
		}
        return $details;
        }
    public function checkUnCompleteBillEmployer($employerID){
        $existIncompleteBill = self::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.employer_id='$employerID'")->one();
		if(count($existIncompleteBill)>0){
		$details=$existIncompleteBill; 
		}else{
		$details=0;
		}
        return $details;
        }
        
    public static function checkBillPendingGovernmentEmployers(){
        $existPendingControlNumber = self::findBySql("SELECT loan_repayment.loan_repayment_id AS loan_repayment_id FROM loan_repayment INNER JOIN employer ON loan_repayment.employer_id=employer.employer_id "
                . "WHERE  (loan_repayment.control_number IS NULL OR loan_repayment.control_number='') AND loan_repayment.payment_status='0' AND employer.salary_source='1'")->one();
		if(count($existPendingControlNumber)>0){
		$results=1;
		}else{
		$results=0;
		}	
        return $results;
        }
     public static function checkUnCompleteBillTreasury(){
        $existIncompleteBill = self::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.employer_id IS NULL AND loan_repayment.applicant_id IS NULL")->one();
		if(count($existIncompleteBill)>0){
		$details=$existIncompleteBill; 
		}else{
		$details=0;
		}
        return $details;
        }
    public static function checkControlNumberStatusTreasury(){
        $existPendingControlNumber = self::findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.employer_id IS NULL AND loan_repayment.applicant_id IS NULL")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        }
    public static function getAmountRequiredForPaymentTreasury($treasury_payment_id){
       $details_amount = self::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_repayment  WHERE  loan_repayment.treasury_payment_id='$treasury_payment_id'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
    public function updateReferenceNumberTreasury($repaymnet_reference_number,$totalAmount1,$treasury_payment_id){
        $date=date("Y-m-d H:i:s");
        self::updateAll(['bill_number' =>$repaymnet_reference_number,'amount'=>$totalAmount1,'date_bill_generated'=>$date], 'loan_repayment_id ="'.$treasury_payment_id.'"');
    }
    public function updateConfirmPaymentandControlNoTreasury($treasury_payment_id,$controlNumber){
        $date=date("Y-m-d H:i:s");
     self::updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'loan_repayment_id ="'.$treasury_payment_id.'" AND (control_number="" OR control_number IS NULL)');
      
	  $details_treasuryPayment =\frontend\modules\repayment\models\LoanRepayment::findBySql("SELECT * FROM loan_repayment WHERE  treasury_payment_id='$treasury_payment_id'")->all();
        
        foreach ($details_treasuryPayment as $paymentTreasuryDetails) { 
           $loan_repayment_id=$paymentTreasuryDetails->loan_repayment_id;
            \frontend\modules\repayment\models\LoanRepayment::updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'loan_repayment_id ="'.$loan_repayment_id.'" AND (control_number="" OR control_number IS NULL)');
	  }
    }
    
    public function updatePaymentAfterGePGconfirmPaymentDoneTreasury($controlNumber,$amount){
        $model=new LoanSummary();
		$date_control_received=date("Y-m-d H:i:s");
                $receiptNumber="T898".mt_rand (10,100);
        \frontend\modules\repayment\models\LoanRepayment::updateAll(['payment_status' =>'1','date_receipt_received'=>$date_control_received,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND amount ="'.$amount.'" AND payment_status ="0"');
        //check if treasury payment is done successful
        $detailsBillStatus = \frontend\modules\repayment\models\LoanRepayment::findBySql("SELECT loan_repayment.payment_status AS 'payment_status',loan_repayment.loan_repayment_id AS 'loan_repayment_id' FROM loan_repayment WHERE  loan_repayment.control_number='$controlNumber' AND employer_id IS NULL AND applicant_id IS NULL")->one();
        $status=$detailsBillStatus->payment_status;
        $treasury_payment_id=$detailsBillStatus->loan_repayment_id;
        //end
        if($status==1){
            \frontend\modules\repayment\models\LoanRepayment::updateAll(['payment_status' =>'1','date_receipt_received'=>$date_control_received,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND treasury_payment_id="'.$treasury_payment_id.'" AND payment_status ="0"');
            
            
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
        return \frontend\modules\repayment\models\LoanRepayment::find()
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
	$details =  \frontend\modules\repayment\models\LoanRepayment::findBySql("SELECT * FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id WHERE  employer_id='$employerID' AND payment_status='1' AND payment_date >='$firstDayPreviousMonth' AND payment_date <='$deadlineDateOfMonth' AND loan_repayment_detail.loan_given_to='$loan_given_to'")->count();
	return $details;
}
public static function checkPaymentsEmployerAcruePenalty($employerID,$checkMonth,$loan_given_to){
	$details =  \frontend\modules\repayment\models\LoanRepayment::findBySql("SELECT loan_repayment_detail.* FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id WHERE  employer_id='$employerID' AND loan_repayment_detail.loan_given_to='$loan_given_to' AND payment_status='1' AND payment_date like '%$checkMonth%'")->count();
	return $details;
}
public static function createAutomaticBills($payment_date,$employerID){
	        $modelLoanRepaymentDetail=new LoanRepaymentDetailSearch();
			$modelLoanRepayment = new \frontend\modules\repayment\models\LoanRepayment();
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
            $salarySource=2;
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
			$modelLoanRepayment = new \frontend\modules\repayment\models\LoanRepayment();
			$todate=date("Y-m-d");
			$yeaAndMonth=date("Y-m");
			$checkingDate=$yeaAndMonth."-10";
    if($todate > $checkingDate){
		$prepaidDetails = LoanRepaymentPrepaid::findBySql("SELECT employer_id,payment_date,bill_number,loan_summary_id,control_number,receipt_number,date_bill_generated,date_control_received,receipt_date,date_receipt_received,payment_status FROM loan_repayment_prepaid WHERE  payment_date='$checkingDate' AND monthly_deduction_status='0' AND payment_status='1'")->groupBy('employer_id')->all();
	        foreach($prepaidDetails AS $prepaidDetailsResults){
			$modelLoanRepayment = new \frontend\modules\repayment\models\LoanRepayment();
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
    $treasuryDetail = \common\models\user::findBySql("SELECT user_id "
                . "FROM user WHERE  login_type='6'")->one();
				$user_id=$treasuryDetail->user_id;

        Yii::$app->db->createCommand()
            ->insert('gepg_lawson', [
                'bill_number' => $bill_number,
                'amount' => $amount,
                'deduction_month' => $deduction_month,
                'control_number_date' => $control_number_date,
                'check_date' => $CheckDate,
				'user_id'=>$user_id,
            ])->execute();

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
 //Yii::$app->db->createCommand("INSERT INTO  loan_repayment(employer_id,bill_number,amount,payment_date,date_bill_generated,vote_number,Vote_name,gepg_lawson_id,lowason_check_date,payment_status,payment_category) VALUES('$getEmployerIDx','$bill_number','$amount','$deduction_month','$date_bill_generated','$Votecode','$VoteName','$gepg_lawson_id','$CheckDate','$paymentStatus','1')")->execute();

        Yii::$app->db->createCommand()
            ->insert('loan_repayment', [
                'employer_id' => $getEmployerIDx,
                'bill_number' => $bill_number,
                'amount' => $amount,
                'payment_date' => $deduction_month,
                'date_bill_generated' => $date_bill_generated,
                'vote_number' => $Votecode,
                'Vote_name' => $VoteName,
                'gepg_lawson_id' => $gepg_lawson_id,
                'lowason_check_date' => $CheckDate,
                'payment_status' => $paymentStatus,
                'payment_category' =>'1',
            ])->execute();
}	
	}
public static function updateTotalAmountUnderEmployerBillGSPP($totalAmount1,$loan_repayment_id){
        self::updateAll(['amount'=>$totalAmount1], 'loan_repayment_id ="'.$loan_repayment_id.'"'); 
    }
	
public static function generalFunctControlNumber($billNumber,$controlNumber,$date_control_received){
	 \frontend\modules\repayment\models\GepgLawson::updateAll(['gepg_date'=>$date_control_received,'control_number'=>$controlNumber,'status'=>'1'], 'bill_number ="'.$billNumber.'"');	
     self::updateAll(['date_control_received'=>$date_control_received,'control_number'=>$controlNumber], 'bill_number ="'.$billNumber.'"');      
        }
public static function requestMonthlyDeduction($fileDeductions,$paymentMonth,$paymentYear){
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

   //$deduction_month=date("Y-m")."-".\frontend\modules\repayment\models\LoanRepayment::DEDUCTION_DATE_REQUEST;
   $deduction_month=$paymentYear."-".$paymentMonth."-".\frontend\modules\repayment\models\LoanRepayment::DEDUCTION_DATE_REQUEST;
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
   if($CheckDate !=''){
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
	}
    if($CheckDate !=''){
	\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidGSPP($CheckDate);
	\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidPerLoanRepayment($CheckDate);
}
}
public static function requestMonthlyDeductionSummary($fileDeductionsSummary){
$results = json_decode(json_encode((array)simplexml_load_string($fileDeductionsSummary)),true);
		$ArrayOfDeductionSummary = $results['DeductionSummary'];
		//$cavaca=$results['DeductionSummary'];
		$DeductionSummaryCount=simplexml_load_string($fileDeductionsSummary);
		$countDeductionSummary=count($DeductionSummaryCount->DeductionSummary);
		//exit;
$finalTotalDeductions=0;
$finalTotalEmployees=0;
		if($countDeductionSummary > 1){
$si=0;			
    foreach ($ArrayOfDeductionSummary as $summaryDeductions) {

    $trans_date = date('Y-m-d H:i:s');	
	$CheckDate = date("Y-m-d",strtotime(trim($summaryDeductions['CheckDate'])));
	$TotalDeductionAmount = trim($summaryDeductions['TotalDeductionAmount']);
	$NumEmployee=trim($summaryDeductions['NumEmployee']);
	$finalTotalDeductions +=$TotalDeductionAmount;
	$finalTotalEmployees +=$NumEmployee;
    
   //echo 'TotalDeductionAmount: '.$TotalDeductionAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."Done1"."<br/>";
  ++$si; 
 
}
	}else{

	$CheckDate = date("Y-m-d",strtotime(trim($ArrayOfDeductionSummary['CheckDate'])));
    if($CheckDate !=''){
	$TotalDeductionAmount = trim($ArrayOfDeductionSummary['TotalDeductionAmount']);
	$NumEmployee=trim($ArrayOfDeductionSummary['NumEmployee']);
    $finalTotalDeductions=$TotalDeductionAmount;
    $finalTotalEmployees=$NumEmployee;
  //echo 'TotalDeductionAmount: '.$TotalDeductionAmount."<br/>".'CheckDate: '.$CheckDate."<br/>"."Done2";
	}
	}
	//the below function to run after receiving summary
	if($CheckDate !=''){
	$GSPPamountSummary=$finalTotalDeductions;
    $finalTotalEmployees=$finalTotalEmployees;
	\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountPaidGSPPsummary($CheckDate,$GSPPamountSummary,$finalTotalEmployees);
	\frontend\modules\repayment\models\LoanRepaymentDetail::checkRepaymentAndGSPPamount($CheckDate);	
	\frontend\modules\repayment\models\LoanRepaymentDetail::checkGepgStatus();
	//end
	}
}
public static function requestAllEmployeesMonthly($fileAllEmployMonthly){
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

public static function getEmployerDetailsForBilling($loan_repayment_id){
        $details = self::findBySql("SELECT  loan_repayment.bill_number,loan_repayment.amount,employer.employer_code,employer.employer_name,loan_repayment.date_bill_generated,employer.phone_number,employer.email_address,loan_repayment.loan_repayment_id  FROM loan_repayment INNER JOIN employer ON loan_repayment.employer_id=employer.employer_id  WHERE  loan_repayment.loan_repayment_id='$loan_repayment_id' AND loan_repayment.payment_status=0")->one();

    $dataToQueue = [
        "bill_number" => $details->bill_number,
        "amount"=>$details->amount,
        "bill_type"=>\frontend\modules\repayment\models\LoanRepayment::LOAN_REPAYMENT_GFSCODE,
        "bill_description"=>\frontend\modules\repayment\models\LoanRepayment::LOAN_REPAYMENT_BILL_DESC,
        "bill_gen_date"=>date('Y-m-d' . '\T' . 'H:i:s',strtotime($details->date_bill_generated)),
        "bill_gernerated_by"=>$details->employer_name,
        "bill_payer_id"=>$details->employer_code,
        "payer_name"=>$details->employer_name,
        "payer_phone_number"=>$details->phone_number,
        "bill_expiry_date"=>\frontend\modules\repayment\models\LoanRepayment::BILL_EXPIRE_DATE_LOAN_REPAYMENT,
        "bill_reference_table_id"=>$details->loan_repayment_id,
        "bill_reference_table"=>"loan_repayment",
		"primary_keycolumn"=>"loan_repayment_id",
    ];

        return $dataToQueue;
}
public static function updateControlngepgrealy($control_number,$bill_number,$date_control_received){
	    $billNumber=$bill_number;
        $billPrefix = substr($billNumber, 0, 5);
		if($billPrefix=='RPTRE'){
		\frontend\modules\repayment\models\GepgLawson::updateAll(['gepg_date'=>$date_control_received,'control_number'=>$control_number,'status'=>'1'], 'bill_number ="'.$bill_number.'"');	
		}		
        self::updateAll(['date_control_received'=>$date_control_received,'control_number'=>$control_number,'payment_status'=>0], 'bill_number ="'.$bill_number.'" AND (control_number="" OR control_number IS NULL)');        
    }
public static function getBeneficiaryDetailsForBilling($loan_repayment_id){
        $details = self::findBySql("SELECT  loan_repayment.bill_number,loan_repayment.amount,CONCAT(user.firstname.' '.user.middlename.' '.user.surname) AS 'name',loan_repayment.date_bill_generated,user.phone_number,loan_repayment.loan_repayment_id  FROM loan_repayment INNER JOIN applicant ON loan_repayment.applicant_id=applicant.applicant_id INNER JOIN user ON user.user_id=applicant.user_id WHERE  loan_repayment.loan_repayment_id='$loan_repayment_id' AND loan_repayment.payment_status=0")->one();

    $dataToQueue = [
        "bill_number" =>$details->bill_number,
        "amount"=>$details->amount,
        "bill_type"=>\frontend\modules\repayment\models\LoanRepayment::LOAN_REPAYMENT_GFSCODE,
        "bill_description"=>\frontend\modules\repayment\models\LoanRepayment::LOAN_REPAYMENT_BILL_DESC,
        "bill_gen_date"=>date('Y-m-d' . '\T' . 'H:i:s',strtotime($details->date_bill_generated)),
        "bill_gernerated_by"=>$details->name,
        "bill_payer_id"=>$details->bill_number,
        "payer_name"=>$details->name,
        "payer_phone_number"=>$details->phone_number,
        "bill_expiry_date"=>\frontend\modules\repayment\models\LoanRepayment::BILL_EXPIRE_DATE_LOAN_REPAYMENT,
        "bill_reference_table_id"=>$details->loan_repayment_id,
        "bill_reference_table"=>"loan_repayment",
		"primary_keycolumn"=>"loan_repayment_id",
    ];

        return $dataToQueue;
}
public static function getBillRepaymentEmployer($employerID,$year){
	return self::findBySql("SELECT * FROM loan_repayment WHERE  payment_date LIKE '$year%' AND employer_id='$employerID'")->count();
}
public static function getBillRepaymentBeneficiary($applicantID,$year){
	return self::findBySql("SELECT * FROM loan_repayment WHERE  payment_date LIKE '$year%' AND applicant_id='$applicantID'")->count();
}
public static function cancelBillgeneral($bill_reference_table,$billNumber,$cancelled_by,$cancelled_date,$cancelled_reason,$bill_reference_table_id,$primary_keycolumn){
	if($bill_reference_table=='gepg_lawson'){
			 $query4 = "UPDATE '".$bill_reference_table."' SET  control_number='CANCELLED',payment_status='3',canceled_by='$cancelled_by',canceled_at='$cancelled_date',cancel_reason='$cancelled_reason',gepg_cancel_request_status='2' WHERE bill_number='".$billNumber."'";
             Yii::$app->db->createCommand($query4)->execute();	
			 $queryN = "UPDATE loan_repayment SET  control_number='CANCELLED',payment_status='3',canceled_by='$cancelled_by',canceled_at='$cancelled_date',cancel_reason='$cancelled_reason',gepg_cancel_request_status='2' WHERE bill_number='".$billNumber."'";
             Yii::$app->db->createCommand($queryN)->execute();
				  }else{
			$query4 = "UPDATE '".$bill_reference_table."' SET  control_number='CANCELLED',payment_status='3',canceled_by='$cancelled_by',canceled_at='$cancelled_date',cancel_reason='$cancelled_reason',gepg_cancel_request_status='2' WHERE bill_number='".$billNumber."'";		  
				  }
}
}
