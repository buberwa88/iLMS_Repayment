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
            [['indexno', 'fullname','principal','penalty','LAF','vrf','totalLoan','outstandingDebt','amount1','firstname','middlename','surname','f4indexno','paid'], 'safe'],
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
    
    public static function insertAllBeneficiariesUnderBill($employerID,$loan_summary_id){
        //$details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1'")->all();
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1' AND loan_summary_id IS NULL")->all();
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
        ])->execute();
                    }
        ++$si;
        }else{  		
		$detailsAmountPrincipalBill=LoanSummaryDetail::getItemsAmountInBill($applicantID,$applicantBillResults_2,$principal_id);		
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
        ])->execute();
            
        }
        }
        // end checking for principal
        //$details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL AND employment_status='ONPOST' AND verification_status='1'")->all();
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL AND employment_status='ONPOST' AND verification_status='1' AND loan_summary_id IS NULL")->all();
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
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF,    
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty,    
        ])->execute();
        }else{
      
           
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
        $detailsAmountChargesVRF_check2_bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id);		
        $TotalChargesInBillVRF_3=$detailsAmountChargesVRF_check2_bill->amount;
		$detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id);
        $TotalChargesPaidUnderBillVRF_3=$detailsAmountChargesVRF_check2_paid->amount;
        $vrf_3=$TotalChargesInBillVRF_3-$TotalChargesPaidUnderBillVRF_3;
		if($vrf_3==''){
		$vrf_3=0;
		}
		$detailsAmountChargesLAF_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id);		 
        $TotalChargesInBillLAF_3=$detailsAmountChargesLAF_check2Bill->amount;		
		$detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id);
        $TotalChargesPaidUnderBillLAF_3=$detailsAmountChargesLAF_check2Paid->amount;
        $LAF_3=$TotalChargesInBillLAF_3-$TotalChargesPaidUnderBillLAF_3;
		if($LAF_3==''){
		$LAF_3=0;
		}
         $detailsAmountChargesPNT_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id);		 
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
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF_3,    
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty_3,    
        ])->execute();   
        }
		LoanSummary::updateCeaseIndividualBeneficiaryLoanSummaryWhenEmployed($applicantID,$loan_summary_id);
		$newverificationStatus=5;
		EmployedBeneficiary::updateBeneficiaryFromOldEmployer($employerID,$applicantID,$newverificationStatus);
        }
        EmployedBeneficiary::updateAll(['loan_summary_id' =>$loan_summary_id], 'employer_id ="'.$employerID.'" AND (applicant_id IS NOT NULL OR applicant_id >=1) AND verification_status="1" AND employment_status="ONPOST"  AND loan_summary_id IS NULL');		
        }
        
        public static function insertAllBeneficiariesUnderBillAfterDeceased($employerID,$loan_summary_id){
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
        ])->execute();
                    }
        ++$si;
        }else{  		
		$detailsAmountPrincipalBill=LoanSummaryDetail::getItemsAmountInBill($applicantID,$applicantBillResults_2,$principal_id);		
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
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF,    
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty,    
        ])->execute();
        }else{
      
           
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
        $detailsAmountChargesVRF_check2_bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id);		
        $TotalChargesInBillVRF_3=$detailsAmountChargesVRF_check2_bill->amount;
		$detailsAmountChargesVRF_check2_paid =$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id);
        $TotalChargesPaidUnderBillVRF_3=$detailsAmountChargesVRF_check2_paid->amount;
        $vrf_3=$TotalChargesInBillVRF_3-$TotalChargesPaidUnderBillVRF_3;
		if($vrf_3==''){
		$vrf_3=0;
		}
		$detailsAmountChargesLAF_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id);		 
        $TotalChargesInBillLAF_3=$detailsAmountChargesLAF_check2Bill->amount;		
		$detailsAmountChargesLAF_check2Paid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id);
        $TotalChargesPaidUnderBillLAF_3=$detailsAmountChargesLAF_check2Paid->amount;
        $LAF_3=$TotalChargesInBillLAF_3-$TotalChargesPaidUnderBillLAF_3;
		if($LAF_3==''){
		$LAF_3=0;
		}
         $detailsAmountChargesPNT_check2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id);		 
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
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF_3,    
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty_3,    
        ])->execute();   
        }
		LoanSummary::updateCeaseIndividualBeneficiaryLoanSummaryWhenEmployed($applicantID,$loan_summary_id);
		$newverificationStatus=5;
		EmployedBeneficiary::updateBeneficiaryFromOldEmployer($employerID,$applicantID,$newverificationStatus);
        }
        EmployedBeneficiary::updateAll(['loan_summary_id' =>$loan_summary_id], 'employer_id ="'.$employerID.'" AND (applicant_id IS NOT NULL OR applicant_id >=1) AND verification_status="1" AND employment_status="ONPOST"  AND loan_summary_id IS NULL');		
        }
        
        public function insertLoaneeBillDetail($applicantID,$loan_summary_id){
        $si=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();

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
        ])->execute();
                    }
        ++$si;
        }else{            
        $detailsAmountPrincipal_2Bill = LoanSummaryDetail::getItemsAmountInBill($applicantID,$applicantBillResults_2,$principal_id);
        $PrincipleInBill_2=$detailsAmountPrincipal_2Bill->amount;
        $detailsAmountPrincipal_2Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults_2,$principal_id);
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
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF,    
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty,    
        ])->execute();
        }else{
           $itemCodeVRF="VRF";
           $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
           $itemCodeLAF="LAF";
           $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
           $itemCodePNT="PNT";
           $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);


        $detailsAmountChargesVRF_3Bill = $this->getItemsAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id);
        $detailsAmountChargesVRF_3Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantVRF_3,$vrf_id);
        $TotalChargesInBillVRF_3=$detailsAmountChargesVRF_3Bill->amount;
        $TotalChargesPaidUnderBillVRF_3=$detailsAmountChargesVRF_3Paid->amount;
        $vrf_3=$TotalChargesInBillVRF_3-$TotalChargesPaidUnderBillVRF_3;
		if($vrf_3==''){
		$vrf_3=0;
		}

        $detailsAmountChargesLAF_3Bill = $this->getItemsAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id);
        $detailsAmountChargesLAF_3Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantLAF_3,$LAF_id);         
        $TotalChargesInBillLAF_3=$detailsAmountChargesLAF_3Bill->amount;
        $TotalChargesPaidUnderBillLAF_3=$detailsAmountChargesLAF_3Paid->amount;
        $LAF_3=$TotalChargesInBillLAF_3-$TotalChargesPaidUnderBillLAF_3;
		if($LAF_3==''){
		$LAF_3=0;
		}

        $detailsAmountChargesPNT_3Bill = $this->getItemsAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id);
        $detailsAmountChargesPNT_3Paid=$billDetailModel->getItemsPaidAmountInBill($applicantID,$individualApplicantPNT_3,$PNT_id);
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
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$LAF_id,
        'academic_year_id' =>'',
        'amount' =>$LAF_3,    
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$PNT_id,
        'academic_year_id' =>'',
        'amount' =>$penalty_3,    
        ])->execute();   
        }
        
    }
        
        
    public function getTotalBillAmount($employerID){
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL  AND employment_status='ONPOST' AND verification_status='1' AND (loan_summary_id IS NULL OR loan_summary_id='')")->all();
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
        
        public function getTotalBillAmountForDeceased($employerID){
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
        
        public function getTotalBillAmountLoanee($applicantID){
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
        $detailsAmountPrincipalBill =$this->getItemsAmountInBill($applicantID,$applicantBillResults,$principal_id);
        $PrincipleInBill_1=$detailsAmountPrincipalBill->amount;        
        $detailsAmountPrincipalPaid = $billDetailModel->getItemsPaidAmountInBill($applicantID,$applicantBillResults,$principal_id);               
        $principalPaidUnderBill_1=$detailsAmountPrincipalPaid->amount;
        $outstandingPrinciple_1=$PrincipleInBill_1-$principalPaidUnderBill_1;
        $pricipalLoan1_1 +=$outstandingPrinciple_1;    
        }
        }
        //if there there at least one bill exist
        if($loan_summary_idBenef > '0'){
         $detailsAmountBill = $this->getItemsAmountInBill($applicantID,$loan_summary_idBenef,$principal_id);
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
        
    public static function getItemsAmountInBill($applicantID,$loan_summary_id,$itemID){
        $results = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount FROM loan_summary_detail A "
                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='".$itemID."'")->one();

        return $results;
        }
    public static function getLoaneeTotalLoanInLoanSummary($applicantID,$loan_summary_id){
        $results_amount = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS amount "
                . "FROM loan_summary_detail "
                . "WHERE  loan_summary_detail.applicant_id='$applicantID' AND loan_summary_detail.loan_summary_id='$loan_summary_id'")->one();
				if(count($results_amount)>0){
				$totalLoanInLoanSummary=$results_amount->amount;
				}else{
				$totalLoanInLoanSummary=0;
				}
        return $totalLoanInLoanSummary;
        }

    public static function getLoaneeOutstandingDebtUnderLoanSummary($applicant_id,$loan_summary_id){
        $alreadyPaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidunderBillIndividualEmployee($applicant_id,$loan_summary_id);
        $details_outstandingDebt = LoanSummaryDetail::getLoaneeTotalLoanInLoanSummary($applicant_id,$loan_summary_id)-$alreadyPaid;
		if($details_outstandingDebt < 0.00){
		$details_outstandingDebt1=0;
		}else{
		$details_outstandingDebt1=$details_outstandingDebt;
		}
        return $details_outstandingDebt1;
        }	
public static function getTotalLoanBeneficiaryOriginal($applicantID){
$totalLoan=LoanSummaryDetail::getTotalPrincipleLoanOriginal($applicantID) + LoanSummaryDetail::getTotalPenaltyOriginal($applicantID) + LoanSummaryDetail::getTotalLAFOriginal($applicantID) + LoanSummaryDetail::getTotalVRFOriginal($applicantID);

return $totalLoan;
}	
public static function getTotalPrincipleLoanOriginal($applicantID){
        $details_applicantID = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_id ASC")->one();
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();
        $pricipalLoan1=0;
		$totalLoanPrincipal=0;

		if(count($details_applicantID)>0){ 
		$loan_summary_idBenef=$details_applicantID->loan_summary_id;
        }else{
		$loan_summary_idBenef=0;
		}
		// here if exists in any loan summary
		if($loan_summary_idBenef > 0){
		$itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
		$loanPrincipal = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS 'amount' FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$loan_summary_idBenef' AND loan_repayment_item_id='$principal_id'")->one();
		$totalAmountPrincipal=$loanPrincipal->amount;
		
		$totalLoanPrincipal=$totalAmountPrincipal;
		}else{
		//--------------------------HERE PRINCIPAL LOAN------------------
		$itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);       
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

       
        if($totalLoanPrincipal > 0){
		$value=$totalLoanPrincipal;
		}else{
		$value=0;
		}
       return $value;
        }
    public static function getTotalPenaltyOriginal($applicantID){
        $details_applicantID = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_id ASC")->one();
        $si=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();
		$penalty1=0;
        $totalAmountPenalty=0;		
		if(count($details_applicantID)>0){ 
		$loan_summary_idBenef=$details_applicantID->loan_summary_id;
        }else{
		$loan_summary_idBenef=0;
		}
		// here if exists in any loan summary
		if($loan_summary_idBenef > 0){
		$itemCodePNT="PNT";
        $PNT_id=$moder->getloanRepaymentItemID($itemCodePNT);
		$loanPenalty = LoanSummaryDetail::findBySql("SELECT amount FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$loan_summary_idBenef' AND loan_repayment_item_id='$PNT_id'")->one();
		$totalAmountPenalty=$loanPenalty->amount;
		}else{
        $totalAmountPenalty=$moder->getIndividualEmployeesPenalty($applicantID);
		}       

       
        if($totalAmountPenalty > 0){
		$value=$totalAmountPenalty;
		}else{
		$value=0;
		}
       return $value;
        }	
    public static function getTotalLAFOriginal($applicantID){
        $details_applicantID = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_id ASC")->one();
        $si=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();
        $totalAmountLAF=0;		
		if(count($details_applicantID)>0){ 
		$loan_summary_idBenef=$details_applicantID->loan_summary_id;
        }else{
		$loan_summary_idBenef=0;
		}
		// here if exists in any loan summary
		if($loan_summary_idBenef > 0){
		$itemCodeLAF="LAF";
        $LAF_id=$moder->getloanRepaymentItemID($itemCodeLAF);
		$loanLAF = LoanSummaryDetail::findBySql("SELECT amount FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$loan_summary_idBenef' AND loan_repayment_item_id='$LAF_id'")->one();
		$totalAmountLAF=$loanLAF->amount;
		}else{
		$totalAmountLAF=$moder->getIndividualEmployeesLAF($applicantID);           
		}       

       
        if($totalAmountLAF > 0){
		$value=$totalAmountLAF;
		}else{
		$value=0;
		}
       return $value;
        }
public static function getTotalVRFOriginal($applicantID){
        $details_applicantID = LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_id ASC")->one();
        $si=0;
		$vrfAccumulatedFinal=0;
		$totalAmountVRF=0;
		$totalLoanVRF=0;
        $moder=new EmployedBeneficiary();
        $billDetailModel=new LoanRepaymentDetail();
		$vrf1=0;		 
		if(count($details_applicantID)>0){ 
		$loan_summary_idBenef=$details_applicantID->loan_summary_id;
        }else{
		$loan_summary_idBenef=0;
		}
		// here if exists in any loan summary
		if($loan_summary_idBenef > 0){
		$itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
		$loanVRF = LoanSummaryDetail::findBySql("SELECT amount FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_summary_id='$loan_summary_idBenef' AND loan_repayment_item_id='$vrf_id'")->one();
		$totalAmountVRF=$loanVRF->amount;
		//getting accumulated VRF
		$queryVRFaccumulated = LoanSummaryDetail::findBySql("SELECT DISTINCT loan_summary_id FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='$vrf_id' AND loan_summary_id<>'$loan_summary_idBenef'")->all();
		
		foreach ($queryVRFaccumulated as $resultsVRFaccumulated) {
                    $OtherLoanSummaryID=$resultsVRFaccumulated->loan_summary_id; 
        $totalVRFAccumulated = LoanSummary::findBySql("SELECT vrf_accumulated AS vrf_accumulated FROM loan_summary WHERE loan_summary_id='$OtherLoanSummaryID'")->one();
		
        $vrfAccumulatedFinal +=$totalVRFAccumulated->vrf_accumulated; 		
                    }		
		//end getting accumulated VRF
		$totalLoanVRF=$vrfAccumulatedFinal + $totalAmountVRF;
		}else{	
		$totalLoanVRF=$moder->getIndividualEmployeesVRF($applicantID);		
		}       
       
        if($totalLoanVRF > 0){
		$value=$totalLoanVRF;
		}else{
		$value=0;
		}
       return $value;
        }		
}