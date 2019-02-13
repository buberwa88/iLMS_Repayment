<?php

namespace backend\modules\repayment\models;

use Yii;
use backend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\repayment\models\Employer;
use backend\modules\repayment\models\LoanSummaryDetail;

/**
 * This is the model class for table "loan_summary".
 *
 * @property integer $loan_summary_id
 * @property integer $employer_id
 * @property integer $applicant_id
 * @property string $bill_number
 * @property double $amount
 * @property string $created_at
 * @property integer $created_by
 *
 * @property LoanRepaymentDetail[] $LoanRepaymentDetails
 * @property Applicant $applicant
 * @property Employer $employer
 * @property User $createdBy
 * @property LoanSummaryDetail[] $LoanSummaryDetails
 */
class LoanSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loan_summary';
    }

    /**
     * @inheritdoc
     */
    public $employer_name;
    public $Employer_Code;
    public $Bill_Ref_No;
    public $traced_by;
    public $number_of_employees;
    public $dateSubmitted;
    public $amountx;
    public $principal;
    public $penalty;
    public $LAF;
    public $VRF;
    public $totalLoan;
    public $outstanding_debt;
    public $VrfSinceLastPayment;
	public $paid;
	public $firstname; 
	public $middlename;
	public $surname;
	public $f4indexno;
    public function rules()
    {
        return [
            [['employer_id', 'applicant_id', 'created_by', 'status'], 'integer'],
            //[['reference_number', 'amount', 'created_at', 'created_by'], 'required'],
            //[['amount'], 'number'],
            [['created_at', 'status', 'employer_name', 'Employer_Code', 'Bill_Ref_No', 'traced_by', 'number_of_employees', 'dateSubmitted', 
                'amountx', 'description', 'principal', 'penalty', 'LAF', 'VRF', 'totalLoan','outstanding_debt','VrfSinceLastPayment','paid','firstname','middlename','surname','f4indexno'], 'safe'],
            [['reference_number'], 'string', 'max' => 50],
            [['reference_number'], 'unique', 'message' =>'Bill number already exist'],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_summary_id' => 'Loan Repayment Bill ID',
            'employer_id' => 'Employer ID',
            'applicant_id' => 'Applicant ID',
            'reference_number' => 'Reference Number',
            'amount' => 'Amount(TZS)',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status'=>'Status',
            'employer_name'=>'Employer Name',
            'Employer_Code'=>'Employer Code',
            'Bill_Ref_No'=>'Bill Ref.No',
            'traced_by'=>'Traced by',
            'number_of_employees'=>'Number of employees',
            'dateSubmitted'=>'Bill Date',
            'description'=>'Narration(Optional)',
            'amountx'=>'Amount(TZS)',
            'principal'=>'Principal',
            'penalty'=>'Penalty',
            'LAF'=>'LAF',
            'VRF'=>'VRF',
            'totalLoan'=>'Total Loan',
            'outstanding_debt'=>'Outstanding Debt',
            'VrfSinceLastPayment'=>'VRF Since last payment',
			'paid'=>'Paid',
			'firstname'=>'First Name',
			'middlename'=>'Middle Name',
			'surname'=>'Last Name',
			'f4indexno'=>'Form IV Index Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentDetails()
    {
        return $this->hasMany(LoanRepaymentDetail::className(), ['loan_summary_id' => 'loan_summary_id']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployedBeneficiary()
    {
        return $this->hasMany(EmployedBeneficiary::className(), ['loan_summary_id' => 'loan_summary_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSummaryDetails()
    {
        return $this->hasMany(LoanSummaryDetail::className(), ['loan_summary_id' => 'loan_summary_id']);
    }
    public function checkTorequestBill($employerId){
        $details_bill = EmployedBeneficiary::find()
                            ->where(['employer_id'=>$employerId,'loan_summary_id'=>NULL])
                            ->limit(1)->one();
        return $details_bill;
        }
        
    public static function getEmployerDetails($employerId){
        $details_employer = Employer::find()
                            ->where(['employer_id'=>$employerId])
                            ->limit(1)->one();
        return $details_employer;
        }  
    public function updateEmployerBillRequestStatus($employerID,$dateRequested){
        //Employer::updateAll(['loan_summary_requested' =>'1','loan_summary_requested_date'=>$dateRequested], 'employer_id ="'.$employerID.'"');
		return 0;
 }
    public static function getLastBillID($employerID){
      $details_bill_number = LoanSummary::findBySql("SELECT reference_number FROM loan_summary WHERE  employer_id='$employerID' ORDER BY loan_summary_id DESC")->one();
      $bill=$details_bill_number->reference_number;     
      $billValue = (count($bill) == 0) ? '0' : $bill;
      if($billValue==0){
        $bill_new=0 + 1;  
      }else{
        $bill_number=explode("-",$bill); 
        $bill_new=$bill_number[2] + 1;
      }
        return $bill_new;
        }
    public function updateEmployerBillReply($employerID){
        //Employer::updateAll(['loan_summary_requested' =>'0'], 'employer_id ="'.$employerID.'"');
		return 0;
 }
    public function updateLoaneeBill1($loan_summary_id,$bill_status,$created_at,$description,$vrf_accumulated,$amount,$vrf_last_date_calculated){
        $this->updateAll(['status' =>$bill_status,'created_at'=>$created_at,'description'=>$description,'vrf_accumulated'=>$vrf_accumulated,'amount'=>$amount,'vrf_last_date_calculated'=>$vrf_last_date_calculated], 'loan_summary_id ="'.$loan_summary_id.'"');
 }
    public static function updateCeasedBill($employerID){
       LoanSummary::updateAll(['status' =>'4'], 'employer_id ="'.$employerID.'" AND status="5"');
 }
 public static function updateCeasedAllPreviousActiveBillUnderEmployer($employerID,$Recent_loan_summary_id){
       LoanSummary::updateAll(['status' =>'4'], 'employer_id ="'.$employerID.'" AND loan_summary_id<>"'.$Recent_loan_summary_id.'"');
 }
    public function getTotalPaidunderBill($LoanSummaryID){
     $payments=new LoanRepaymentDetail();
 $amount=$payments->getAmountTotalPaidunderBill($LoanSummaryID);
 $value = (count($amount) == 0) ? '0' : $amount;
 return $value;
 }
    public function ceaseBillIfNewEmployeeAdded($employerID){
    $this->updateAll(['status' =>'5'], 'employer_id="'.$employerID.'" AND (status="0" OR status="1")');
 }
    public function getBillRequestedLoaneePending($loan_summary_id){
      $details_bill = $this->findBySql("SELECT * FROM loan_summary WHERE  loan_summary_id='$loan_summary_id'")->one();
      $bill=$details_bill->loan_summary_id;     
      $billValue = (count($bill) == 0) ? '0' : $details_bill;
        return $billValue;
        }
	public static function insertNewValuesAfterTermination($employerID,$totalAcculatedLoan,$billNumber,$status,$description,$created_by,$created_at,$vrf_accumulated,$vrf_last_date_calculated){
	Yii::$app->db->createCommand()
        ->insert('loan_summary', [
        'employer_id' =>$employerID,
        'amount' =>$totalAcculatedLoan,
        'reference_number' =>$billNumber,
        'status' =>$status,
        'description' =>$description, 
        'created_by' =>$created_by,
        'created_at' =>$created_at,
        'vrf_accumulated' =>$vrf_accumulated,
        'vrf_last_date_calculated' =>$vrf_last_date_calculated,  		
        ])->execute();
	}
    public static function getLastLoanSummaryID($employerID){
      $loan_summary_id = LoanSummary::findBySql("SELECT * FROM loan_summary WHERE  employer_id='$employerID' ORDER BY loan_summary_id DESC")->one();
      $id=$loan_summary_id->loan_summary_id;     
      $billValue = (count($id) == 0) ? '0' : $id;
        return $billValue;
        }
    public static function updateCeaseIndividualBeneficiaryLoanSummaryWhenEmployed($applicantID,$Recent_loan_summary_id){
       LoanSummary::updateAll(['status' =>'4'], 'applicant_id ="'.$applicantID.'" AND loan_summary_id<>"'.$Recent_loan_summary_id.'" AND (status<>"2" AND status<>"4" AND status<>"3")');
 }
public static function updateLoanSummaryAmount($employerID,$Recent_loan_summary_id){
$totalAmount = LoanSummaryDetail::findBySql('SELECT SUM(amount) AS "amount" FROM loan_summary_detail WHERE  loan_summary_id="'.$Recent_loan_summary_id.'"')->one();
$amount=$totalAmount->amount;
       LoanSummary::updateAll(['amount' =>$amount], 'employer_id ="'.$employerID.'" AND loan_summary_id="'.$Recent_loan_summary_id.'"');
 }
public static function updateNewTotalAmountLoanSummary($loan_summary_id,$amount) {
	   $updated_at=date("Y-m-d H:i:s");
	   $updated_by=Yii::$app->user->identity->user_id;
       self::updateAll(['amount' =>$amount,'updated_at'=>$updated_at,'updated_by'=>$updated_by], 'loan_summary_id="'.$loan_summary_id.'"');
} 
}
