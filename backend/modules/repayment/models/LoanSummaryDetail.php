<?php

namespace backend\modules\repayment\models;

use Yii;
use backend\modules\repayment\models\EmployedBeneficiary;
use backend\modules\application\models\Application;
use backend\modules\repayment\models\LoanSummaryDetail;
use backend\modules\repayment\models\LoanSummary;

/**
 * This is the model class for table "loan_summary_detail".
 *
 * @property integer $loan_summary_detail_id
 * @property integer $loan_summary_id
 * @property integer $applicant_id
 * @property integer $loan_repayment_item_id
 * @property integer $academic_year_id
 * @property double $amount
 *
 * @property AcademicYear $academicYear
 * @property Applicant $applicant
 * @property LoanSummary $LoanSummary
 * @property LoanRepaymentItem $loanRepaymentItem
 */
class LoanSummaryDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loan_summary_detail';
    }

    /**
     * @inheritdoc
     */
    public $indexno;
    public $fullname;
    public $principal;
    public $penalty;
    public $LAF;
    public $vrf;
    public $totalLoan;
    public $outstandingDebt;
    public $amount1;
	public $firstname; 
	public $middlename;
	public $surname;
	public $f4indexno;
	public $paid;
    public function rules()
    {
        return [
            [['loan_summary_id', 'applicant_id', 'loan_repayment_item_id', 'amount'], 'required'],
            [['loan_summary_id', 'applicant_id', 'loan_repayment_item_id', 'academic_year_id'], 'integer'],
            [['indexno', 'fullname','principal','penalty','LAF','vrf','totalLoan','outstandingDebt','amount1','firstname','middlename','surname','f4indexno','paid','loan_given_to','employer_id','created_by','updated_at','updated_by','vrf_before_repayment','is_full_paid'], 'safe'],
            [['amount'], 'number'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['loan_summary_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanSummary::className(), 'targetAttribute' => ['loan_summary_id' => 'loan_summary_id']],
            [['loan_repayment_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\LoanRepaymentItem::className(), 'targetAttribute' => ['loan_repayment_item_id' => 'loan_repayment_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_summary_detail_id' => 'Loan Repayment Bill Detail ID',
            'loan_summary_id' => 'Loan Repayment Bill ID',
            'applicant_id' => 'Applicant ID',
            'loan_repayment_item_id' => 'Loan Repayment Item ID',
            'academic_year_id' => 'Academic Year ID',
            'amount' => 'Amount(TZS)',
            'indexno'=>'Indexno',
            'fullname'=>'Full Name',
            'principal'=>'Principal Amount',
            'penalty'=>'Penalty',
            'LAF'=>'Loan Adm. Fee',
            'vrf'=>'Value Retention Fee',
            'totalLoan'=>'Total Loan Amount',
            'outstandingDebt'=>'Outstanding Debt',
            'amount1'=>'Amount',
			'firstname'=>'First Name',
			'middlename'=>'Middle Name',
			'surname'=>'Last name',
			'f4indexno'=>'Form IV Index Number',
			'paid'=>'Paid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
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
    public function getLoanSummary()
    {
        return $this->hasOne(LoanSummary::className(), ['loan_summary_id' => 'loan_summary_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentItem()
    {
        return $this->hasOne(\backend\modules\repayment\models\LoanRepaymentItem::className(), ['loan_repayment_item_id' => 'loan_repayment_item_id']);
    }
    
    public static function insertAllBeneficiariesUnderBill($employerID,$loan_summary_id,$category=null){
		$loggedin=Yii::$app->user->identity->user_id;
		$created_at=date("Y-m-d H:i:s");
		$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
		if($category=='Decease'){
		$details_applicantID =EmployedBeneficiary::getActiveBeneficiariesUnderEmployerDuringLoanSummaryCreationDecease($employerID);	
		}else{
		$details_applicantID =EmployedBeneficiary::getActiveBeneficiariesUnderEmployerDuringLoanSummaryCreation($employerID);	
		}        
        //checking for principal
        foreach ($details_applicantID as $value_applicant_id) { 
        $applicantID=$value_applicant_id->applicant_id;        
        self::insertLoaneeBillDetailGeneral($applicantID,$loan_summary_id,$loan_given_to);
		LoanSummary::updateCeaseIndividualBeneficiaryLoanSummaryWhenEmployed($applicantID,$loan_summary_id);
		$newverificationStatus=5;
		EmployedBeneficiary::updateBeneficiaryFromOldEmployer($employerID,$applicantID,$newverificationStatus); 
        EmployedBeneficiary::updateAll(['loan_summary_id' =>$loan_summary_id], 'employer_id ="'.$employerID.'" AND (applicant_id IS NOT NULL OR applicant_id >=1) AND verification_status="1" AND employment_status="ONPOST" AND applicant_id="'.$applicantID.'"');       	
   }       
}
        
        public static function insertAllBeneficiariesUnderBillAfterDeceased($employerID,$loan_summary_id){
		$loggedin=Yii::$app->user->identity->user_id;	
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1'")->all();
        //$details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1' AND loan_summary_id IS NULL")->all();
        $si=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();
        //checking for principal
        foreach ($details_applicantID as $value_applicant_id) { 
        $applicantID=$value_applicant_id->applicant_id;
        
        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
        
        //check if exists in any bill before    
        $details_applicantID = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='".$principal_id."' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantBillID_2=$details_applicantID->loan_summary_id;
        $applicantBillResults_2 = (count($individualApplicantBillID_2) == '0') ? '0' : $individualApplicantBillID_2;
        //end check if exists in any bill before
        
        if($applicantBillResults_2=='0'){
		
		$getDistinctAccademicYrPerApplicant =\common\models\LoanBeneficiary::getAcademicYearTrend($applicantID);
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->disbursementBatch->academic_year_id; 
					$pricipalLoanwettggg=\common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYNoReturned($applicantID,$academicYearID);
                    $pricipalLoan=$pricipalLoanwettggg->disbursed_amount;
                    if($pricipalLoan==''){
                       $pricipalLoan=0; 
                    }
                    //}
		
		/*
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT DISTINCT academic_year_id AS 'academic_year_id' FROM application WHERE  applicant_id='$applicantID'")->all();
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->academic_year_id; 
                    $pricipalLoan=$moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID);
			*/		
					
					
					
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$principal_id,
        'academic_year_id' =>$academicYearID,
        'amount' =>$pricipalLoan,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
                    }
        ++$si;
        }else{  		
		$detailsAmountPrincipalBill=LoanSummaryDetail::getItemsAmountInBill($applicantID,$applicantBillResults_2,$principal_id,$loan_given_to);		
        $PrincipleInBill_2=$detailsAmountPrincipalBill->amount;
		$detailsAmountPrincipalPaid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_2,$principal_id);
        $principalPaidUnderBill_2=$detailsAmountPrincipalPaid->amount;
        $outstandingPrinciple_2=$PrincipleInBill_2-$principalPaidUnderBill_2;
        $pricipalLoan1_2=$outstandingPrinciple_2;
        if($pricipalLoan1_2 ==''){
          $pricipalLoan1_2=0;  
        }
        
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$principal_id,
        'academic_year_id' =>'',
        'amount' =>$pricipalLoan1_2,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
            
        }
        }
        // end checking for principal
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL AND employment_status='ONPOST' AND verification_status='1'")->all();
        //$details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL AND employment_status='ONPOST' AND verification_status='1' AND loan_summary_id IS NULL")->all();
        foreach ($details_applicantID as $value_applicant_id) { 
           $applicantID=$value_applicant_id->applicant_id;
           
           //check if exists in any bill before  
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        $itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
        $itemCodePNT="PNT";
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);		   
        $details_vrf_3 = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='".$vrf_id."' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantVRF_3=$details_vrf_3->loan_summary_id;
		$details_LAF_3 = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='".$LAF_id."' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantLAF_3=$details_LAF_3->loan_summary_id;
		$details_PNT_3 = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='".$PNT_id."' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantPNT_3=$details_PNT_3->loan_summary_id;
        $applicantVRF = (count($individualApplicantVRF_3) == '0') ? '0' : $individualApplicantVRF_3;
		$applicantBillLAF = (count($individualApplicantLAF_3) == '0') ? '0' : $individualApplicantLAF_3;
		$applicantBillPNT = (count($individualApplicantPNT_3) == '0') ? '0' : $individualApplicantPNT_3;
        //end check if exists in any bill before
        if($applicantVRF=='0' && $applicantBillLAF=='0' && $applicantBillPNT=='0'){
           $vrf=$moder->getIndividualEmployeesVRF($applicantID);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAF($applicantID);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenalty($applicantID);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
            
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'academic_year_id' =>'',
        'amount' =>$vrf,
        'vrf_accumulated' =>'0',
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
		'created_at'=>date("Y-m-d H:i:s"),
		'created_by'=>$loggedin,
        'amount' =>$LAF,    
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        }else{
      
           
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
        $detailsAmountChargesVRF_check2_bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id,$loan_given_to);		
        $TotalChargesInBillVRF_3=$detailsAmountChargesVRF_check2_bill->amount;
		$detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id);
        $TotalChargesPaidUnderBillVRF_3=$detailsAmountChargesVRF_check2_paid->amount;
        $vrf_3=$TotalChargesInBillVRF_3-$TotalChargesPaidUnderBillVRF_3;
		if($vrf_3==''){
		$vrf_3=0;
		}
		$detailsAmountChargesLAF_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id,$loan_given_to);		 
        $TotalChargesInBillLAF_3=$detailsAmountChargesLAF_check2Bill->amount;		
		$detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id);
        $TotalChargesPaidUnderBillLAF_3=$detailsAmountChargesLAF_check2Paid->amount;
        $LAF_3=$TotalChargesInBillLAF_3-$TotalChargesPaidUnderBillLAF_3;
		if($LAF_3==''){
		$LAF_3=0;
		}
         $detailsAmountChargesPNT_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id,$loan_given_to);		 
        $TotalChargesInBillPNT_3=$detailsAmountChargesPNT_check2Bill->amount;
		$detailsAmountChargesPNT_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id);
        $TotalChargesPaidUnderBillPNT_3=$detailsAmountChargesPNT_check2Paid->amount;
        $penalty_3=$TotalChargesInBillPNT_3-$TotalChargesPaidUnderBillPNT_3;
		if($penalty_3==''){
		$penalty_3=0;
		}
         //$totalChargesGeneralPNT +=$outstandingTotalChargePNT;
           
            
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'academic_year_id' =>'',
        'amount' =>$vrf_3,
		'created_at'=>date("Y-m-d H:i:s"),
		'created_by'=>$loggedin,
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF_3,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty_3,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();   
        }
		LoanSummary::updateCeaseIndividualBeneficiaryLoanSummaryWhenEmployed($applicantID,$loan_summary_id);
		$newverificationStatus=5;
		EmployedBeneficiary::updateBeneficiaryFromOldEmployer($employerID,$applicantID,$newverificationStatus);
        }
        EmployedBeneficiary::updateAll(['loan_summary_id' =>$loan_summary_id], 'employer_id ="'.$employerID.'" AND (applicant_id IS NOT NULL OR applicant_id >=1) AND verification_status="1" AND employment_status="ONPOST"  AND loan_summary_id IS NULL');		
        }
        
        public function insertLoaneeBillDetail($applicantID,$loan_summary_id,$loan_given_to){
		$loggedin=Yii::$app->user->identity->user_id;
        $created_at=date("Y-m-d H:i:s");
        $dateToday=date("Y-m-d");		
        $si=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();

        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);        
        //check if exists in any bill before    
        $details_applicantID = LoanSummaryDetail::findBySql("SELECT loan_summary_detail.loan_summary_id FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_repayment_item_id='".$principal_id."' AND loan_summary_detail.loan_given_to='$loan_given_to' ORDER BY loan_summary_detail.loan_summary_detail_id DESC")->one();
        $individualApplicantBillID_2=$details_applicantID->loan_summary_id;
        $applicantBillResults_2 = (count($individualApplicantBillID_2) == '0') ? '0' : $individualApplicantBillID_2;
        //end check if exists in any bill before
        
        if($applicantBillResults_2=='0'){	
		
		$getDistinctAccademicYrPerApplicant =\common\models\LoanBeneficiary::getAcademicYearTrend($applicantID);
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->disbursementBatch->academic_year_id; 
					$pricipalLoanwettggg=\common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYNoReturned($applicantID,$academicYearID);
                    $pricipalLoan=$pricipalLoanwettggg->disbursed_amount; 
					$loan_number=$pricipalLoanwettggg->application_id;
		
		/*
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT DISTINCT academic_year_id AS 'academic_year_id' FROM application WHERE  applicant_id='$applicantID'")->all();
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->academic_year_id; 
                    $pricipalLoan=$moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID);
					
					*/
					
					
					
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$principal_id,
        'academic_year_id' =>$academicYearID,
        'amount' =>$pricipalLoan,  
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
		
		//INSERT INTO loan table toget the acumulated loan of beneficiary based on loan number/application id	
Yii::$app->db->createCommand("INSERT IGNORE INTO  loan(applicant_id,loan_number,loan_repayment_item_id,academic_year_id,amount,created_at,updated_at,is_full_paid,loan_given_to,created_by,updated_by) VALUES('$applicantID','$loan_number','$principal_id','$academicYearID','$pricipalLoan','$created_at','$created_at','0','$loan_given_to','$loggedin','$loggedin')")->execute();
//end
                    }
        ++$si;
        }else{            
        $detailsAmountPrincipal_2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$applicantBillResults_2,$principal_id,$loan_given_to);
        $PrincipleInBill_2=$detailsAmountPrincipal_2Bill->amount;
        $detailsAmountPrincipal_2Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_2,$principal_id,$loan_given_to);
        $principalPaidUnderBill_2=$detailsAmountPrincipal_2Paid->amount;
        $outstandingPrinciple_2=$PrincipleInBill_2-$principalPaidUnderBill_2;
        $pricipalLoan1_2=$outstandingPrinciple_2;
        
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$principal_id,
        'academic_year_id' =>'',
        'amount' =>$pricipalLoan1_2,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
           
        }
        //}
        // end checking for principal
           
           //check if exists in any bill before  
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        $itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
        $itemCodePNT="PNT";
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);		   
        $details_vrf_3 = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='".$vrf_id."' AND loan_given_to='$loan_given_to' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantVRF_3=$details_vrf_3->loan_summary_id;
		$details_LAF_3 = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='".$LAF_id."' AND loan_given_to='$loan_given_to' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantLAF_3=$details_LAF_3->loan_summary_id;
		$details_PNT_3 = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='".$PNT_id."' AND loan_given_to='$loan_given_to' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantPNT_3=$details_PNT_3->loan_summary_id;
        $applicantVRF = (count($individualApplicantVRF_3) == '0') ? '0' : $individualApplicantVRF_3;
		$applicantBillLAF = (count($individualApplicantLAF_3) == '0') ? '0' : $individualApplicantLAF_3;
		$applicantBillPNT = (count($individualApplicantPNT_3) == '0') ? '0' : $individualApplicantPNT_3;
        //end check if exists in any bill before
        if($applicantVRF=='0' && $applicantBillLAF=='0' && $applicantBillPNT=='0'){
           $vrf=$moder->getIndividualEmployeesVRF($applicantID,$loan_given_to);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAF($applicantID,$loan_given_to);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenalty($applicantID,$loan_given_to);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
            
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'academic_year_id' =>'',
        'amount' =>$vrf,
        'vrf_accumulated' =>'0', 
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF,  
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
		
		$moder->getIndividualEmployeesPenaltyPerApplication($applicantID,$dateToday);
		$moder->getIndividualEmployeesLAFPerApplication($applicantID);
		$moder->getIndividualEmployeesVRFperApplication($applicantID,$dateToday);
        }else{
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);


        $detailsAmountChargesVRF_3Bill = $this->getItemsAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id,$loan_given_to);
        $detailsAmountChargesVRF_3Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id,$loan_given_to);
        $TotalChargesInBillVRF_3=$detailsAmountChargesVRF_3Bill->amount;
        $TotalChargesPaidUnderBillVRF_3=$detailsAmountChargesVRF_3Paid->amount;
        $vrf_3=$TotalChargesInBillVRF_3-$TotalChargesPaidUnderBillVRF_3;
		if($vrf_3==''){
		$vrf_3=0;
		}

        $detailsAmountChargesLAF_3Bill = $this->getItemsAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id,$loan_given_to);
        $detailsAmountChargesLAF_3Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id,$loan_given_to);         
        $TotalChargesInBillLAF_3=$detailsAmountChargesLAF_3Bill->amount;
        $TotalChargesPaidUnderBillLAF_3=$detailsAmountChargesLAF_3Paid->amount;
        $LAF_3=$TotalChargesInBillLAF_3-$TotalChargesPaidUnderBillLAF_3;
		if($LAF_3==''){
		$LAF_3=0;
		}

        $detailsAmountChargesPNT_3Bill = $this->getItemsAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id,$loan_given_to);
        $detailsAmountChargesPNT_3Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id,$loan_given_to);
        $TotalChargesInBillPNT_3=$detailsAmountChargesPNT_3Bill->amount;
        $TotalChargesPaidUnderBillPNT_3=$detailsAmountChargesPNT_3Paid->amount;
        $penalty_3=$TotalChargesInBillPNT_3-$TotalChargesPaidUnderBillPNT_3;
		if($penalty_3==''){
		$penalty_3=0;
		}
         //$totalChargesGeneralPNT +=$outstandingTotalChargePNT;
           
            
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'academic_year_id' =>'',
        'amount' =>$vrf_3,
		'created_at'=>date("Y-m-d H:i:s"),
		'created_by'=>$loggedin,
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF_3, 
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty_3, 
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();   
        }
        
    }
        
        
    public static function getTotalBillAmount($employerID){
		$loggedin=Yii::$app->user->identity->user_id;
        $details_applicantID = EmployedBeneficiary::getActiveBeneficiariesUnderEmployerDuringLoanSummaryCreation($employerID);
        $si=0;
		$dateToday=date("Y-m-d");
        $moder=new EmployedBeneficiary();
		$billDetailModel=new LoanRepaymentDetail();
        //$mode_application=new Application();
        $pricipalLoan1=0;$totalChargesGeneralVRF_check2=0;$totalChargesGeneralLAF_check2=0;$totalChargesGeneralPNT_check2=0;
        $vrf1=0;
        $LAF1=0;
        $penalty1=0;
        $pricipalLoan2=0;
        $totalChargesGeneralVRF=0;
        $totalChargesGeneralLAF=0;
        $totalChargesGeneralPNT=0;
        $pricipalLoan1_1=0;
        // Loop for getting total principal
        foreach ($details_applicantID as $value_applicant_id) { 
        $applicantID=$value_applicant_id->applicant_id;
        $loan_summary_idBenef=$value_applicant_id->loan_summary_id;		
		$loan_summary_idBenef = (count($loan_summary_idBenef) == 0) ? '0' : $loan_summary_idBenef;
        
        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
        //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before
$details_applicantID_result=\backend\modules\repayment\models\LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,$dateToday);
        $individualApplicantBillID=$details_applicantID_result->loan_summary_id;
        $applicantBillResults1 = (count($individualApplicantBillID) == '0') ? '0' : $individualApplicantBillID;
        //end check if exists in any bill before
        if($applicantBillResults1 == 0){  
        $details_disbursedAmount=\common\models\LoanBeneficiary::getPrincipleNoReturn($applicantID);			
        $pricipalLoan1 +=$details_disbursedAmount->disbursed_amount;        
                    //}
        }else{
		$tresultsApplicant=\backend\modules\repayment\models\LoanRepaymentDetail::getLastBeneficiaryRepaymentByDate($applicantID,$dateToday);	
		$applicantBillResults=$tresultsApplicant->loan_summary_id;
		$detailsAmountPrincipalBill=self::getItemsAmountInBill($applicantID,$applicantBillResults,$principal_id,$loan_given_to);
        $PrincipleInBill_1=$detailsAmountPrincipalBill->amount;
		$detailsAmountPrincipalPaid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults,$principal_id);
        $principalPaidUnderBill_1=$detailsAmountPrincipalPaid->amount;
        $outstandingPrinciple_1=$PrincipleInBill_1-$principalPaidUnderBill_1;
        $pricipalLoan1_1 +=$outstandingPrinciple_1;    
        }
        }
        //if there there at least one bill exist
        if($loan_summary_idBenef > '0'){
        $detailsAmountBill = self::getItemsAmountInBill($applicantID,$loan_summary_idBenef,$principal_id,$loan_given_to);
        $PrincipleInBill=$detailsAmountBill->amount;
		$detailsAmountPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$principal_id);
        $principalPaidUnderBill=$detailsAmountPaid->amount;
        $outstandingPrinciple=$PrincipleInBill-$principalPaidUnderBill;
         $pricipalLoan2 +=$outstandingPrinciple;            
        }
        ++$si;
        }
        // end loop for calculating principal
        $details_applicantID = EmployedBeneficiary::getActiveBeneficiariesUnderEmployerDuringLoanSummaryCreation($employerID);
        foreach ($details_applicantID as $value_applicant_id) { 
           $applicantID=$value_applicant_id->applicant_id;
           $loan_summary_idBenef=$value_applicant_id->loan_summary_id;
           
           //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before    
        $applicantID_check2 = \backend\modules\repayment\models\LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,$dateToday);
        $individualApplicantBillID_check2=$applicantID_check2->loan_summary_id;
        $applicantBillResults_check2 = (count($individualApplicantBillID_check2) == '0') ? '0' : $individualApplicantBillID_check2;
        //end check if exists in any bill before
            if($applicantBillResults_check2==0){
           $vrf=self::getTotalVRFOriginal($applicantID,$dateToday);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=self::getTotalLAFOriginal($applicantID,$dateToday);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=self::getTotalPenaltyOriginal($applicantID,$dateToday);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
            
        $vrf1 +=$vrf;                
        $LAF1 +=$LAF;
        $penalty1 +=$penalty;
            }else{
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        $itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
        $itemCodePNT="PNT";
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
		
		$tresultsApplicant=\backend\modules\repayment\models\LoanRepaymentDetail::getLastBeneficiaryRepaymentByDate($applicantID,$dateToday);	
		$applicantBillResults_check2=$tresultsApplicant->loan_summary_id;		
	    //-----------------VRF-----------------
		$detailsAmountChargesVRF_check2_bill = self::getItemsAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id,$loan_given_to);				
        $TotalChargesInBillVRF_check2=$detailsAmountChargesVRF_check2_bill->amount;
		
		$detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id);
        $TotalChargesPaidUnderBillVRF_check2=$detailsAmountChargesVRF_check2_paid->amount;
        $outstandingTotalChargeVRF_check2=$TotalChargesInBillVRF_check2-$TotalChargesPaidUnderBillVRF_check2;
        $totalChargesGeneralVRF_check2 +=$outstandingTotalChargeVRF_check2;
		 
		//------------------LAF-----------------------
		$detailsAmountChargesLAF_check2Bill = self::getItemsAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id,$loan_given_to);		
        $TotalChargesInBillLAF_check2=$detailsAmountChargesLAF_check2Bill->amount;
		
		$detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id);
        $TotalChargesPaidUnderBillLAF_check2=$detailsAmountChargesLAF_check2Paid->amount;
        $outstandingTotalChargeLAF_check2=$TotalChargesInBillLAF_check2-$TotalChargesPaidUnderBillLAF_check2;
         $totalChargesGeneralLAF_check2 +=$outstandingTotalChargeLAF_check2;		
		//---------------------PNT-----------------------         
         $detailsAmountChargesPNT_check2Bill =self::getItemsAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id,$loan_given_to);
        $TotalChargesInBillPNT_check2=$detailsAmountChargesPNT_check2Bill->amount;
		
		$detailsAmountChargesPNT_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id);		
        $TotalChargesPaidUnderBillPNT_check2=$detailsAmountChargesPNT_check2Paid->amount;
        $outstandingTotalChargePNT_check2=$TotalChargesInBillPNT_check2-$TotalChargesPaidUnderBillPNT_check2;
        $totalChargesGeneralPNT_check2 +=$outstandingTotalChargePNT_check2;  
        //-------------------------------------------------		
            }
        }
        
        //if there are at least one bill exist
        if($loan_summary_idBenef > '0'){
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
		   
		$detailsAmountChargesVRFBill = self::getItemsAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id,$loan_given_to);           
        $TotalChargesInBillVRF=$detailsAmountChargesVRFBill->amount;
		$detailsAmountChargesVRFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id);
        $TotalChargesPaidUnderBillVRF=$detailsAmountChargesVRFPaid->amount;
        $outstandingTotalChargeVRF=$TotalChargesInBillVRF-$TotalChargesPaidUnderBillVRF;
         $totalChargesGeneralVRF +=$outstandingTotalChargeVRF;

				
	    $detailsAmountChargesLAFBill = self::getItemsAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id,$loan_given_to);         
        $TotalChargesInBillLAF=$detailsAmountChargesLAFBill->amount;
		$detailsAmountChargesLAFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id);
        $TotalChargesPaidUnderBillLAF=$detailsAmountChargesLAFPaid->amount;
        $outstandingTotalChargeLAF=$TotalChargesInBillLAF-$TotalChargesPaidUnderBillLAF;
         $totalChargesGeneralLAF +=$outstandingTotalChargeLAF;         

        $detailsAmountChargesPNTBill = self::getItemsAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id,$loan_given_to);         
        $TotalChargesInBillPNT=$detailsAmountChargesPNTBill->amount;
		$detailsAmountChargesPNTBillPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id);
        $TotalChargesPaidUnderBillPNT=$detailsAmountChargesPNTBillPaid->amount;
        $outstandingTotalChargePNT=$TotalChargesInBillPNT-$TotalChargesPaidUnderBillPNT;
         $totalChargesGeneralPNT +=$outstandingTotalChargePNT;
        }
        }
       $totalAmountOfBill=$pricipalLoan2 + $pricipalLoan1 + $pricipalLoan1_1 + $vrf1 + $LAF1 + $penalty1 + $totalChargesGeneralVRF + $totalChargesGeneralLAF + $totalChargesGeneralPNT + $totalChargesGeneralVRF_check2 + $totalChargesGeneralLAF_check2 + $totalChargesGeneralPNT_check2;
        //$totalAmountOfBill=$PrincipleInBill;
       $value = (count($totalAmountOfBill) == '0') ? '0' : $totalAmountOfBill;
       return $value;
        }
		/* 28-11-2018
		public function getTotalBillAmount($employerID){
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1' AND (loan_summary_id IS NULL OR loan_summary_id='')")->all();
        $si=0;
		$dateToday=date("Y-m-d");
        $moder=new EmployedBeneficiary();
		$billDetailModel=new LoanRepaymentDetail();
        //$mode_application=new Application();
        $pricipalLoan1=0;$totalChargesGeneralVRF_check2=0;$totalChargesGeneralLAF_check2=0;$totalChargesGeneralPNT_check2=0;
        $vrf1=0;
        $LAF1=0;
        $penalty1=0;
        $totalChargesGeneral=0;
        $pricipalLoan2=0;
        $totalChargesGeneralVRF=0;
        $totalChargesGeneralLAF=0;
        $totalChargesGeneralPNT=0;
        $pricipalLoan1_1=0;
        // Loop for getting total principal
        foreach ($details_applicantID as $value_applicant_id) { 
        $applicantID=$value_applicant_id->applicant_id;
        $loan_summary_idBenef=$value_applicant_id->loan_summary_id;		
		$loan_summary_idBenef = (count($loan_summary_idBenef) == 0) ? '0' : $loan_summary_idBenef;
        
        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
        //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before    
        $details_applicantID_result = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantBillID=$details_applicantID_result->loan_summary_id;
        $applicantBillResults = (count($individualApplicantBillID) == '0') ? '0' : $individualApplicantBillID;
        //end check if exists in any bill before
        if($applicantBillResults == 0){   
        $details_disbursedAmount=\common\models\LoanBeneficiary::getPrincipleNoReturn($applicantID);			
        $pricipalLoan1 +=$details_disbursedAmount->disbursed_amount;        
                    //}
        }else{
		$detailsAmountPrincipalBill=$this->getItemsAmountInBill($applicantID,$applicantBillResults,$principal_id);
        $PrincipleInBill_1=$detailsAmountPrincipalBill->amount;
		$detailsAmountPrincipalPaid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults,$principal_id);
        $principalPaidUnderBill_1=$detailsAmountPrincipalPaid->amount;
        $outstandingPrinciple_1=$PrincipleInBill_1-$principalPaidUnderBill_1;
        $pricipalLoan1_1 +=$outstandingPrinciple_1;    
        }
        }
        //if there there at least one bill exist
        if($loan_summary_idBenef > '0'){
        $detailsAmountBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$principal_id);
        $PrincipleInBill=$detailsAmountBill->amount;
		$detailsAmountPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$principal_id);
        $principalPaidUnderBill=$detailsAmountPaid->amount;
        $outstandingPrinciple=$PrincipleInBill-$principalPaidUnderBill;
         $pricipalLoan2 +=$outstandingPrinciple;            
        }
        ++$si;
        }
        // end loop for calculating principal
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary "
                . "WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1' AND (loan_summary_id IS NULL OR loan_summary_id='')")->all();
        foreach ($details_applicantID as $value_applicant_id) { 
           $applicantID=$value_applicant_id->applicant_id;
           $loan_summary_idBenef=$value_applicant_id->loan_summary_id;
           
           //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before    
        $applicantID_check2 = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantBillID_check2=$applicantID_check2->loan_summary_id;
        $applicantBillResults_check2 = (count($individualApplicantBillID_check2) == '0') ? '0' : $individualApplicantBillID_check2;
        //end check if exists in any bill before
            if($applicantBillResults_check2==0){
           $vrf=$moder->getIndividualEmployeesVRF($applicantID);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAF($applicantID);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenalty($applicantID,$dateToday);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
            
        $vrf1 +=$vrf;                
        $LAF1 +=$LAF;
        $penalty1 +=$penalty;
            }else{
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        $itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
        $itemCodePNT="PNT";
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
	    //-----------------VRF-----------------
		$detailsAmountChargesVRF_check2_bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id);				
        $TotalChargesInBillVRF_check2=$detailsAmountChargesVRF_check2_bill->amount;
		
		$detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id);
        $TotalChargesPaidUnderBillVRF_check2=$detailsAmountChargesVRF_check2_paid->amount;
        $outstandingTotalChargeVRF_check2=$TotalChargesInBillVRF_check2-$TotalChargesPaidUnderBillVRF_check2;
        $totalChargesGeneralVRF_check2 +=$outstandingTotalChargeVRF_check2;
		 
		//------------------LAF-----------------------
		$detailsAmountChargesLAF_check2Bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id);		
        $TotalChargesInBillLAF_check2=$detailsAmountChargesLAF_check2Bill->amount;
		
		$detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id);
        $TotalChargesPaidUnderBillLAF_check2=$detailsAmountChargesLAF_check2Paid->amount;
        $outstandingTotalChargeLAF_check2=$TotalChargesInBillLAF_check2-$TotalChargesPaidUnderBillLAF_check2;
         $totalChargesGeneralLAF_check2 +=$outstandingTotalChargeLAF_check2;		
		//---------------------PNT-----------------------         
         $detailsAmountChargesPNT_check2Bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id);
        $TotalChargesInBillPNT_check2=$detailsAmountChargesPNT_check2Bill->amount;
		
		$detailsAmountChargesPNT_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id);		
        $TotalChargesPaidUnderBillPNT_check2=$detailsAmountChargesPNT_check2Paid->amount;
        $outstandingTotalChargePNT_check2=$TotalChargesInBillPNT_check2-$TotalChargesPaidUnderBillPNT_check2;
        $totalChargesGeneralPNT_check2 +=$outstandingTotalChargePNT_check2;  
        //-------------------------------------------------		
            }
        }
        
        //if there are at least one bill exist
        if($loan_summary_idBenef > '0'){
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
		   
		$detailsAmountChargesVRFBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id);           
        $TotalChargesInBillVRF=$detailsAmountChargesVRFBill->amount;
		$detailsAmountChargesVRFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id);
        $TotalChargesPaidUnderBillVRF=$detailsAmountChargesVRFPaid->amount;
        $outstandingTotalChargeVRF=$TotalChargesInBillVRF-$TotalChargesPaidUnderBillVRF;
         $totalChargesGeneralVRF +=$outstandingTotalChargeVRF;

				
	    $detailsAmountChargesLAFBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id);         
        $TotalChargesInBillLAF=$detailsAmountChargesLAFBill->amount;
		$detailsAmountChargesLAFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id);
        $TotalChargesPaidUnderBillLAF=$detailsAmountChargesLAFPaid->amount;
        $outstandingTotalChargeLAF=$TotalChargesInBillLAF-$TotalChargesPaidUnderBillLAF;
         $totalChargesGeneralLAF +=$outstandingTotalChargeLAF;         

        $detailsAmountChargesPNTBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id);         
        $TotalChargesInBillPNT=$detailsAmountChargesPNTBill->amount;
		$detailsAmountChargesPNTBillPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id);
        $TotalChargesPaidUnderBillPNT=$detailsAmountChargesPNTBillPaid->amount;
        $outstandingTotalChargePNT=$TotalChargesInBillPNT-$TotalChargesPaidUnderBillPNT;
         $totalChargesGeneralPNT +=$outstandingTotalChargePNT;
        }
        }
       $totalAmountOfBill=$pricipalLoan2 + $pricipalLoan1 + $pricipalLoan1_1 + $vrf1 + $LAF1 + $penalty1 + $totalChargesGeneralVRF + $totalChargesGeneralLAF + $totalChargesGeneralPNT + $totalChargesGeneralVRF_check2 + $totalChargesGeneralLAF_check2 + $totalChargesGeneralPNT_check2;
        //$totalAmountOfBill=$PrincipleInBill;
       $value = (count($totalAmountOfBill) == '0') ? '0' : $totalAmountOfBill;
       return $value;
        }
		*/
        
        public function getTotalBillAmountForDeceased($employerID){
		$loggedin=Yii::$app->user->identity->user_id;	
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1'")->all();
        $si=0;
        $moder=new EmployedBeneficiary();
		$billDetailModel=new LoanRepaymentDetail();
        //$mode_application=new Application();
        $pricipalLoan1=0;$totalChargesGeneralVRF_check2=0;$totalChargesGeneralLAF_check2=0;$totalChargesGeneralPNT_check2=0;
        $vrf1=0;
        $LAF1=0;
        $penalty1=0;
        $totalChargesGeneral=0;
        $pricipalLoan2=0;
        $totalChargesGeneralVRF=0;
        $totalChargesGeneralLAF=0;
        $totalChargesGeneralPNT=0;
        $pricipalLoan1_1=0;
        // Loop for getting total principal
        foreach ($details_applicantID as $value_applicant_id) { 
        $applicantID=$value_applicant_id->applicant_id;
        $loan_summary_idBenef=$value_applicant_id->loan_summary_id;		
		$loan_summary_idBenef = (count($loan_summary_idBenef) == 0) ? '0' : $loan_summary_idBenef;
        
        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
        //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before    
        $details_applicantID_result = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantBillID=$details_applicantID_result->loan_summary_id;
        $applicantBillResults = (count($individualApplicantBillID) == '0') ? '0' : $individualApplicantBillID;
        //end check if exists in any bill before
        if($applicantBillResults == 0){
		/*
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT DISTINCT academic_year_id AS 'academic_year_id' FROM application WHERE  applicant_id='$applicantID'")->all();
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->academic_year_id; 
                    $pricipalLoan=$moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID);
        $pricipalLoan1 +=$pricipalLoan;
        */   
        $details_disbursedAmount=\common\models\LoanBeneficiary::getPrincipleNoReturn($applicantID);			
        $pricipalLoan1 +=$details_disbursedAmount->disbursed_amount;        
                    //}
        }else{
		$detailsAmountPrincipalBill=$this->getItemsAmountInBill($applicantID,$applicantBillResults,$principal_id,$loan_given_to);
        $PrincipleInBill_1=$detailsAmountPrincipalBill->amount;
		$detailsAmountPrincipalPaid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults,$principal_id);
        $principalPaidUnderBill_1=$detailsAmountPrincipalPaid->amount;
        $outstandingPrinciple_1=$PrincipleInBill_1-$principalPaidUnderBill_1;
        $pricipalLoan1_1 +=$outstandingPrinciple_1;    
        }
        }
        //if there there at least one bill exist
        if($loan_summary_idBenef > '0'){
        $detailsAmountBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$principal_id,$loan_given_to);
        $PrincipleInBill=$detailsAmountBill->amount;
		$detailsAmountPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$principal_id);
        $principalPaidUnderBill=$detailsAmountPaid->amount;
        $outstandingPrinciple=$PrincipleInBill-$principalPaidUnderBill;
         $pricipalLoan2 +=$outstandingPrinciple;            
        }
        ++$si;
        }
        // end loop for calculating principal
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary "
                . "WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1'")->all();
        foreach ($details_applicantID as $value_applicant_id) { 
           $applicantID=$value_applicant_id->applicant_id;
           $loan_summary_idBenef=$value_applicant_id->loan_summary_id;
           
           //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before    
        $applicantID_check2 = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_detail_id DESC")->one();
        $individualApplicantBillID_check2=$applicantID_check2->loan_summary_id;
        $applicantBillResults_check2 = (count($individualApplicantBillID_check2) == '0') ? '0' : $individualApplicantBillID_check2;
        //end check if exists in any bill before
            if($applicantBillResults_check2==0){
           $vrf=$moder->getIndividualEmployeesVRF($applicantID);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAF($applicantID);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenalty($applicantID);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
            
        $vrf1 +=$vrf;                
        $LAF1 +=$LAF;
        $penalty1 +=$penalty;
            }else{
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        $itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
        $itemCodePNT="PNT";
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
	    //-----------------VRF-----------------
		$detailsAmountChargesVRF_check2_bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id,$loan_given_to);				
        $TotalChargesInBillVRF_check2=$detailsAmountChargesVRF_check2_bill->amount;
		
		$detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id);
        $TotalChargesPaidUnderBillVRF_check2=$detailsAmountChargesVRF_check2_paid->amount;
        $outstandingTotalChargeVRF_check2=$TotalChargesInBillVRF_check2-$TotalChargesPaidUnderBillVRF_check2;
        $totalChargesGeneralVRF_check2 +=$outstandingTotalChargeVRF_check2;
		 
		//------------------LAF-----------------------
		$detailsAmountChargesLAF_check2Bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id,$loan_given_to);		
        $TotalChargesInBillLAF_check2=$detailsAmountChargesLAF_check2Bill->amount;
		
		$detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id);
        $TotalChargesPaidUnderBillLAF_check2=$detailsAmountChargesLAF_check2Paid->amount;
        $outstandingTotalChargeLAF_check2=$TotalChargesInBillLAF_check2-$TotalChargesPaidUnderBillLAF_check2;
         $totalChargesGeneralLAF_check2 +=$outstandingTotalChargeLAF_check2;		
		//---------------------PNT-----------------------         
         $detailsAmountChargesPNT_check2Bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id,$loan_given_to);
        $TotalChargesInBillPNT_check2=$detailsAmountChargesPNT_check2Bill->amount;
		
		$detailsAmountChargesPNT_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id);		
        $TotalChargesPaidUnderBillPNT_check2=$detailsAmountChargesPNT_check2Paid->amount;
        $outstandingTotalChargePNT_check2=$TotalChargesInBillPNT_check2-$TotalChargesPaidUnderBillPNT_check2;
        $totalChargesGeneralPNT_check2 +=$outstandingTotalChargePNT_check2;  
        //-------------------------------------------------		
            }
        }
        
        //if there are at least one bill exist
        if($loan_summary_idBenef > '0'){
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
		   
		$detailsAmountChargesVRFBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id,$loan_given_to);           
        $TotalChargesInBillVRF=$detailsAmountChargesVRFBill->amount;
		$detailsAmountChargesVRFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id);
        $TotalChargesPaidUnderBillVRF=$detailsAmountChargesVRFPaid->amount;
        $outstandingTotalChargeVRF=$TotalChargesInBillVRF-$TotalChargesPaidUnderBillVRF;
         $totalChargesGeneralVRF +=$outstandingTotalChargeVRF;

				
	    $detailsAmountChargesLAFBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id,$loan_given_to);         
        $TotalChargesInBillLAF=$detailsAmountChargesLAFBill->amount;
		$detailsAmountChargesLAFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id);
        $TotalChargesPaidUnderBillLAF=$detailsAmountChargesLAFPaid->amount;
        $outstandingTotalChargeLAF=$TotalChargesInBillLAF-$TotalChargesPaidUnderBillLAF;
         $totalChargesGeneralLAF +=$outstandingTotalChargeLAF;         

        $detailsAmountChargesPNTBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id,$loan_given_to);         
        $TotalChargesInBillPNT=$detailsAmountChargesPNTBill->amount;
		$detailsAmountChargesPNTBillPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id);
        $TotalChargesPaidUnderBillPNT=$detailsAmountChargesPNTBillPaid->amount;
        $outstandingTotalChargePNT=$TotalChargesInBillPNT-$TotalChargesPaidUnderBillPNT;
         $totalChargesGeneralPNT +=$outstandingTotalChargePNT;
        }
        }
       $totalAmountOfBill=$pricipalLoan2 + $pricipalLoan1 + $pricipalLoan1_1 + $vrf1 + $LAF1 + $penalty1 + $totalChargesGeneralVRF + $totalChargesGeneralLAF + $totalChargesGeneralPNT + $totalChargesGeneralVRF_check2 + $totalChargesGeneralLAF_check2 + $totalChargesGeneralPNT_check2;
        //$totalAmountOfBill=$PrincipleInBill;
       $value = (count($totalAmountOfBill) == '0') ? '0' : $totalAmountOfBill;
       return $value;
        }
        
        public function getTotalBillAmountLoanee($applicantID){
		$loggedin=Yii::$app->user->identity->user_id;	
        $details_applicantID = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_id DESC")->one();
        $si=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();
        //$mode_application=new Application();
        $pricipalLoan1=0;$totalChargesGeneralVRF_check2=0;$totalChargesGeneralLAF_check2=0;$totalChargesGeneralPNT_check2=0;
        $vrf1=0;
        $LAF1=0;
        $penalty1=0;
        $totalChargesGeneral=0;
        $pricipalLoan2=0;
        $totalChargesGeneralVRF=0;
        $totalChargesGeneralLAF=0;
        $totalChargesGeneralPNT=0;
        $pricipalLoan1_1=0;
        //Loop for getting total principal
        //$loan_summary_idBenef=$details_applicantID->loan_summary_id;		
		//$loan_summary_idBenef = (count($loan_summary_idBenef) == 0) ? '0' : $loan_summary_idBenef;
		
		if(count($details_applicantID)>0){ 
		$loan_summary_idBenef=$details_applicantID->loan_summary_id;
        }else{
		$loan_summary_idBenef=0;
		}
        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
        //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before    
        $details_applicantID_result = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_detail_id DESC")->one();
        //$individualApplicantBillID=$details_applicantID_result->loan_summary_id;
        //$applicantBillResults = (count($individualApplicantBillID) == '0') ? '0' : $individualApplicantBillID;
		
		if(count($details_applicantID_result)>0){
		$applicantBillResults=$details_applicantID_result->loan_summary_id;
		}else{
		$applicantBillResults=0;
		}
		
        //end check if exists in any bill before
        if($applicantBillResults == 0){
		/*
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT DISTINCT academic_year_id AS 'academic_year_id' FROM application WHERE  applicant_id='$applicantID'")->all();
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->academic_year_id; 
                    $pricipalLoan=$moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID);
        $pricipalLoan1 +=$pricipalLoan; 
        */
        $details_disbursedAmount=\common\models\LoanBeneficiary::getPrincipleNoReturn($applicantID);			
        $pricipalLoan1 +=$details_disbursedAmount->disbursed_amount; 		
                    //}
        }else{
        $detailsAmountPrincipalBill =$this->getItemsAmountInBill($applicantID,$applicantBillResults,$principal_id,$loan_given_to);
        $PrincipleInBill_1=$detailsAmountPrincipalBill->amount;        
        $detailsAmountPrincipalPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults,$principal_id);               
        $principalPaidUnderBill_1=$detailsAmountPrincipalPaid->amount;
        $outstandingPrinciple_1=$PrincipleInBill_1-$principalPaidUnderBill_1;
        $pricipalLoan1_1 +=$outstandingPrinciple_1;    
        }
        }
        //if there there at least one bill exist
        if($loan_summary_idBenef > '0'){
         $detailsAmountBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$principal_id,$loan_given_to);
        $detailsAmountPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$principal_id);   
        $PrincipleInBill=$detailsAmountBill->amount;
        $principalPaidUnderBill=$detailsAmountPaid->amount;
        $outstandingPrinciple=$PrincipleInBill-$principalPaidUnderBill;
         $pricipalLoan2 +=$outstandingPrinciple;            
        }
        // end loop for calculating principal
		
         // CALCULAING OTHER CHARGES  
           //here if no any bill under beneficiary
        if($loan_summary_idBenef=='' OR $loan_summary_idBenef < '1'){
            
        //check if exists in any bill before    
        $applicantID_check2 = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_detail_id DESC")->one();
        //$individualApplicantBillID_check2=$applicantID_check2->loan_summary_id;
        //$applicantBillResults_check2 = (count($individualApplicantBillID_check2) == '0') ? '0' : $individualApplicantBillID_check2;
		
		if(count($applicantID_check2)>0){
		$applicantBillResults_check2 = $applicantID_check2->loan_summary_id;
		}else{
		$applicantBillResults_check2 = 0;
		}
		
        //end check if exists in any bill before
            if($applicantBillResults_check2==0){
           $vrf=$moder->getIndividualEmployeesVRF($applicantID);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=$moder->getIndividualEmployeesLAF($applicantID);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $penalty=$moder->getIndividualEmployeesPenalty($applicantID);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
            
        $vrf1 +=$vrf;                
        $LAF1 +=$LAF;
        $penalty1 +=$penalty;
            }else{
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        $itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
        $itemCodePNT="PNT";        
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT); 
        
        //-----------------VRF-----------------
        $detailsAmountChargesVRF_check2_bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id,$loan_given_to);
        $TotalChargesInBillVRF_check2=$detailsAmountChargesVRF_check2_bill->amount;        
        
        $detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$vrf_id);
        $TotalChargesPaidUnderBillVRF_check2=$detailsAmountChargesVRF_check2_paid->amount;
        $outstandingTotalChargeVRF_check2=$TotalChargesInBillVRF_check2-$TotalChargesPaidUnderBillVRF_check2;
         $totalChargesGeneralVRF_check2 +=$outstandingTotalChargeVRF_check2;
         //------------------LAF-----------------------
         
         $detailsAmountChargesLAF_check2Bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id,$loan_given_to);
         $TotalChargesInBillLAF_check2=$detailsAmountChargesLAF_check2Bill->amount;
        
        $detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$LAF_id);
        $TotalChargesPaidUnderBillLAF_check2=$detailsAmountChargesLAF_check2Paid->amount;
        $outstandingTotalChargeLAF_check2=$TotalChargesInBillLAF_check2-$TotalChargesPaidUnderBillLAF_check2;
         $totalChargesGeneralLAF_check2 +=$outstandingTotalChargeLAF_check2;
         //---------------------PNT-----------------------
         
         $detailsAmountChargesPNT_check2Bill = $this->getItemsAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id,$loan_given_to);
         $TotalChargesInBillPNT_check2=$detailsAmountChargesPNT_check2Bill->amount;        
        
        $detailsAmountChargesPNT_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_check2,$PNT_id);

        $TotalChargesPaidUnderBillPNT_check2=$detailsAmountChargesPNT_check2Paid->amount;
        $outstandingTotalChargePNT_check2=$TotalChargesInBillPNT_check2-$TotalChargesPaidUnderBillPNT_check2;
        $totalChargesGeneralPNT_check2 +=$outstandingTotalChargePNT_check2;  
        //-------------------------------------------------
            }
        }
        
        //if there are at least one bill exist
        if($loan_summary_idBenef > '0'){
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);

        $detailsAmountChargesVRFBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id,$loan_given_to);           
        $TotalChargesInBillVRF=$detailsAmountChargesVRFBill->amount;
        $detailsAmountChargesVRFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$vrf_id);
        $TotalChargesPaidUnderBillVRF=$detailsAmountChargesVRFPaid->amount;
        $outstandingTotalChargeVRF=$TotalChargesInBillVRF-$TotalChargesPaidUnderBillVRF;
         $totalChargesGeneralVRF +=$outstandingTotalChargeVRF;
         

        $detailsAmountChargesLAFBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id,$loan_given_to);
        $TotalChargesInBillLAF=$detailsAmountChargesLAFBill->amount;
        $detailsAmountChargesLAFPaid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$LAF_id);
        $TotalChargesPaidUnderBillLAF=$detailsAmountChargesLAFPaid->amount;
        $outstandingTotalChargeLAF=$TotalChargesInBillLAF-$TotalChargesPaidUnderBillLAF;
         $totalChargesGeneralLAF +=$outstandingTotalChargeLAF;

         $detailsAmountChargesPNTBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id,$loan_given_to);
        $TotalChargesInBillPNT=$detailsAmountChargesPNTBill->amount;
        $detailsAmountChargesPNTBillPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$loan_summary_idBenef,$PNT_id);
        $TotalChargesPaidUnderBillPNT=$detailsAmountChargesPNTBillPaid->amount;
        $outstandingTotalChargePNT=$TotalChargesInBillPNT-$TotalChargesPaidUnderBillPNT;
         $totalChargesGeneralPNT +=$outstandingTotalChargePNT;
        }
        //}
       $totalAmountOfBill=$pricipalLoan2 + $pricipalLoan1 + $pricipalLoan1_1 + $vrf1 + $LAF1 + $penalty1 + $totalChargesGeneralVRF + $totalChargesGeneralLAF + $totalChargesGeneralPNT + $totalChargesGeneralVRF_check2 + $totalChargesGeneralLAF_check2 + $totalChargesGeneralPNT_check2;
        //$totalAmountOfBill=$PrincipleInBill;
       $value = (count($totalAmountOfBill) == '0') ? '0' : $totalAmountOfBill;
       return $value;
        }
        
        
    public function getIndividualEmployeesPrincipalLoan($applicantID,$billID){
        $details_amount = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_summary_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_summary_detail.loan_repayment_item_id "
                . "WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$billID' AND loan_repayment_item.item_code='PRC'")->one();
        $principal=$details_amount->amount;
         
        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
        }
    public function getIndividualEmployeesPenalty($applicantID,$billID){
        $details_penalty = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_summary_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_summary_detail.loan_repayment_item_id "
                . "WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$billID' AND loan_repayment_item.item_code='PNT'")->one();
        $penalty=$details_penalty->amount;
         
        $value2 = (count($penalty) == 0) ? '0' : $penalty;
        return $value2;
        }
    public function getIndividualEmployeesLAF($applicantID,$billID){
        $details_LAF = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_summary_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_summary_detail.loan_repayment_item_id "
                . "WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$billID' AND loan_repayment_item.item_code='LAF'")->one();
        $LAF=$details_LAF->amount;
         
        $value2 = (count($LAF) == 0) ? '0' : $LAF;
        return $value2;
        } 
    public function getIndividualEmployeesVRF($applicantID,$billID){
        $details_VRF = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_summary_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_summary_detail.loan_repayment_item_id "
                . "WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$billID' AND loan_repayment_item.item_code='VRF'")->one();
        $VRF=$details_VRF->amount;
         
        $value2 = (count($VRF) == 0) ? '0' : $VRF;
        return $value2;
        }
		/*
    public function getIndividualEmployeesTotalLoan($applicantID,$billID){
        $details_totalLoan = $this->getIndividualEmployeesPrincipalLoan($applicantID,$billID) + $this->getIndividualEmployeesPenalty($applicantID,$billID) + $this->getIndividualEmployeesLAF($applicantID,$billID) + $this->getIndividualEmployeesVRF($applicantID,$billID);
        $totalLoan=$details_totalLoan;
         
        $value2 = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value2;
        }
		*/
	public static function getIndividualEmployeesTotalLoan($applicantID,$billID){
        $details_totalLoan = LoanSummaryDetail::getIndividualEmployeesPrincipalLoan($applicantID,$billID) + LoanSummaryDetail::getIndividualEmployeesPenalty($applicantID,$billID) + LoanSummaryDetail::getIndividualEmployeesLAF($applicantID,$billID) + LoanSummaryDetail::getIndividualEmployeesVRF($applicantID,$billID);
        $totalLoan=$details_totalLoan;
         
        $value2 = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value2;
        }	
    public function getIndividualEmployeesOutstandingDebt($applicantID,$billID){
        $alreadyPaid=0;
        $details_outstandingDebt = $this->getIndividualEmployeesTotalLoan($applicantID,$billID)-$alreadyPaid;
        $outstandingDebt=$details_outstandingDebt;
         
        $value2 = (count($outstandingDebt) == 0) ? '0' : $outstandingDebt;
        return $value2;
        }
        
    public static function getItemsAmountInBill($applicantID,$loan_summary_id,$itemID,$loan_given_to){
        $results = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount FROM loan_summary_detail A  INNER JOIN loan_summary B ON B.loan_summary_id=A.loan_summary_id"
                . " WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='".$itemID."' AND A.loan_given_to='$loan_given_to'")->one();

        return $results;
        }
    public static function getLoaneeTotalLoanInLoanSummary($applicantID,$loan_summary_id,$loan_given_to){
        $results_amount = LoanSummaryDetail::findBySql("SELECT SUM(loan_summary_detail.amount) AS amount "
                . "FROM loan_summary_detail  INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id"
                . " WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$loan_summary_id' AND loan_summary_detail.loan_given_to='$loan_given_to'")->one();
				if(count($results_amount)>0){
				$totalLoanInLoanSummary=$results_amount->amount;
				}else{
				$totalLoanInLoanSummary=0;
				}
        return $totalLoanInLoanSummary;
        }

    public static function getLoaneeOutstandingDebtUnderLoanSummary($applicant_id,$loan_summary_id,$loan_given_to){
        $alreadyPaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidunderBillIndividualEmployee($applicant_id,$loan_summary_id,$loan_given_to);
        $details_outstandingDebt = LoanSummaryDetail::getLoaneeTotalLoanInLoanSummary($applicant_id,$loan_summary_id,$loan_given_to)-$alreadyPaid;
		if($details_outstandingDebt < 0.00){
		$details_outstandingDebt1=0;
		}else{
		$details_outstandingDebt1=$details_outstandingDebt;
		}
        return $details_outstandingDebt1;
        }	
public static function getTotalLoanBeneficiaryOriginal($applicantID,$date,$loan_given_to){
$totalLoan=LoanSummaryDetail::getTotalPrincipleLoanOriginal($applicantID,$date,$loan_given_to) + LoanSummaryDetail::getTotalPenaltyOriginal($applicantID,$date,$loan_given_to) + LoanSummaryDetail::getTotalLAFOriginal($applicantID,$date,$loan_given_to) + LoanSummaryDetail::getTotalVRFOriginal($applicantID,$date,$loan_given_to);

return $totalLoan;
}	

		
//This method/function returns the total beneficiary VRF date		
public static function getTotalVRFOriginal($applicantID,$date,$loan_given_to){
	$date1=strtotime($date);
	$totlaVRF=0;
	//check for benefiacy repayment
	$repayment=LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,date("Y-m-d 23:59:59",strtotime($date)),$loan_given_to);
	if($repayment){
		//Caliculate VRF On Repayment
	    //get the active loan summary
        $activeLoanSummary=self::getActiveLoanSummaryOfBeneficiary($applicantID,$loan_given_to);
	    $activeLoanSummary_id=$activeLoanSummary->loan_summary_id;
		
		
		$itemCodeVRF="VRF";
        $vrf_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);
		$loanVRF = LoanSummaryDetail::findBySql("SELECT loan_summary_detail.amount AS amount FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$activeLoanSummary_id' AND loan_summary_detail.loan_repayment_item_id='$vrf_id' AND loan_summary_detail.loan_given_to='$loan_given_to'")->one();
		$totalAmountVRF=$loanVRF->amount;
		//getting accumulated VRF
		/*
		$queryVRFaccumulated = LoanSummaryDetail::findBySql("SELECT DISTINCT loan_summary_id FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='$vrf_id' AND loan_summary_id<>'$activeLoanSummary_id' AND loan_summary_detail.is_active<>'-1'")->all();
		
		foreach ($queryVRFaccumulated as $resultsVRFaccumulated) {
                    $OtherLoanSummaryID=$resultsVRFaccumulated->loan_summary_id; 
        $totalVRFAccumulated = LoanSummary::findBySql("SELECT vrf_accumulated AS vrf_accumulated FROM loan_summary WHERE loan_summary_id='$OtherLoanSummaryID'")->one();
		
        $vrfAccumulatedFinal +=$totalVRFAccumulated->vrf_accumulated; 		
                    }
          */					
		//end getting accumulated VRF
		//$totlaVRF=$vrfAccumulatedFinal + $totalAmountVRF;
		$totlaVRF=$totalAmountVRF;
	}else{
	//CALCULATE VRF BEFORE ANY REPAYMENT
	$totlaVRF=\backend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesVRF($applicantID,$date1);
	}
	if($totlaVRF < 0){
	$totlaVRF=0;
	}
   return  $totlaVRF;
}
//get vrf for loan of applicant given through employer/institution
public static function getTotalVRFOriginalGivenToApplicantTrhEmployer($applicantID,$date,$loan_given_to){
	$date1=strtotime($date);
	$totlaVRF=0;
	//check for benefiacy repayment
	$repayment=LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,date("Y-m-d 23:59:59",strtotime($date)),$loan_given_to);
	if($repayment){
		//Caliculate VRF On Repayment
	    //get the active loan summary
        $activeLoanSummary=self::getActiveLoanSummaryOfBeneficiary($applicantID,$loan_given_to);
	    $activeLoanSummary_id=$activeLoanSummary->loan_summary_id;		
		
		$itemCodeVRF="VRF";
        $vrf_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);
		$loanVRF = LoanSummaryDetail::findBySql("SELECT loan_summary_detail.amount AS amount FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$activeLoanSummary_id' AND loan_summary_detail.loan_repayment_item_id='$vrf_id' AND loan_given_to='$loan_given_to'")->one();
		$totalAmountVRF=$loanVRF->amount;
		$totlaVRF=$totalAmountVRF;
	}else{
	//CALCULATE VRF BEFORE ANY REPAYMENT
	$totlaVRF=\backend\modules\repayment\models\EmployedBeneficiary::getVRFapplicantLoanTrhoughEmployer($applicantID);
	}
	if($totlaVRF < 0){
	$totlaVRF=0;
	}
   return  $totlaVRF;
}
//This method/function returns the total beneficiary PENALTY BY date
public static function getTotalPenaltyOriginal($applicantID,$date,$loan_given_to){
	//check for benefiacy repayment
	$repayment=LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,date("Y-m-d 23:59:59",strtotime($date)),$loan_given_to);
	if($repayment){
	//calculate total penalty on repayment
	    $activeLoanSummary=self::getActiveLoanSummaryOfBeneficiary($applicantID,$loan_given_to);
	    $activeLoanSummary_id=$activeLoanSummary->loan_summary_id;
        $itemCodePNT="PNT";
        $PNT_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePNT);
		$loanPenalty = LoanSummaryDetail::findBySql("SELECT amount FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$activeLoanSummary_id' AND loan_repayment_item_id='$PNT_id'")->one();
		$totalAmountPenalty=$loanPenalty->amount;	
	}else{
	//calculate penalty before repayment
	$totalAmountPenalty=\backend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesPenalty($applicantID,$date);
	}
	if($totalAmountPenalty < 0){
	$totalAmountPenalty=0;	
	}
    return $totalAmountPenalty;
    }
	
	
	
//This method/function returns the total beneficiary LAF BY date	
public static function getTotalLAFOriginal($applicantID,$date,$loan_given_to){	
	//check for benefiacy repayment
	$repayment=LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,date("Y-m-d 23:59:59",strtotime($date)),$loan_given_to);
	if($repayment){
	$activeLoanSummary=self::getActiveLoanSummaryOfBeneficiary($applicantID,$loan_given_to);
	$activeLoanSummary_id=$activeLoanSummary->loan_summary_id;
    $itemCodeLAF="LAF";
    $LAF_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodeLAF);
	$loanLAF = LoanSummaryDetail::findBySql("SELECT amount FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$activeLoanSummary_id' AND loan_repayment_item_id='$LAF_id' AND loan_summary_detail.loan_given_to='$loan_given_to'")->one();
	$totalAmountLAF=$loanLAF->amount;
	}else{
	$totalAmountLAF=\backend\modules\repayment\models\EmployedBeneficiary::getIndividualEmployeesLAF($applicantID);		
	}
	if($totalAmountLAF < 0){
	$totalAmountLAF=0;	
	}
return $totalAmountLAF;
        }
//This method/function returns the total beneficiary PRINCIPLE BY date		
public static function getTotalPrincipleLoanOriginal($applicantID,$date,$loan_given_to){	
	     //check for benefiacy repayment
	$repayment=LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,date("Y-m-d 23:59:59",strtotime($date)),$loan_given_to);
	if($repayment){
	$activeLoanSummary=self::getActiveLoanSummaryOfBeneficiary($applicantID,$loan_given_to);
	$activeLoanSummary_id=$activeLoanSummary->loan_summary_id;
	$itemCodePrincipal="PRC";
    $principal_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePrincipal);
	$loanPrincipal = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS 'amount' FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$activeLoanSummary_id' AND loan_repayment_item_id='$principal_id' AND loan_summary_detail.loan_given_to='$loan_given_to'")->one();
	$totalAmountPrincipal=$loanPrincipal->amount;		
	$totalLoanPrincipal=$totalAmountPrincipal;
	}else{
	//--------------------------HERE PRINCIPAL LOAN------------------
		$itemCodePrincipal="PRC";
        $principal_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePrincipal);       
        //$getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT DISTINCT academic_year_id AS 'academic_year_id' FROM application WHERE  applicant_id='$applicantID'")->all();
		$getDistinctAccademicYrPerApplicant =\common\models\LoanBeneficiary::getAcademicYearTrend($applicantID);
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->disbursementBatch->academic_year_id; 
                    //$pricipalLoan=$moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID);
					$pricipalLoan=\common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYNoReturned($applicantID,$academicYearID);
        $pricipalLoan1 +=$pricipalLoan->disbursed_amount;        
                    }
		//-----------------------END PRINCIPAL LOAN----------------------
		$totalLoanPrincipal= $pricipalLoan1;	
	}
        if($totalLoanPrincipal < 0){
		$totalLoanPrincipal=0;
		}
       return $totalLoanPrincipal;
}
public static function getTotalPrincipleLoanOriginalThroughEmployerToApplicant($applicantID,$date){	
	     //check for benefiacy repayment
		 $pricipalLoanTrhogEmployer=0;
	$repayment=LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,date("Y-m-d 23:59:59",strtotime($date)));
	if($repayment){
	$activeLoanSummary=self::getActiveLoanSummaryOfBeneficiary($applicantID,$loan_given_to);
	$activeLoanSummary_id=$activeLoanSummary->loan_summary_id;
	$itemCodePrincipal="PRC";
    $principal_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePrincipal);
	$loanPrincipal = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS 'amount' FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$activeLoanSummary_id' AND loan_repayment_item_id='$principal_id' AND loan_given_to='2'")->one();
	$totalAmountPrincipal=$loanPrincipal->amount;		
	$totalLoanPrincipal=$totalAmountPrincipal;
	}else{
	//--------------------------HERE PRINCIPAL LOAN------------------
		$itemCodePrincipal="PRC";
        $principal_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCodePrincipal);       
					//get principal amount given to applicant through employer
$resultsAcademicTrendLoanThrEmployer=\common\models\LoanBeneficiary::getAcademicYearTrendLoanApplicantThroughEmployer($applicantID);
                    foreach ($resultsAcademicTrendLoanThrEmployer as $resultsAppTrendThroughEmployer) {
                    $academicYearIDLoanTroughEmployer=$resultsAppTrendThroughEmployer->disbursementBatch->academic_year_id;
					$pricipalLoanAppThrEmployer=\common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYNoReturnedGivenToApplicantThroughEmployer($applicantID,$academicYearIDLoanTroughEmployer);
        $pricipalLoanTrhogEmployer +=$pricipalLoanAppThrEmployer->disbursed_amount;        
                    }
					//end
		//-----------------------END PRINCIPAL LOAN----------------------
		$totalLoanPrincipal= $pricipalLoanTrhogEmployer;	
	}
        if($totalLoanPrincipal < 0){
		$totalLoanPrincipal=0;
		}
       return $totalLoanPrincipal;
}		
		
public static function getActiveLoanSummaryOfBeneficiary($applicantID,$loan_given_to){
return self::findBySql("SELECT loan_summary_detail.loan_summary_id,loan_summary_detail.academic_year_id FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND  loan_summary_detail.is_active='1' AND loan_summary_detail.loan_given_to='$loan_given_to' ORDER BY loan_summary_detail.loan_summary_id ASC")->one();	
}
public static function getActiveLoanSummaryOfBeneficiaryDetails($applicantID,$loanSummary_id,$itemCode_id){
return self::findBySql("SELECT SUM(loan_summary_detail.amount) AS 'amount' FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND  loan_summary_detail.is_active='1' AND loan_summary_detail.loan_summary_id='$loanSummary_id' AND loan_summary_detail.loan_repayment_item_id='$itemCode_id'  ORDER BY loan_summary_detail.loan_summary_id DESC")->one();	
}
public static function getItemExistInBillBefore($applicantID,$itemID,$loan_given_to){
return self::findBySql("SELECT loan_summary_detail.loan_summary_id FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_given_to='$loan_given_to' AND loan_summary_detail.loan_repayment_item_id='".$itemID."' ORDER BY loan_summary_detail.loan_summary_detail_id DESC")->one();	
}
public static function getTotalAmountInFirstLoanSummary($applicantID,$itemCode_id){
return self::findBySql("SELECT SUM(loan_summary_detail.amount) AS amount FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_repayment_item_id='$itemCode_id' AND  loan_summary_detail.is_active='1' ORDER BY loan_summary_detail.loan_summary_id ASC")->one();	
}
public static function checkAmountMissingUpdatePRCperAcademicYear($loanSummaryID,$applicantID,$amountMissing,$itemID,$academicYearID){
	$resultsLoanSummary=LoanSummaryDetail::find()->where(['loan_summary_id'=>$loanSummaryID,'applicant_id'=>$applicantID,'loan_repayment_item_id'=>$itemID,'academic_year_id'=>$academicYearID])->one();
	$amount=$resultsLoanSummary->amount + $amountMissing;
	$resultsLoanSummary->amount=$amount;
	$resultsLoanSummary->save();
}
public static function checkAmountMissingUpdateGeneral($loanSummaryID,$applicantID,$amountMissing,$itemID){
	$resultsLoanSummary=LoanSummaryDetail::find()->where(['loan_summary_id'=>$loanSummaryID,'applicant_id'=>$applicantID,'loan_repayment_item_id'=>$itemID])->one();
	$amount=$resultsLoanSummary->amount + $amountMissing;
	$resultsLoanSummary->amount=$amount;
	$resultsLoanSummary->save();
}
public static function getTotalAmountPRCInFirstLoanSummaryPerAcademicYear($applicantID,$itemCode_id,$academicYearID){
return self::findBySql("SELECT SUM(loan_summary_detail.amount) AS amount FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_repayment_item_id='$itemCode_id' AND loan_summary_detail.academic_year_id='$academicYearID' AND  loan_summary_detail.is_active='1' ORDER BY loan_summary_detail.loan_summary_id ASC")->one();	
}
public static function checkPRCexistPerAcademicYearInfirstLoanSummary($applicantID,$itemCode_id,$academicYearID){
return self::findBySql("SELECT loan_summary_detail.loan_summary_id FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_repayment_item_id='$itemCode_id' AND loan_summary_detail.academic_year_id='$academicYearID' AND  loan_summary_detail.is_active='1' ORDER BY loan_summary_detail.loan_summary_id ASC")->one();	
}
public static function insertItemPRCperAcademicYear($loan_summary_id,$applicant_id,$PRC_id,$academicYearID,$pricipalLoan){
	$loggedin=Yii::$app->user->identity->user_id;
Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicant_id,
        'loan_repayment_item_id' =>$PRC_id,
        'academic_year_id' =>$academicYearID,
        'amount' =>$pricipalLoan,
        'created_at'=>date("Y-m-d H:i:s"),	
        'created_by'=>$loggedin,		
        ])->execute();
}
public static function checkOtherItemsexistInfirstLoanSummary($applicantID,$itemCode_id){
return self::findBySql("SELECT loan_summary_detail.loan_summary_id FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_repayment_item_id='$itemCode_id' AND loan_summary_detail.amount >'0' AND  loan_summary_detail.is_active='1' ORDER BY loan_summary_detail.loan_summary_id ASC")->one();	
}
public static function updateGeneralAmountLastLoanSummary($lastLoanSummaryID){
	$resultsLoanSummaryDetailsTotalAmount=self::getTotalAmountUnderLastLoanSummary($lastLoanSummaryID);
	$amount=$resultsLoanSummaryDetailsTotalAmount->amount;
	$amountTotalvrf_accumulated=$resultsLoanSummaryDetailsTotalAmount->vrf_accumulated;
	$amountTotal=$amount-$amountTotalvrf_accumulated;
	$resultsLoanSummary=LoanSummary::find()->where(['loan_summary_id'=>$lastLoanSummaryID])->one();
	$resultsLoanSummary->amount=$amountTotal;
	$resultsLoanSummary->save();	
	return true;
}
public static function getTotalAmountUnderLastLoanSummary($lastLoanSummaryID){
return self::findBySql("SELECT SUM(loan_summary_detail.amount) AS amount,SUM(loan_summary_detail.vrf_accumulated) AS vrf_accumulated FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id WHERE  loan_summary_detail.loan_summary_id='$lastLoanSummaryID' AND  loan_summary_detail.is_active='1' ORDER BY loan_summary_detail.loan_summary_id DESC")->one();	
}

public static function insertBeneficiariesLoanThroughEmployer($employerID,$loan_summary_id,$applicantID,$academicYearID,$itemCategory,$amount,$application_id){
	$loggedin=Yii::$app->user->identity->user_id;
	$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_EMPLOYER;
	$todate=date("Y-m-d H:i:s");
		if($itemCategory=='PRC'){
			$principal_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCategory);
			//check if exists in loan summary
			$results=\backend\modules\repayment\models\LoanSummaryDetail::find()->where(['loan_summary_id'=>$loan_summary_id,'loan_given_to'=>$loan_given_to,'employer_id'=>$employerID,'academic_year_id'=>$academicYearID,'loan_repayment_item_id'=>$principal_id,'applicant_id'=>$applicantID])->one();
			//end	
         if(count($results)==0){			
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$principal_id,
        'academic_year_id' =>$academicYearID,
        'amount' =>$amount,
        'loan_given_to'=>$loan_given_to,	
        'employer_id'=>$employerID,
        'created_at'=>$todate,
        'created_by'=>$loggedin,		
        ])->execute();
		Yii::$app->db->createCommand("INSERT IGNORE INTO  loan(applicant_id,loan_number,loan_repayment_item_id,academic_year_id,amount,created_at,updated_at,is_full_paid,loan_given_to,created_by,updated_by) VALUES('$applicantID','$application_id','$principal_id','$academicYearID','$amount','$todate','$todate','0','$loan_given_to','$loggedin','$loggedin')")->execute();
		}           
}
        if($itemCategory=='VRF'){
        $vrf_id=\backend\modules\repayment\models\EmployedBeneficiary::getloanRepaymentItemID($itemCategory); 
        //check if exists in loan summary
			$results=\backend\modules\repayment\models\LoanSummaryDetail::find()->where(['loan_summary_id'=>$loan_summary_id,'loan_given_to'=>$loan_given_to,'employer_id'=>$employerID,'loan_repayment_item_id'=>$vrf_id,'applicant_id'=>$applicantID])->one();
			//end	
         if(count($results)==0){			
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'academic_year_id' =>'',
        'amount' =>$amount,
        'vrf_accumulated' =>'0',
        'loan_given_to'=>$loan_given_to,
        'employer_id'=>$employerID,	
        'created_at'=>$todate,
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand("INSERT IGNORE INTO  loan(applicant_id,loan_number,loan_repayment_item_id,amount,created_at,updated_at,is_full_paid,loan_given_to,created_by,updated_by) VALUES('$applicantID','$application_id','$vrf_id','$amount','$todate','$todate','0','$loan_given_to','$loggedin','$loggedin')")->execute();		
        }
		}
}
public static function getTotalAmountForLoanSummary($loan_summary_id,$loan_given_to){
       $details_amount = self::findBySql("SELECT SUM(loan_summary_detail.amount) AS amount "
                . "FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id  WHERE  loan_summary_detail.loan_summary_id='$loan_summary_id'  AND loan_summary_detail.loan_given_to='$loan_given_to'")->one();
        $amount=$details_amount->amount;
        $value = (count($amount) == 0) ? '0' : $amount;
        return $value;
        }
		
		
		
		
		public static function insertLoaneeBillDetailGeneral($applicantID,$loan_summary_id,$loan_given_to){
		$loggedin=Yii::$app->user->identity->user_id;
        $created_at=date("Y-m-d H:i:s");
        $dateToday=date("Y-m-d");		
        $si=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();

        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);        
        //check if exists in any bill before  
		$details_applicantID_result=\backend\modules\repayment\models\LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,$dateToday,$loan_given_to);
        $individualApplicantBillID=$details_applicantID_result->loan_summary_id;
		$applicantBillResults_2=0;
		if($individualApplicantBillID > 0){
        $details_applicantID = self::getItemExistInBillBefore($applicantID,$principal_id,$loan_given_to);
        $individualApplicantBillID_2=$details_applicantID->loan_summary_id;
        $applicantBillResults_2 = (count($individualApplicantBillID_2) == '0') ? '0' : $individualApplicantBillID_2;
		}
        //end check if exists in any bill before
        
        if($applicantBillResults_2=='0'){	
		
		$getDistinctAccademicYrPerApplicant =\common\models\LoanBeneficiary::getAcademicYearTrend($applicantID);
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->disbursementBatch->academic_year_id; 
					$pricipalLoanwettggg=\common\models\LoanBeneficiary::getAmountSubtotalPerAccademicYNoReturned($applicantID,$academicYearID);
                    $pricipalLoan=$pricipalLoanwettggg->disbursed_amount; 
					$loan_number=$pricipalLoanwettggg->application_id;
	
Yii::$app->db->createCommand("INSERT IGNORE INTO  loan_summary_detail(loan_summary_id,applicant_id,loan_repayment_item_id,academic_year_id,amount,created_at,created_by) VALUES('$loan_summary_id','$applicantID','$principal_id','$academicYearID','$pricipalLoan','$created_at','$loggedin')")->execute();		
//INSERT INTO loan table toget the acumulated loan of beneficiary based on loan number/application id	
Yii::$app->db->createCommand("INSERT IGNORE INTO  loan(applicant_id,loan_number,loan_repayment_item_id,academic_year_id,amount,created_at,updated_at,is_full_paid,loan_given_to,created_by,updated_by) VALUES('$applicantID','$loan_number','$principal_id','$academicYearID','$pricipalLoan','$created_at','$created_at','0','$loan_given_to','$loggedin','$loggedin')")->execute();
//end
                    }
        ++$si;
        }else{            
        $detailsAmountPrincipalBill=LoanSummaryDetail::getItemsAmountInBill($applicantID,$applicantBillResults_2,$principal_id,$loan_given_to);		
        $PrincipleInBill_2=$detailsAmountPrincipalBill->amount;
		$detailsAmountPrincipalPaid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_2,$principal_id,$loan_given_to);
        $principalPaidUnderBill_2=$detailsAmountPrincipalPaid->amount;
        $outstandingPrinciple_2=$PrincipleInBill_2-$principalPaidUnderBill_2;
        $pricipalLoan1_2=$outstandingPrinciple_2;
        if($pricipalLoan1_2 ==''){
          $pricipalLoan1_2=0;  
        }
		Yii::$app->db->createCommand("INSERT IGNORE INTO  loan_summary_detail(loan_summary_id,applicant_id,loan_repayment_item_id,amount,created_at,created_by) VALUES('$loan_summary_id','$applicantID','$principal_id','$pricipalLoan1_2','$created_at','$loggedin')")->execute();  
        }
        //}
        // end checking for principal
           
           //check if exists in any bill before  
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        $itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
        $itemCodePNT="PNT";
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);	   

		$details_applicantID_result=\backend\modules\repayment\models\LoanRepaymentDetail::getBeneficiaryRepaymentByDate($applicantID,$dateToday,$loan_given_to);
        $individualApplicantBillID=$details_applicantID_result->loan_summary_id;
		$applicantVRF=0;$applicantBillLAF=0;$applicantBillPNT=0;
		if($individualApplicantBillID > 0){
		$details_vrf_3 = self::getItemExistInBillBefore($applicantID,$vrf_id,$loan_given_to);
        $individualApplicantVRF_3=$details_vrf_3->loan_summary_id;
		$details_LAF_3 = self::getItemExistInBillBefore($applicantID,$LAF_id,$loan_given_to);
        $individualApplicantLAF_3=$details_LAF_3->loan_summary_id;
		$details_PNT_3 = self::getItemExistInBillBefore($applicantID,$PNT_id,$loan_given_to);
        $individualApplicantPNT_3=$details_PNT_3->loan_summary_id;
        $applicantVRF = (count($individualApplicantVRF_3) == '0') ? '0' : $individualApplicantVRF_3;
		$applicantBillLAF = (count($individualApplicantLAF_3) == '0') ? '0' : $individualApplicantLAF_3;
		$applicantBillPNT = (count($individualApplicantPNT_3) == '0') ? '0' : $individualApplicantPNT_3;
		}
        //end check if exists in any bill before
        if($applicantVRF=='0' && $applicantBillLAF=='0' && $applicantBillPNT=='0'){
           $vrf=self::getTotalVRFOriginal($applicantID,$dateToday,$loan_given_to);
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $LAF=self::getTotalLAFOriginal($applicantID,$dateToday,$loan_given_to);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
		   $penalty=self::getTotalPenaltyOriginal($applicantID,$dateToday,$loan_given_to);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
            
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'academic_year_id' =>'',
        'amount' =>$vrf,
        'vrf_accumulated' =>'0', 
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF, 
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();		
        $moder->getIndividualEmployeesPenaltyPerApplication($applicantID,$dateToday);
		$moder->getIndividualEmployeesLAFPerApplication($applicantID);
		$moder->getIndividualEmployeesVRFperApplication($applicantID,$dateToday);
        }else{
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
        $detailsAmountChargesVRF_check2_bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id,$loan_given_to);		
        $TotalChargesInBillVRF_3=$detailsAmountChargesVRF_check2_bill->amount;
		$detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id,$loan_given_to);
        $TotalChargesPaidUnderBillVRF_3=$detailsAmountChargesVRF_check2_paid->amount;
        $vrf_3=$TotalChargesInBillVRF_3-$TotalChargesPaidUnderBillVRF_3;
		if($vrf_3==''){
		$vrf_3=0;
		}
		$detailsAmountChargesLAF_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id,$loan_given_to);		 
        $TotalChargesInBillLAF_3=$detailsAmountChargesLAF_check2Bill->amount;		
		$detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id,$loan_given_to);
        $TotalChargesPaidUnderBillLAF_3=$detailsAmountChargesLAF_check2Paid->amount;
        $LAF_3=$TotalChargesInBillLAF_3-$TotalChargesPaidUnderBillLAF_3;
		if($LAF_3==''){
		$LAF_3=0;
		}
         $detailsAmountChargesPNT_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id,$loan_given_to);		 
        $TotalChargesInBillPNT_3=$detailsAmountChargesPNT_check2Bill->amount;
		$detailsAmountChargesPNT_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id,$loan_given_to);
        $TotalChargesPaidUnderBillPNT_3=$detailsAmountChargesPNT_check2Paid->amount;
        $penalty_3=$TotalChargesInBillPNT_3-$TotalChargesPaidUnderBillPNT_3;
		if($penalty_3==''){
		$penalty_3=0;
		}
         //$totalChargesGeneralPNT +=$outstandingTotalChargePNT;          
            
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$vrf_id,
        'academic_year_id' =>'',
        'amount' =>$vrf_3,
		'created_at'=>date("Y-m-d H:i:s"),
		'created_by'=>$loggedin,
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF_3, 
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty_3,
        'created_at'=>date("Y-m-d H:i:s"),
        'created_by'=>$loggedin,		
        ])->execute();   
        }
        
    }
public static function getTotalLoan($applicantID,$loan_given_to){
        $results_amount = \backend\modules\repayment\models\Loan::findBySql("SELECT SUM(loan.amount) AS amount "
                . "FROM loan "
                . " WHERE  loan.applicant_id='$applicantID' AND loan.loan_given_to='$loan_given_to'")->one();
				if(count($results_amount)>0){
				$totalLoan=$results_amount->amount;
				}else{
				$totalLoan=0;
				}
        return $totalLoan;
        }
}