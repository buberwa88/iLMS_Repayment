<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\application\models\Application;
use frontend\modules\repayment\models\LoanRepaymentDetail;
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
	public $reference_number;
	public $status;
    
    public function rules()
    {
        return [
            [['loan_summary_id', 'applicant_id', 'loan_repayment_item_id', 'amount'], 'required'],
            [['loan_summary_id', 'applicant_id', 'loan_repayment_item_id', 'academic_year_id'], 'integer'],
            [['amount'], 'number'],
            [['indexno', 'fullname','principal','penalty','LAF','vrf','totalLoan','outstandingDebt','amount1','vrf_accumulated','firstname','middlename','surname','f4indexno','paid','loan_given_to','employer_id','created_by','updated_at','updated_by','vrf_before_repayment','is_full_paid'], 'safe'],
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
            'amount' => 'Amount',
            'indexno'=>'Indexno',
            'fullname'=>'Full Name',
            'principal'=>'Principal Amount',
            'penalty'=>'Penalty',
            'LAF'=>'Loan Adm. Fee',
            'vrf'=>'Value Retention Fee',
            'totalLoan'=>'Total Loan Amount',
            'outstandingDebt'=>'Outstanding Debt',
            'amount1'=>'Amount(TZS)',
            'vrf_accumulated'=>'VRF Accumulated',
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
    
    public function insertAllBeneficiariesUnderBill($employerID,$loan_summary_id){
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL AND loan_summary_id IS NULL AND employment_status='ONPOST'")->all();
        $si=0;
        $moder=new EmployedBeneficiary();
        //$mode_application=new Application();
        foreach ($details_applicantID as $value_applicant_id) { 
        $applicantID=$value_applicant_id->applicant_id;
        
        $itemCodePrincipal="PRC";
        $principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT DISTINCT academic_year_id AS 'academic_year_id' FROM application WHERE  applicant_id='$applicantID'")->all();
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $accademicYearID=$resultsApp->academic_year_id; 
                    $pricipalLoan=$moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$accademicYearID);
        Yii::$app->db->createCommand()
        ->insert('loan_summary_detail', [
        'loan_summary_id' =>$loan_summary_id,
        'applicant_id' =>$applicantID,
        'loan_repayment_item_id' =>$principal_id,
        'academic_year_id' =>$accademicYearID,
        'amount' =>$pricipalLoan,    
        ])->execute();
                    }
        ++$si;
        }
        $details_applicantID = EmployedBeneficiary::findBySql("SELECT * FROM employed_beneficiary WHERE  employer_id='$employerID'  AND applicant_id IS NOT NULL AND loan_summary_id IS NULL AND employment_status='ONPOST'")->all();
        foreach ($details_applicantID as $value_applicant_id) { 
           $applicantID=$value_applicant_id->applicant_id;
           
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
        }
        }
        
        public static function getIndividualEmployeesPrincipalLoan($applicantID,$billID,$loan_given_to){
        $details_amount = self::findBySql("SELECT SUM(A.amount) AS amount "
                . "FROM loan_summary_detail A INNER JOIN loan_summary C ON C.loan_summary_id=A.loan_summary_id INNER JOIN loan_repayment_item B ON B.loan_repayment_item_id=A.loan_repayment_item_id "
                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$billID' AND B.item_code='PRC' AND A.loan_given_to='$loan_given_to'")->one();
        $principal=$details_amount->amount;
         
        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
        }
    public static function getIndividualEmployeesPenalty($applicantID,$billID,$loan_given_to){
        $details_penalty = self::findBySql("SELECT SUM(A.amount) AS amount "
                . "FROM loan_summary_detail A INNER JOIN loan_summary C ON C.loan_summary_id=A.loan_summary_id INNER JOIN loan_repayment_item B ON B.loan_repayment_item_id=A.loan_repayment_item_id "
                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$billID' AND B.item_code='PNT' AND A.loan_given_to='$loan_given_to'")->one();
        $penalty=$details_penalty->amount;
         
        $value2 = (count($penalty) == 0) ? '0' : $penalty;
        return $value2;
        }
    public static function getIndividualEmployeesLAF($applicantID,$billID,$loan_given_to){
        $details_LAF = self::findBySql("SELECT SUM(A.amount) AS amount "
                . "FROM loan_summary_detail A INNER JOIN loan_summary C ON C.loan_summary_id=A.loan_summary_id INNER JOIN loan_repayment_item B ON B.loan_repayment_item_id=A.loan_repayment_item_id "
                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$billID' AND B.item_code='LAF' AND A.loan_given_to='$loan_given_to'")->one();
        $LAF=$details_LAF->amount;
         
        $value2 = (count($LAF) == 0) ? '0' : $LAF;
        return $value2;
        } 
    public static function getIndividualEmployeesVRF($applicantID,$billID,$loan_given_to){
        $details_VRF = self::findBySql("SELECT SUM(A.amount) AS amount "
                . "FROM loan_summary_detail A INNER JOIN loan_summary C ON C.loan_summary_id=A.loan_summary_id INNER JOIN loan_repayment_item B ON B.loan_repayment_item_id=A.loan_repayment_item_id "
                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$billID' AND B.item_code='VRF' AND A.loan_given_to='$loan_given_to'")->one();
        $VRF=$details_VRF->amount;
         
        $value2 = (count($VRF) == 0) ? '0' : $VRF;
        return $value2;
        }
    public static function getIndividualEmployeesTotalLoan($applicantID,$billID,$loan_given_to){
        $details_totalLoan = self::getIndividualEmployeesPrincipalLoan($applicantID,$billID,$loan_given_to) + self::getIndividualEmployeesPenalty($applicantID,$billID,$loan_given_to) + self::getIndividualEmployeesLAF($applicantID,$billID,$loan_given_to) + self::getIndividualEmployeesVRF($applicantID,$billID,$loan_given_to);
        $totalLoan=$details_totalLoan;
         
        $value2 = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value2;
        }
    public function getIndividualEmployeesOutstandingDebt($applicantID,$billID){
        $moder=new LoanRepaymentDetail();
        $LoanSummaryID=$billID;
        $alreadyPaid=$moder->getAmountTotalPaidunderBillIndividualEmployee($LoanSummaryID,$applicantID);
        $details_outstandingDebt = $this->getIndividualEmployeesTotalLoan($applicantID,$billID)-$alreadyPaid;
        $outstandingDebt=$details_outstandingDebt;
         
        $value2 = (count($outstandingDebt) == 0) ? '0' : $outstandingDebt;
        return $value2;
        }
    public function updateBeneficiaryVRFaccumulated($amountTotal,$accumulatedVRF,$applicantID,$loan_summary_id,$loan_repayment_item_id,$loan_given_to){
        $this->updateAll(['amount' =>$amountTotal,'vrf_accumulated' =>$accumulatedVRF], 'applicant_id ="'.$applicantID.'" AND loan_summary_id ="'.$loan_summary_id.'" AND loan_repayment_item_id ="'.$loan_repayment_item_id.'" AND loan_given_to="'.$loan_given_to.'"');
 }
 public function getTotalLoanBeneficiaryOriginal($applicantID){
        $si=0;
        $moder=new EmployedBeneficiary();
        $pricipalLoan1=0;
        // Loop for getting total principal        
        //$itemCodePrincipal="PRC";
        //$principal_id=$moder->getloanRepaymentItemID($itemCodePrincipal);
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT DISTINCT academic_year_id AS 'academic_year_id' FROM application WHERE  applicant_id='$applicantID'")->all();
                    foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
                    $academicYearID=$resultsApp->academic_year_id; 
                    $pricipalLoan=$moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID);
                    $pricipalLoan1 +=$pricipalLoan;
                    ++$si;
                    }   
        // end loop for calculating principal
                    //check for other charges
           //check if exists in any bill before    
        $applicantID_check2 = $this->findBySql("SELECT * FROM loan_summary_detail WHERE  applicant_id='$applicantID' ORDER BY loan_summary_detail_id ASC")->one();
        $individualApplicantBillID_check2=$applicantID_check2->loan_summary_id;
        $applicantBillResults_check2 = (count($individualApplicantBillID_check2) == '0') ? '0' : $individualApplicantBillID_check2;
        //end check if exists in any bill before
            if($applicantBillResults_check2==0){
           $vrf=$moder->getIndividualEmployeesVRF($applicantID);
            }else{
        $itemCodeVRF="VRF";
        $vrf_id=$moder->getloanRepaymentItemID($itemCodeVRF);
        
        $vrf_value = $this->findBySql("SELECT amount FROM loan_summary_detail A "
                . " WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$applicantBillResults_check2' AND A.loan_repayment_item_id='".$vrf_id."'")->one();
        $vrf1=$vrf_value->amount;
        
        $vrf_value_3 = $this->findBySql("SELECT vrf_accumulated  FROM loan_summary_detail A "
                . " WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id<>'$applicantBillResults_check2' AND A.loan_repayment_item_id='".$vrf_id."'")->one();
        $vrf2=$vrf_value_3->vrf_accumulated;
        $vrf=$vrf1 + $vrf2;
            }
           $LAF=$moder->getIndividualEmployeesLAForiginal($applicantID);
           $penalty=$moder->getIndividualEmployeesPenaltyOriginal($applicantID);
       
       $totalAmountOfBill=$LAF + $penalty + $pricipalLoan1 + $vrf;
        //$totalAmountOfBill=$PrincipleInBill;
       $value = (count($totalAmountOfBill) == '0') ? '0' : $totalAmountOfBill;
       return $value;
        }
	public static function getTotalAmountUnderBillSummary($loanSummaryID,$date,$loan_given_to){
		$detailsLoanSummary = self::findBySql("SELECT SUM(loan_summary_detail.amount) AS amount FROM loan_summary_detail INNER JOIN loan_summary ON loan_summary.loan_summary_id=loan_summary_detail.loan_summary_id "
                . "WHERE loan_summary_detail.loan_summary_id='$loanSummaryID' AND loan_summary_detail.loan_given_to='$loan_given_to'")->one();
		return $detailsLoanSummary->amount;		
	}
    public static function getOustandingAmountUnderLoanSummary($loanSummaryID,$date,$loan_given_to){
		return self::getTotalAmountUnderBillSummary($loanSummaryID,$date,$loan_given_to) - LoanRepaymentDetail::getAmountTotalPaidunderBill($loanSummaryID,$date,$loan_given_to);
	}	
}
