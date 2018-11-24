<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\User;
use backend\modules\disbursement\models\Disbursement;
use backend\modules\repayment\models\LoanRepaymentSetting;
use backend\modules\repayment\models\LoanRepaymentItem;

/**
 * This is the model class for table "employed_beneficiary".
 *
 * @property integer $employed_beneficiary_id
 * @property integer $employer_id
 * @property string $employee_id
 * @property integer $applicant_id
 * @property double $basic_salary
 * @property string $employment_status
 * @property string $created_at
 * @property integer $created_by
 *
 * @property Applicant $applicant
 * @property Employer $employer
 * @property User $createdBy
 */
class EmployedBeneficiary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employed_beneficiary';
    }

    /**
     * @inheritdoc
     */
        public $imageFile;
	public $file;
        public $employee_check_number;
        public $employee_f4indexno;
        public $employee_firstname;
        public $employee_mobile_phone_no;
        public $employee_year_completion_studies;
        public $employee_academic_awarded;
        public $employee_instituitions_studies;
        public $employee_NIN;
        public $employee_current_nameifchanged;
        public $principal;
        public $totalLoanees;
    public function rules()
    {
        return [
            [['employee_check_number','employee_f4indexno', 'employee_firstname', 'employee_mobile_phone_no','employee_NIN','basic_salary'], 'required', 'on'=>'Uploding_employed_beneficiaries'],
            [['employee_id', 'employee_mobile_phone_no','employee_NIN','basic_salary','employment_status'], 'required', 'on'=>'update_employee'],
            [['employer_id', 'applicant_id', 'created_by', 'employee_mobile_phone_no','loan_summary_id'], 'integer'],
            ['employee_mobile_phone_no', 'string', 'length' => [10, 12]],
            [['basic_salary'], 'number'],
            [['employment_status'], 'string'],
            [['employer_id', 'employee_id', 'applicant_id', 'employment_status', 'created_at', 'created_by', 'created_at',
                'employee_current_nameifchanged','NID','f4indexno','firstname','phone_number','loan_summary_id', 'principal', 'totalLoanees'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls','on'=>'Uploding_employed_beneficiaries'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls','on'=>'uploaded_files_employees'],
            [['employee_id'], 'string', 'max' => 20],
            /*
			['file', 'file','on'=>'uploaded_files_aggregates',
                                            'types'=>'csv',
                                            'maxSize'=>1024 * 1024 * 10, // 10MB
                                            'tooLarge'=>'The file was larger than 10MB. Please upload a smaller file.',
                                            'allowEmpty' => false
                              ],
             * 
             */
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['loan_summary_id'], 'exist', 'skipOnError' => true, 'targetClass' =>LoanSummary::className(), 'targetAttribute' => ['loan_summary_id' => 'loan_summary_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employed_beneficiary_id' => 'Employed Beneficiary ID',
            'employer_id' => 'Employer ID',
            'employee_id' => 'Check Number',
            'applicant_id' => 'Applicant ID',
            'basic_salary' => 'Basic Salary(TZS)',
            'employment_status' => 'Employment Status',
            'created_at' => 'Created On',
            'created_by' => 'Created By',
            'employee_check_number'=>'employee_check_number',
            'employee_f4indexno'=>'Form IV Index No.',
            'employee_firstname'=>'Employee Name',
            'employee_mobile_phone_no'=>'Employee mobile phone No.',
            'employee_year_completion_studies'=>'Employee year of completion studies',
            'employee_academic_awarded'=>'Employee academic award',
            'employee_instituitions_studies'=>'Employee instituitions studies',
            'employee_NIN'=>'National Identification No.',
            'employee_check_number'=>'Check Number',
            'NID'=>'National Identification Number',
            'f4indexno'=>'Indexno',
            'firstname'=>'Full Name',
            'phone_number'=>'Phone Number',
            'loan_summary_id'=>'Loan Repayment Bill ID',
            'principal'=>'Principle',
            'totalLoanees'=>'Total Loanees',
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
    public function getLoanSummary()
    {
        return $this->hasOne(LoanSummary::className(), ['loan_summary_id' => 'loan_summary_id']);
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
        return $this->hasOne(\frontend\modules\application\models\User::className(), ['user_id' => 'created_by']);
    }
    
    
    public function upload($date_time)
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $date_time.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            $this->imageFile->saveAs('uploads/' . $date_time.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return false;
        }
    }
    public function getindexNoApplicant($applcantF4IndexNo){
        $details = \frontend\modules\application\models\Applicant::find()
                            ->where(['f4indexno'=>$applcantF4IndexNo])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
        return $details;
        }

    public function getEmployeeUserId($applicantId){
        $details_employee_userId = \frontend\modules\application\models\Applicant::find()
                            ->where(['applicant_id'=>$applicantId])
                            ->limit(1)->one();
        return $details_employee_userId;
        } 
        public function getUserPhone($user_id){
        $details_employee_phone = User::find()
                            ->where(['user_id'=>$user_id])
                            ->limit(1)->one();
        return $details_employee_phone;
        } 
    public function updateUserPhone($phoneNumber,$user_id){
        User::updateAll(['phone_number' =>$phoneNumber ], 'user_id ="'.$user_id.'"');
 }
 
    public function updateEmployeeNane($current_name,$applicant_id,$NIN){
        Applicant::updateAll(['current_name' =>$current_name,'NID'=>$NIN], 'applicant_id ="'.$applicant_id.'"');
 }
 
    public function updateBeneficiary($checkIsmoney,$employeeExistsId){
        $this->updateAll(['basic_salary' =>$checkIsmoney], 'employed_beneficiary_id ="'.$employeeExistsId.'"');
 }
    public function checkEmployeeExists($applicantId,$employerId,$employeeId){
        $details_employee_existance = $this->find()
                            ->where(['applicant_id'=>$applicantId,'employer_id'=>$employerId,'employee_id'=>$employeeId])
                            ->orderBy('employed_beneficiary_id DESC')
                            ->limit(1)->one();
        return $details_employee_existance;
        }
    public function checkEmployeeExistsNonApplicant($f4indexno,$employerId,$employeeId){
        $employee_existance_nonApplicant = $this->find()
                            ->where(['f4indexno'=>$f4indexno,'employer_id'=>$employerId,'employee_id'=>$employeeId])
                            ->orderBy('employed_beneficiary_id DESC')
                            ->limit(1)->one();
        return $employee_existance_nonApplicant;
        }
    public function updateBeneficiaryNonApplicant($checkIsmoney,$results_nonApplicantFound,$f4indexno,$firstname,$phone_number,$NID){
        $this->updateAll(['basic_salary' =>$checkIsmoney,'f4indexno'=>$f4indexno,'firstname'=>$firstname,'phone_number'=>$phone_number,'NID'=>$NID], 'employed_beneficiary_id ="'.$results_nonApplicantFound.'"');
 }
    public function getIndividualEmployeesPrincipalLoan($applicantID){
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM(disbursed_amount) AS disbursed_amount "
                . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $principal=$details_disbursedAmount->disbursed_amount;
         
        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
        }
    public function getIndividualEmployeesPenalty($applicantID){
        $details_pnt = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
        $PNT=$details_pnt->percent; 
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM('$PNT'*disbursed_amount) AS disbursed_amount "
                . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $penalty=$details_disbursedAmount->disbursed_amount;
        $value_penalty = (count($penalty) == 0) ? '0' : $penalty;
        return $value_penalty;
        }
    public function getIndividualEmployeesLAF($applicantID){
          $details_LAF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF'")->one();
          $LAF=$details_LAF->percent; 
        
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM('$LAF'*disbursed_amount) AS disbursed_amount "
                . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $LAF_v=$details_disbursedAmount->disbursed_amount;        
        $value_LAF = (count($LAF_v) == 0) ? '0' : $LAF_v;
        return $value_LAF;
        }
    public function getIndividualEmployeesVRF($applicantID){
        $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
        $VRF=$details_VRF->percent;       
       $details_disbursedAmount = Disbursement::findBySql("SELECT SUM('$VRF'*disbursed_amount) AS disbursed_amount "
                . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $VRF_v=$details_disbursedAmount->disbursed_amount;
        $value_VRF = (count($VRF_v) == 0) ? '0' : $VRF_v;
        return $value_VRF;
        }
    public function getIndividualEmployeeTotalLoan($applicantID){
        $totalLoan=$this->getIndividualEmployeesPrincipalLoan($applicantID) + $this->getIndividualEmployeesPenalty($applicantID) + $this->getIndividualEmployeesLAF($applicantID) + $this->getIndividualEmployeesVRF($applicantID);
        
        $value_totalLoan = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value_totalLoan;
        }
    public function getAllEmployeesUnderBillunderEmployer($employerID){
        $details_count = $this->findBySql("SELECT COUNT(employed_beneficiary_id) AS 'totalLoanees' FROM employed_beneficiary WHERE  employed_beneficiary.employer_id='$employerID'  AND employed_beneficiary.applicant_id IS NOT NULL AND employed_beneficiary.loan_summary_id IS NULL AND employed_beneficiary.employment_status='ONPOST'")->one();
        $totalLoanees=$details_count->totalLoanees;
   
        $value = (count($totalLoanees) == 0) ? '0' : $totalLoanees;
        return $value;
        }
        
    public function getTotalLoanInBill($employerID){       
        $details_pnt = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
        $PNT=$details_pnt->percent;  
        $details_LAF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF'")->one();
        $LAF=$details_LAF->percent; 
        $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
        $VRF=$details_VRF->percent; 
        $details_totalAccumulatedLoan = Disbursement::findBySql("SELECT SUM((disbursed_amount)+('$PNT'*disbursed_amount)+('$LAF'*disbursed_amount)+('$VRF'*disbursed_amount)) AS 'disbursed_amount' "
                . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id INNER JOIN employed_beneficiary ON employed_beneficiary.applicant_id=application.applicant_id "
                . "WHERE  employed_beneficiary.employer_id='$employerID' AND employed_beneficiary.applicant_id IS NOT NULL AND employed_beneficiary.loan_summary_id IS NULL AND employed_beneficiary.employment_status='ONPOST'")->one();
        $total=$details_totalAccumulatedLoan->disbursed_amount;
        $value = (count($total) == 0) ? '0' : $total;
        return $value;
        }
    public function getloanRepaymentItemID($itemCode){
        $details_item = LoanRepaymentItem::findBySql("SELECT loan_repayment_item_id FROM loan_repayment_item WHERE  loan_repayment_item.item_code='$itemCode'")->one();
        $details_v=$details_item->loan_repayment_item_id; 
        $value = (count($details_v) == 0) ? '0' : $details_v;
        return $value;
        }
    public function getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID,$academicYearID){
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM(disbursed_amount) AS disbursed_amount "
                . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID' AND application.academic_year_id='$academicYearID'")->one();
        $principal=$details_disbursedAmount->disbursed_amount;
         
        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
        }
}
