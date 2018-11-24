<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use backend\modules\repayment\models\PayMethod;
use frontend\modules\repayment\models\LoanRepayment;
use frontend\modules\repayment\models\LoanRepaymentDetailSearch;

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

    public function rules()
    {
        return [
            [['employer_id', 'applicant_id', 'pay_method_id'], 'integer'],
            [['amount','repaymentID'], 'required','on'=>'paymentAdjustmentLoanee'],
            [['amount'], 'number','on'=>'paymentAdjustmentLoanee'],
	    [['payment_date'], 'required','on'=>'billGeneration'],
            [['employerId_bulk'], 'required','on'=>'bulkBillTreasury'],
            [['payment_date'], 'required','on'=>'billConfirmationTreasury'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received','totalEmployees','payment_status','amount', 'pay_method_id', 'amountApplicant', 'total_loan', 'amount_paid', 'balance','f4indexno','principal','penalty','LAF','vrf','totalLoan','outstandingDebt','repaymentID','loan_summary_id','amountx','payment_date','print','treasury_user_id','employerId_bulk','salarySource'], 'safe'],
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
            'amount' => 'Amount(TZS)',
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
			'payment_date'=>'Date of Bill',
                        'print'=>'Print',
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
    public function checkControlNumberStatus($employerID){
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.employer_id='$employerID'")->one();
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        }
    public function checkControlNumberStatusLoanee($applicantID){
        $existPendingControlNumber = $this->findBySql("SELECT * FROM loan_repayment "
                . "WHERE  loan_repayment.payment_status IS NULL AND loan_repayment.date_receipt_received IS NULL AND loan_repayment.applicant_id='$applicantID'")->one();
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
        
    public function getAmountRequiredForPayment($loan_repayment_id){
        $moder=new EmployedBeneficiary();
        $CFBS="CFBS";
        $CFBS_id=$moder->getloanRepaymentItemID($CFBS); 
       $details_amount = LoanRepaymentDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_repayment_detail  WHERE  loan_repayment_detail.loan_repayment_id='$loan_repayment_id' AND loan_repayment_detail.loan_repayment_item_id<>'$CFBS_id'")->one();
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
    public function updateConfirmPaymentandControlNo($loan_repayment_id,$controlNumber){
        $date=date("Y-m-d H:i:s");
     $this->updateAll(['date_control_received'=>$date,'control_number'=>$controlNumber,'payment_status'=>'0'], 'loan_repayment_id ="'.$loan_repayment_id.'" AND (control_number="" OR control_number IS NULL)');       
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
        $model=new LoanSummary();
		$date_control_received=date("Y-m-d H:i:s");
		$receiptDate=date("Y-m-d H:i:s");
		$receiptNumber=rand(100,1000);
        $this->updateAll(['payment_status' =>'1','date_control_received'=>$date_control_received,'receipt_date'=>$receiptDate,'date_receipt_received'=>$receiptDate,'receipt_number'=>$receiptNumber], 'control_number ="'.$controlNumber.'" AND amount ="'.$amount.'" AND payment_status ="0"');
        $details = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id' FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber'")->one();
        $loan_summary_id=$details->loan_summary_id;
        $model->updateAll(['status' =>'1'], 'loan_summary_id ="'.$loan_summary_id.'" AND status<>2 AND status<>5 AND status<>4');
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
public static function checkPaymentsEmployer($employerID,$firstDayPreviousMonth,$deadlineDateOfMonth){
	$details =  LoanRepayment::findBySql("SELECT * FROM loan_repayment WHERE  employer_id='$employerID' AND payment_status='1' AND payment_date >='$firstDayPreviousMonth' AND payment_date <='$deadlineDateOfMonth'")->count();
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
}
