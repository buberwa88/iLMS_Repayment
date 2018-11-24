<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\Employer;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use frontend\modules\repayment\models\LoanSummaryDetail;
use backend\modules\repayment\models\LoanRepaymentSetting;
use backend\modules\repayment\models\LoanRepaymentItem;

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
    public $paid;
    public $outstanding;
    public function rules()
    {
        return [
            [['employer_id', 'applicant_id', 'created_by', 'status'], 'integer'],
            //[['reference_number', 'amount', 'created_at', 'created_by'], 'required'],
            [['amount'], 'number'],
            [['created_at', 'status', 'employer_name', 'Employer_Code', 'Bill_Ref_No', 'traced_by', 'number_of_employees', 'dateSubmitted', 
                'amountx', 'description', 'principal', 'penalty', 'LAF', 'VRF', 'totalLoan','paid','outstanding','vrf_accumulated','vrf_last_date_calculated'], 'safe'],
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
            'created_at' => 'Bill Created At',
            'created_by' => 'Created By',
            'status'=>'Bill Status',
            'employer_name'=>'Employer Name',
            'Employer_Code'=>'Employer Code',
            'Bill_Ref_No'=>'Bill Ref.No',
            'traced_by'=>'Traced by',
            'number_of_employees'=>'Number of employees',
            'dateSubmitted'=>'Date Submitted',
            'description'=>'Narration(Optional)',
            'amountx'=>'Amount(TZS)',
            'principal'=>'Principal',
            'penalty'=>'Penalty',
            'LAF'=>'LAF',
            'VRF'=>'VRF',
            'totalLoan'=>'Total Loan',
            'paid'=>'Paid(TZS)',
            'outstanding'=>'Outstanding(TZS)',
            'vrf_accumulated'=>'VRF Accumulated',
            'vrf_last_date_calculated'=>'VRF last date calculated',
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
        
    public function getEmployerDetails($employerId){
        $details_employer = Employer::find()
                            ->where(['employer_id'=>$employerId])
                            ->limit(1)->one();
        return $details_employer;
        }  
    public function updateEmployerBillRequestStatus($employerID,$dateRequested){
        Employer::updateAll(['loan_summary_requested' =>'1','loan_summary_requested_date'=>$dateRequested], 'employer_id ="'.$employerID.'"');
 }
        
    public function getLastBillIDApplicant($applicantID){
      $details_bill_number = $this->findBySql("SELECT reference_number FROM loan_summary WHERE  applicant_id='$applicantID' AND bill_number LIKE 'BEN%' ORDER BY loan_summary_id DESC")->one();
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
        
    public function getActiveBill($employerID){
      $details_bill = $this->findBySql("SELECT * FROM loan_summary WHERE  employer_id='$employerID' AND (status='0' OR status='1') ORDER BY loan_summary_id DESC")->one();
      $bill=$details_bill->loan_summary_id;     
      $billValue = (count($bill) == 0) ? '0' : $details_bill;
        return $billValue;
        }
    public function getActiveBillLoanee($applicantID){
      $details_bill = $this->findBySql("SELECT * FROM loan_summary WHERE  applicant_id='$applicantID' AND (status='0' OR status='1') ORDER BY loan_summary_id DESC")->one();
      $bill=$details_bill->loan_summary_id;     
      $billValue = (count($bill) == 0) ? '0' : $details_bill;
        return $billValue;
        }
    public function updateEmployerBillReply($employerID){
        Employer::updateAll(['loan_summary_requested' =>'0'], 'employer_id ="'.$employerID.'"');
 }
 public function getTotalPaidunderBill($LoanSummaryID){
     $payments=new LoanRepaymentDetail();
 $amount=$payments->getAmountTotalPaidunderBill($LoanSummaryID);
 $value = (count($amount) == 0) ? '0' : $amount;
 return $value;
 }
 
public function getTotalPaidunderBillIndividualEmployee($LoanSummaryID,$applicantID){
     $payments=new LoanRepaymentDetail();
 $amount=$payments->getAmountTotalPaidunderBillIndividualEmployee($LoanSummaryID,$applicantID);
 $value = (count($amount) == 0) ? '0' : $amount;
 return $value;
 }
 public function getActiveBillToUpdateVRFofEmployees($employerID){
      $details_bill = $this->findBySql("SELECT * FROM loan_summary WHERE  employer_id='$employerID' AND (status='0' OR status='1') ORDER BY loan_summary_id DESC")->one();
      $billID=$details_bill->loan_summary_id;     
      $billValue = (count($billID) == 0) ? '0' : $billID;
      
      if($billValue > 0){
       $vrf_accumulated=$details_bill->vrf_accumulated;
       $lastVRFdate=$details_bill->vrf_last_date_calculated;
       // here to get number of days
       $todate=date("Y-m-d");
       $date1=date_create($lastVRFdate);
       $date2=date_create($todate);
       $diff=date_diff($date1,$date2);
       $totalDays=$diff->format("%a");
       //end for total number of days
       if($totalDays > 0 && $todate > $lastVRFdate){
       $employedBeneficiary=new EmployedBeneficiary();  
       $LoanSummaryDetailModel=new LoanSummaryDetail();
       $i=0;
       $loanRepaymentDetails = LoanSummaryDetail::findBySql("SELECT  * FROM loan_summary_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_summary_detail.loan_repayment_item_id "
                . "WHERE  loan_summary_detail.loan_summary_id='$billID' AND loan_repayment_item.item_code='VRF'")->all();
                    foreach ($loanRepaymentDetails as $loanRepaymentResults) {
                    $amount=$loanRepaymentResults->amount;
                    $applicantID=$loanRepaymentResults->applicant_id;
                    $loan_repayment_item_id=$loanRepaymentResults->loan_repayment_item_id;
                    $loan_summary_id=$loanRepaymentResults->loan_summary_id;
                    $outstandingPrincipalLoan=$employedBeneficiary->getOutstandingPrincipalLoan($applicantID);

                    if($outstandingPrincipalLoan > 0){
					/*
                     $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
                     $VRF=$details_VRF->percent;   
					 */
					 $details_VRF=$employedBeneficiary->getVRFsetting();
                     $VRF=$details_VRF->percent;
					 
                     $accumulatedVRF=($totalDays * $VRF * $outstandingPrincipalLoan)/365;
                     $amountTotal=$amount + $accumulatedVRF;
                     $LoanSummaryDetailModel->updateBeneficiaryVRFaccumulated($amountTotal,$accumulatedVRF,$applicantID,$loan_summary_id,$loan_repayment_item_id);
                     $vrf_accumulated +=$accumulatedVRF;
                    }
                    
                    ++$i;
                    }
        $this->updateAll(['vrf_last_date_calculated' =>$todate,'vrf_accumulated' =>$vrf_accumulated], 'loan_summary_id ="'.$billID.'"');
       }
      }
      
       // return $billValue;
        }
    public function ceaseBillIfEmployedBeneficiaryDisabled($LoanSummaryID,$employerID){
    $this->updateAll(['status' =>'5'], 'loan_summary_id ="'.$LoanSummaryID.'" AND employer_id="'.$employerID.'"');
 }
    public function ceaseBillIfNewEmployeeAdded($employerID){
    $this->updateAll(['status' =>'5'], 'employer_id="'.$employerID.'" AND (status="0" OR status="1")');
 }
    public function insertBillRequestApplicant($status,$applicantID,$bill_number,$created_by,$created_at,$amount){
    Yii::$app->db->createCommand()
        ->insert('loan_summary', [
        'applicant_id' =>$applicantID,
        'reference_number' =>$bill_number,
        'amount' =>$amount,
        'status' =>$status,
        'created_by' =>$created_by,
        'created_at' =>$created_at,    
        ])->execute();
 }
 public function getBillRequestedPending($applicantID){
      $details_bill = $this->findBySql("SELECT * FROM loan_summary WHERE  applicant_id='$applicantID' AND status='7' ORDER BY loan_summary_id DESC")->one();
      $bill=$details_bill->loan_summary_id;     
      $billValue = (count($bill) == 0) ? '0' : $details_bill;
        return $billValue;
        }
}
