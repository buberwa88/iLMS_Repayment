<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use backend\modules\repayment\models\PayMethod;
use frontend\modules\repayment\models\LoanRepayment;

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

    public function rules()
    {
        return [
            [['employer_id', 'applicant_id', 'pay_method_id'], 'integer'],
            [['amount'], 'required','on'=>'paymentAdjustmentLoanee'],
            //[['amount'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received','totalEmployees','payment_status','amount', 'pay_method_id', 'amountApplicant', 'total_loan', 'amount_paid', 'balance','f4indexno','principal','penalty','LAF','vrf','totalLoan','outstandingDebt'], 'safe'],
            [['bill_number', 'control_number', 'receipt_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
            [['pay_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\PayMethod::className(), 'targetAttribute' => ['pay_method_id' => 'pay_method_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_repayment_id' => 'Loan Repayment Batch ID',
            'employer_id' => 'Employer ID',
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
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
        } 
        
    public function getPaymentMethod(){
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
        $details=$existPendingControlNumber->loan_repayment_id; 
        $value = (count($details) == 0) ? '0' : $existPendingControlNumber;
        return $value;
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
        $this->updateAll(['payment_status' =>'1'], 'control_number ="'.$controlNumber.'" AND amount ="'.$amount.'" AND payment_status ="0"');
        $details = LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_summary_id AS 'loan_summary_id' FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                . "WHERE  loan_repayment.control_number='$controlNumber'")->one();
        $loan_summary_id=$details->loan_summary_id;
        $model->updateAll(['status' =>'1'], 'loan_summary_id ="'.$loan_summary_id.'"');
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
}
