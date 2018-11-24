<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\application\models\Applicant;
//use backend\modules\allocation\models\AcademicYear;
use \common\models\AcademicYear;
use frontend\modules\repayment\models\LoanSummaryDetail;
use frontend\modules\repayment\models\LoanRepaymentDetail;
use frontend\modules\repayment\models\EmployedBeneficiary;
//use frontend\modules\application\models\User;
use \common\models\User;
use backend\modules\disbursement\models\Disbursement;
use backend\modules\repayment\models\LoanRepaymentSetting;
use backend\modules\repayment\models\LoanRepaymentItem;
use frontend\modules\application\models\Application;
use backend\models\SystemSetting;
use \backend\modules\application\models\Ward;
use \backend\modules\application\models\LearningInstitution;

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
class EmployedBeneficiary extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'employed_beneficiary';
    }

    /**
     * @inheritdoc
     */
    public $employeesFile;
    public $file;
    public $employee_check_number;
    public $employee_f4indexno;
    public $employee_mobile_phone_no;
    public $employee_year_completion_studies;
    public $employee_academic_awarded;
    public $employee_instituitions_studies;
    public $employee_NIN;
    public $employee_current_nameifchanged;
    public $principal;
	public $penalty;
	public $LAF;
	public $VRF;
	public $totalLoan;
	public $paid;
	public $outstanding;
    public $totalLoanees;
    public $employee_FIRST_NAME;
    public $employee_MIDDLE_NAME;
    public $employee_SURNAME;
    public $employee_DATE_OF_BIRTH;
    public $employee_PLACE_OF_BIRTH;
    public $employee_YEAR_OF_COMPLETION_STUDIES;
    public $employee_ACADEMIC_AWARD;
    public $employee_NAME_OF_INSTITUTION_OF_STUDY;
    public $amount;
    public $employerName;
	public $region;
	public $district;
	public $firstname1;
	public $employmentStatus2;


    public function rules() {
        return [
            [['employee_check_number', 'employee_mobile_phone_no', 'basic_salary', 'employee_FIRST_NAME', 'employee_MIDDLE_NAME', 'employee_SURNAME', 'employee_DATE_OF_BIRTH', 'employee_PLACE_OF_BIRTH', 'employee_NAME_OF_INSTITUTION_OF_STUDY'], 'required', 'on' => 'Uploding_employed_beneficiaries'],
			[['firstname', 'middlename','surname','f4indexno','employee_id','phone_number','basic_salary', 'sex', 'learning_institution_id', 'district', 'ward_id', 'date_of_birth','region'], 'required', 'on' => 'additionalEmployee'],
            //[['employee_id', 'employee_mobile_phone_no', 'basic_salary', 'employment_status'], 'required', 'on' => 'update_employee'],
			
			[['firstname', 'middlename','surname','f4indexno','employee_id','phone_number','basic_salary', 'sex', 'learning_institution_id', 'district', 'ward_id', 'date_of_birth','region'], 'required', 'on' => 'update_employee'],
			[['firstname', 'middlename','surname','employee_id','phone_number','basic_salary', 'sex','employment_status'], 'required', 'on' => 'update_beneficiary'],
			
            [['employer_id', 'applicant_id', 'created_by', 'employee_mobile_phone_no', 'loan_summary_id'], 'integer'],
            ['employee_mobile_phone_no', 'string', 'length' => [10, 12]],
            [['basic_salary'], 'number'],
            [['employment_status', 'employee_FIRST_NAME', 'employee_MIDDLE_NAME', 'employee_SURNAME', 'employee_DATE_OF_BIRTH', 'employee_PLACE_OF_BIRTH', 'employee_YEAR_OF_COMPLETION_STUDIES', 'employee_ACADEMIC_AWARD', 'employee_NAME_OF_INSTITUTION_OF_STUDY'], 'string'],
            [['employer_id', 'employee_id', 'applicant_id', 'employment_status', 'created_at', 'created_by', 'created_at',
            'employee_current_nameifchanged', 'NID', 'f4indexno', 'phone_number', 'loan_summary_id','principal','penalty','LAF','VRF','totalLoan','paid','outstanding', 'totalLoanees', 'employee_FIRST_NAME', 'employee_MIDDLE_NAME', 'employee_SURNAME', 'employee_DATE_OF_BIRTH', 'employee_PLACE_OF_BIRTH', 'employee_YEAR_OF_COMPLETION_STUDIES', 'employee_ACADEMIC_AWARD', 'employee_NAME_OF_INSTITUTION_OF_STUDY', 'amount', 'verification_status' , 'employerName','district','ward_id','learning_institution_id','sex','firstname','middlename','surname','region','firstname1','employmentStatus2'], 'safe'],
            [['employeesFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls', 'on' => 'Uploding_employed_beneficiaries'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls', 'on' => 'uploaded_files_employees'],
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
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['loan_summary_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanSummary::className(), 'targetAttribute' => ['loan_summary_id' => 'loan_summary_id']],
			[['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
			[['ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['ward_id' => 'ward_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'employed_beneficiary_id' => 'Employed Beneficiary ID',
            'employer_id' => 'Employer ID',
            'employee_id' => 'Check Number',
            'applicant_id' => 'Applicant ID',
            'basic_salary' => 'Basic Salary(TZS)',
            'employment_status' => 'Employment Status',
            'created_at' => 'Created On',
            'created_by' => 'Created By',
            'employee_check_number' => 'employee_check_number',
            'employee_f4indexno' => 'Form IV Index No.',
            'employee_mobile_phone_no' => 'Employee mobile phone No.',
            'employee_year_completion_studies' => 'Employee year of completion studies',
            'employee_academic_awarded' => 'Employee academic award',
            'employee_instituitions_studies' => 'Employee instituitions studies',
            'employee_NIN' => 'National Identification No.',
            'employee_check_number' => 'Check Number',
            'NID' => 'National Identification Number',
            'f4indexno' => 'Indexno',
            'phone_number' => 'Phone Number',
            'loan_summary_id' => 'Loan Repayment Bill ID',
            'principal' => 'Principle',
            'totalLoanees' => 'Total Loanees',
            'amount' => 'Amount',
            'verification_status' => 'Verification Status',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'surname' => 'Last name',
            'employerName' => 'Employer Name',
			'ward_id'=>'Ward',
			'district'=>'District',
			'learning_institution_id'=>'Learning Institution',
			'sex'=>'Gender',
			'region'=>'Region',
			'firstname1'=>'firstname1',
			'penalty'=>'Penalty',
			'LAF'=>'LAF',
			'VRF'=>'VRF',
			'totalLoan'=>'Total Loan',
			'paid'=>'Paid',
			'outstanding'=>'Outstanding Loan',
			'employmentStatus2'=>'Employment Status',
			
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant() {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSummary() {
        return $this->hasOne(LoanSummary::className(), ['loan_summary_id' => 'loan_summary_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer() {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }
	/**
     * @return \yii\db\ActiveQuery
     */
	public function getLearningInstitution() {
        return $this->hasOne(\backend\modules\application\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }
	/**
     * @return \yii\db\ActiveQuery
     */
	public function getWard() {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'ward_id']);
    }

    public function upload($date_time) {
        if ($this->validate()) {
            $this->employeesFile->saveAs('uploads/' . $date_time . $this->employeesFile->baseName . '.' . $this->employeesFile->extension);
            return true;
        } else {
            $this->employeesFile->saveAs('uploads/' . $date_time . $this->employeesFile->baseName . '.' . $this->employeesFile->extension);
            return false;
        }
    }

    public function getindexNoApplicant($applcantF4IndexNo) {
        $details = \frontend\modules\application\models\Applicant::find()
                        ->where(['f4indexno' => $applcantF4IndexNo])
                        ->orderBy('applicant_id DESC')
                        ->limit(1)->one();
        return $details;
    }

    public function getApplicantDetails($applcantF4IndexNo, $NIN) {
        if ($applcantF4IndexNo != '' && $NIN != '') {

            $details1 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE  f4indexno='$applcantF4IndexNo' AND NID='$NIN' ORDER BY applicant_id DESC")->one();
            $applicantResult = $details1->applicant_id;

            $value1 = (count($applicantResult) == 0) ? '0' : '1';
            if ($value1 == 0) {
                $details2 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE f4indexno='$applcantF4IndexNo' ORDER BY applicant_id DESC")->one();
                $applicantResult2 = $details2->applicant_id;
                $value2 = (count($applicantResult2) == 0) ? '0' : '1';
                if ($value2 == 0) {
                    $details3 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE NID='$NIN' ORDER BY applicant_id DESC")->one();
                    $applicantResult3 = $details3->applicant_id;
                    $value3 = (count($applicantResult3) == 0) ? '0' : '1';
                    if ($value3 == 1) {
                        $resultsFound = $applicantResult3;
                    } else {
                        $resultsFound = $applicantResult3;
                    }
                } else {
                    $resultsFound = $details2;
                }
            } else {
                $resultsFound = $details1;
            }
        } else if ($applcantF4IndexNo == '' && $NIN != '') {
            $details_4 = \frontend\modules\application\models\Applicant::find()
                            ->where(['NID' => $NIN])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
            $resultsFound = $details_4;
        } else if ($applcantF4IndexNo != '' && $NIN == '') {
            $details_5 = \frontend\modules\application\models\Applicant::find()
                            ->where(['f4indexno' => $applcantF4IndexNo])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
            $resultsFound = $details_5;
        } else if ($applcantF4IndexNo == '' && $NIN == '') {
            $resultsFound = "";
        }
        return $resultsFound;
    }

    public function getApplicantDetailsUsingNonUniqueIdentifiers($firstname, $middlename, $surname, $dateofbirth, $placeofbirth, $academicInstitution) {
        $details_applicant = Applicant::findBySql("SELECT * FROM applicant INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN application ON application.applicant_id=applicant.applicant_id INNER JOIN programme ON programme.programme_id=application.programme_id INNER JOIN ward ON ward.ward_id=applicant.place_of_birth INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id "
                        . "WHERE  user.firstname='$firstname' AND user.middlename='$middlename' AND user.surname='$surname' AND applicant.date_of_birth='$dateofbirth' AND ward.ward_name='$placeofbirth' AND learning_institution.institution_name ='$academicInstitution' ORDER BY applicant.applicant_id DESC")->one();
        $applicant_idR = $details_applicant->applicant_id;
        $results = (count($applicant_idR) == 0) ? '0' : $details_applicant;
        return $results;
    }

    public function getApplicantDetailsUsingNonUniqueIdentifiers2($firstname, $middlename, $surname, $dateofbirth, $placeofbirth, $academicInstitution) {
        $details_applicant = Applicant::findBySql("SELECT * FROM applicant INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN application ON application.applicant_id=applicant.applicant_id INNER JOIN programme ON programme.programme_id=application.programme_id INNER JOIN ward ON ward.ward_id=applicant.place_of_birth INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id "
                        . "WHERE  user.firstname='$firstname' AND user.middlename='$middlename' AND user.surname='$surname' AND applicant.date_of_birth='$dateofbirth' AND ward.ward_name='$placeofbirth' AND learning_institution.learning_institution_id='$academicInstitution' ORDER BY applicant.applicant_id DESC")->one();
        $applicant_idR = $details_applicant->applicant_id;
        $results = (count($applicant_idR) == 0) ? '0' : $details_applicant;
        return $results;
    }

    public function getEmployeeUserId($applicantId) {
        $details_employee_userId = \frontend\modules\application\models\Applicant::find()
                        ->where(['applicant_id' => $applicantId])
                        ->limit(1)->one();
        return $details_employee_userId;
    }

    public function getUserPhone($user_id) {
        $details_employee_phone = User::find()
                        ->where(['user_id' => $user_id])
                        ->limit(1)->one();
        return $details_employee_phone;
    }

    public function updateUserPhone($phoneNumber, $user_id) {
        User::updateAll(['phone_number' => $phoneNumber], 'user_id ="' . $user_id . '"');
    }

    public function updateEmployeeNane($current_name, $applicant_id, $NIN) {
        Applicant::updateAll(['current_name' => $current_name, 'NID' => $NIN], 'applicant_id ="' . $applicant_id . '"');
    }

    public function updateBeneficiary($checkIsmoney, $employeeExistsId) {
        $this->updateAll(['basic_salary' => $checkIsmoney], 'employed_beneficiary_id ="' . $employeeExistsId . '"');
    }

    public function checkEmployeeExists($applicantId, $employerId, $employeeId) {
        $details_employee_existance = $this->find()
                        ->where(['applicant_id' => $applicantId, 'employer_id' => $employerId, 'employee_id' => $employeeId])
                        ->orderBy('employed_beneficiary_id DESC')
                        ->limit(1)->one();
        return $details_employee_existance;
    }

    public function checkEmployeeExistsNonApplicant($f4indexno, $employerId, $employeeId) {
        $employee_existance_nonApplicant = $this->find()
                        ->where(['f4indexno' => $f4indexno, 'employer_id' => $employerId, 'employee_id' => $employeeId])
                        ->orderBy('employed_beneficiary_id DESC')
                        ->limit(1)->one();
        return $employee_existance_nonApplicant;
    }

    public function updateBeneficiaryNonApplicant($checkIsmoney, $results_nonApplicantFound, $f4indexno, $firstname, $phone_number, $NID) {
        $this->updateAll(['basic_salary' => $checkIsmoney, 'f4indexno' => $f4indexno, 'firstname' => $firstname, 'phone_number' => $phone_number, 'NID' => $NID], 'employed_beneficiary_id ="' . $results_nonApplicantFound . '"');
    }

    public static function getIndividualEmployeesPrincipalLoan($applicantID) {
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM(disbursed_amount) AS disbursed_amount "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $principal = $details_disbursedAmount->disbursed_amount;

        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
    }

    public function getIndividualEmployeesPrincipalLoanUnderBill($applicantID, $loan_summary_id) {
        $itemCodePrincipal = "PRC";
        $principal_id = $this->getloanRepaymentItemID($itemCodePrincipal);
        $details_amount = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS amount "
                        . "FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='$principal_id' AND loan_summary_id='$loan_summary_id'")->one();
        $principal = $details_amount->amount;

        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
    }

    public function getOutstandingPrincipalLoan($applicantID) {
        $OutstandingAmount = $this->getIndividualEmployeesPrincipalLoan($applicantID) - $this->getIndividualEmployeePaidPrincipalLoan($applicantID);
        //$OutstandingAmount=$this->getIndividualEmployeesPrincipalLoan($applicantID);
        $value = (count($OutstandingAmount) == 0) ? '0' : $OutstandingAmount;
        return $value;
    }

    public function getOutstandingPrincipalLoanUnderBill($applicantID, $loan_summary_id) {
        $OutstandingAmount = $this->getIndividualEmployeesPrincipalLoanUnderBill($applicantID, $loan_summary_id) - $this->getIndividualEmployeePaidPrincipalLoanUnderBill($applicantID, $loan_summary_id);
        //$OutstandingAmount=$this->getIndividualEmployeesPrincipalLoan($applicantID);
        $value = (count($OutstandingAmount) == 0) ? '0' : $OutstandingAmount;
        return $value;
    }

    public function getstartToEndAcademicYrOfBeneficiary($applicantID, $filter) {
        $details_academicY = AcademicYear::findBySql("SELECT academic_year.academic_year_id AS 'academic_year_id',academic_year.academic_year AS 'academic_year' FROM academic_year INNER JOIN application ON academic_year.academic_year_id=application.academic_year_id WHERE  application.applicant_id='$applicantID'  ORDER BY application.application_id $filter")->one();
        $academicYid = $details_academicY->academic_year_id;
        $LastacademicYear = $details_academicY->academic_year;
        $value_academicY = (count($academicYid) == 0) ? '0' : $LastacademicYear;
        return $value_academicY;
    }

    public function getExplodeAcademicYear($academicYear) {
        if ($academicYear != '0') {
            $YearV = explode("/", $academicYear);
            $Year_V1 = $YearV[1];
            $Year_V2 = $YearV[0];
            $lastV2 = strlen($Year_V1);
            if ($lastV2 == 2) {
                $starting = substr($Year_V2, 0, 2);
                $Year = $starting . $Year_V1;
            } else {
                $Year = $Year_V1;
            }
        } else {
            $Year = 0;
        }
        return $Year;
    }

    public static function getIndividualEmployeesPenalty($applicantID) {
        /*
          $details_pnt = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
          $PNT=$details_pnt->percent;
          $loan_repayment_item_id=$details_pnt->loan_repayment_item_id;
         */

        $details_pnt = EmployedBeneficiary::getPNTsetting();
        $PNT = $details_pnt->percent;
        $loan_repayment_item_id = $details_pnt->loan_repayment_item_id;

        /*
          $details_gracePeriod = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.percent AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LGP'")->one();
          $gracePeriod=$details_gracePeriod->percent;
         */
        $gracePeriod = EmployedBeneficiary::getGracePeriodSetting();

        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM('$PNT'*disbursed_amount) AS disbursed_amount "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $penalty = $details_disbursedAmount->disbursed_amount;
        $value_penalty = (count($penalty) == 0) ? '0' : $penalty;

        //---get last academic year----------
        $filter = "DESC";
        $value_academicY = $this->getstartToEndAcademicYrOfBeneficiary($applicantID, $filter);
        if ($value_academicY != '0') {
            $lastYearV = explode("/", $value_academicY);
            $lastYear_V1 = $lastYearV[1];
            $lastYear_V2 = $lastYearV[0];
            $lastV2 = strlen($lastYear_V1);
            if ($lastV2 == 2) {
                $starting = substr($lastYear_V2, 0, 2);
                $finalAcademicYear = $starting . $lastYear_V1;
            } else {
                $finalAcademicYear = $lastYear_V1;
            }
        } else {
            $finalAcademicYear = date("Y");
        }
        $currentYear = date("Y");
        //---checking grace period---
        $periodPendingUnpaid = ($currentYear - $finalAcademicYear) * 365;
        //---end for grace period----
        //--------end last academic year-----
        //----check penalty paid---
        $details_penalty_status = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$loan_repayment_item_id' AND loan_repayment_detail.applicant_id='$applicantID'")->one();
        $penalty_paid = $details_penalty_status->amount;
        $value_penalty_paid2 = (count($penalty_paid) == 0) ? '0' : $penalty_paid;
        //----end check----
        if (($periodPendingUnpaid > $gracePeriod) && $value_penalty_paid2 == '0') {
            $penalty_to_pay = $value_penalty;
        } else if (($periodPendingUnpaid < $gracePeriod) && $value_penalty_paid2 == '0') {
            $penalty_to_pay = '0';
        } else if (($periodPendingUnpaid == $gracePeriod) && $value_penalty_paid2 == '0') {
            $penalty_to_pay = '0';
        } else {
            if ($value_penalty_paid2 >= $value_penalty) {
                $penalty_to_pay = '0';
            } else if ($value_penalty_paid2 < $value_penalty) {
                $penalty_to_pay = $value_penalty - $value_penalty_paid2;
            }
        }
        return $penalty_to_pay;
        //return $gracePeriod;
    }

    public function getIndividualEmployeesPenaltyUnderBill($applicantID, $loan_summary_id) {
        $itemCodePNT = "PNT";
        $PNT_id = EmployedBeneficiary::getloanRepaymentItemID($itemCodePNT);
//        $detailsAmountChargesPNT_3 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1 FROM loan_summary_detail A "
//                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='".$PNT_id."'")->one();
//        
//        $detailsAmountChargesPNT_paid = LoanRepayment::findBySql("SELECT SUM(A.amount) AS amount1, C.amount AS amount FROM loan_repayment A INNER JOIN (select b.loan_repayment_id AS loan_repayment_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='".$PNT_id."' AND D.payment_status='1' group by b.loan_repayment_id) C on A.loan_repayment_id = C.loan_repayment_id "
//                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='".$PNT_id."'")->one();


        $detailsAmountChargesPNT_3_1 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1 FROM loan_summary_detail A "
                        . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='" . $PNT_id . "'")->one();
        $detailsAmountChargesPNT_paid_1 = LoanRepaymentDetail::findBySql("select b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='" . $PNT_id . "' AND D.payment_status='1' group by b.loan_summary_id")->one();

        $TotalChargesInBillPNT_3 = $detailsAmountChargesPNT_3_1->amount1;
        $TotalChargesPaidUnderBillPNT_3 = $detailsAmountChargesPNT_paid_1->amount;
        $penalty_3 = $TotalChargesInBillPNT_3 - $TotalChargesPaidUnderBillPNT_3;
        $value_penalty_topay = (count($penalty_3) == 0) ? '0' : $penalty_3;

        return $value_penalty_topay;
        //return $gracePeriod;
    }

    public function getIndividualEmployeesPenaltyOriginal($applicantID) {
        /*
          $details_pnt = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
          $PNT=$details_pnt->percent;
          $loan_repayment_item_id=$details_pnt->loan_repayment_item_id;
         */
        $details_pnt = EmployedBeneficiary::getPNTsetting();
        $PNT = $details_pnt->percent;
        $loan_repayment_item_id = $details_pnt->loan_repayment_item_id;
        /*
          $details_gracePeriod = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.percent AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LGP'")->one();
          $gracePeriod=$details_gracePeriod->percent;
         */
        $gracePeriod = EmployedBeneficiary::getGracePeriodSetting();

        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM('$PNT'*disbursed_amount) AS disbursed_amount "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $penalty = $details_disbursedAmount->disbursed_amount;
        $value_penalty = (count($penalty) == 0) ? '0' : $penalty;

        //---get last academic year----------
        $filter = "DESC";
        $value_academicY = $this->getstartToEndAcademicYrOfBeneficiary($applicantID, $filter);
        $finalAcademicYear = EmployedBeneficiary::getExplodeAcademicYear($value_academicY);
        if ($finalAcademicYear != '0') {
            $finalAcademicYear = $finalAcademicYear;
        } else {
            $finalAcademicYear = date("Y");
        }
        $currentYear = date("Y");
        //---checking grace period---
        $periodPendingUnpaid = $currentYear - $finalAcademicYear;
        //---end for grace period----
        //--------end last academic year-----
        //----check penalty paid---
        $details_penalty_status = LoanRepaymentDetail::findBySql("SELECT  SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$loan_repayment_item_id' AND loan_repayment_detail.applicant_id='$applicantID' ORDER BY loan_repayment.loan_repayment_id ASC")->one();
        $penalty_paid = $details_penalty_status->amount;
        //$pedate_control_received=date("Y",strtotime($details_penalty_status->date_control_received));
        $pedate_control_received = date("Y");
        $value_penalty_paid2 = (count($penalty_paid) == 0) ? '0' : $penalty_paid;
        $firstDatePaymentDone = date("Y", strtotime($pedate_control_received));
        if ($value_penalty_paid2 > 0) {
            $timeIntervalFound2 = $pedate_control_received - $finalAcademicYear;
        } else {
            $timeIntervalFound2 = 0;
        }
        //----end check----
        if (($periodPendingUnpaid > $gracePeriod) && $value_penalty_paid2 == '0') {
            $penalty_to_pay = $value_penalty;
        } else if (($periodPendingUnpaid > $gracePeriod) && $value_penalty_paid2 > '0' && $timeIntervalFound2 > $gracePeriod) {
            $penalty_to_pay = $value_penalty;
        } else if (($periodPendingUnpaid < $gracePeriod) && $value_penalty_paid2 == '0') {
            $penalty_to_pay = '0';
        } else if (($periodPendingUnpaid == $gracePeriod) && $value_penalty_paid2 == '0') {
            $penalty_to_pay = '0';
        } else {
            $penalty_to_pay = '0';
        }
        return $penalty_to_pay;
        //return $gracePeriod;
    }

    public static function getIndividualEmployeesLAF($applicantID) {
        /*
          $details_LAF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF'")->one();
          $LAF=$details_LAF->percent;
          $loan_repayment_item_id=$details_LAF->loan_repayment_item_id;
         */
        $details_LAF = EmployedBeneficiary::getLAFsetting();
        $LAF = $details_LAF->percent;
        $loan_repayment_item_id = $details_LAF->loan_repayment_item_id;

        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM('$LAF'*disbursed_amount) AS disbursed_amount "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $LAF_v = $details_disbursedAmount->disbursed_amount;
        $value_LAF = (count($LAF_v) == 0) ? '0' : $LAF_v;
        //----check LAF paid---
        $details_laf_status = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$loan_repayment_item_id' AND loan_repayment_detail.applicant_id='$applicantID'")->one();
        $LAF_paid = $details_laf_status->amount;
        $value_LAF_paid2 = (count($LAF_paid) == 0) ? '0' : $LAF_paid;
        //----end check----
        if ($value_LAF_paid2 >= $value_LAF) {
            $LAF_to_pay = '0';
        } else if ($value_LAF_paid2 < $value_LAF) {
            $LAF_to_pay = $value_LAF - $value_LAF_paid2;
        }
        return $LAF_to_pay;
        //return $value_LAF;
    }

    public function getIndividualEmployeesLAFUnderBill($applicantID, $loan_summary_id) {
        $itemCodeLAF = "LAF";
        $LAF_id = EmployedBeneficiary::getloanRepaymentItemID($itemCodeLAF);
        $detailsAmountChargesLAF_3_1 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1 FROM loan_summary_detail A "
                        . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='" . $LAF_id . "'")->one();
        $detailsAmountChargesLAF_paid_1 = LoanRepaymentDetail::findBySql("select b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='" . $LAF_id . "' AND D.payment_status='1' group by b.loan_summary_id")->one();

        $TotalChargesInBillLAF_3 = $detailsAmountChargesLAF_3_1->amount1;
        $TotalChargesPaidUnderBillLAF_3 = $detailsAmountChargesLAF_paid_1->amount;
        $LAF_3 = $TotalChargesInBillLAF_3 - $TotalChargesPaidUnderBillLAF_3;
        $value_LAF_topay = (count($LAF_3) == 0) ? '0' : $LAF_3;
        return $value_LAF_topay;
    }

    public function getIndividualEmployeesLAForiginal($applicantID) {
        /*
          $details_LAF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF'")->one();
          $LAF=$details_LAF->percent;
          $loan_repayment_item_id=$details_LAF->loan_repayment_item_id;
         */
        $details_LAF = EmployedBeneficiary::getLAFsetting();
        $LAF = $details_LAF->percent;
        $loan_repayment_item_id = $details_LAF->loan_repayment_item_id;

        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM('$LAF'*disbursed_amount) AS disbursed_amount "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID'")->one();
        $LAF_v = $details_disbursedAmount->disbursed_amount;
        $value_LAF = (count($LAF_v) == 0) ? '0' : $LAF_v;
        return $value_LAF;
    }

    public static function getIndividualEmployeesVRF($applicantID) {
        $moder = new EmployedBeneficiary();
        /*
          $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
          $VRF=$details_VRF->percent;
         */
        $details_VRF = EmployedBeneficiary::getVRFsetting();
        $VRF = $details_VRF->percent;
        $vrfGeneralCalculationMode = $details_VRF->calculation_mode;
        //---checking time intervals----------
        $filter = "ASC";
        $value_academicY = EmployedBeneficiary::getstartToEndAcademicYrOfBeneficiary($applicantID, $filter);
        $firstAcademicYear = EmployedBeneficiary::getExplodeAcademicYear($value_academicY);
        $currentYear = date("Y");
        //$vrfGeneralCalculationMode=2;        
        if ($firstAcademicYear != 0) {
            if ($vrfGeneralCalculationMode == 2) {
                //---get total years from the first accademic year--
                $firstVRFCondition_getCompleteYrs = $currentYear - $firstAcademicYear;
                //-----end of total years from the first accademic year--
                //----get total days passed for the current year---
                $secondVRFCondition_getTotalDaysInCurrentYr = date('z') + 1;
            }
            //-----end total days passed for the current year
        }
        //--------end checking time interval-----
        $iterations = 0;
        $totlaVRF1 = 0;
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT application.academic_year_id AS 'academic_year_id',academic_year.academic_year AS 'academic_year' FROM application INNER JOIN academic_year ON academic_year.academic_year_id=application.academic_year_id  WHERE  application.applicant_id='$applicantID' GROUP BY application.academic_year_id  ORDER BY application.application_id ASC")->all();
        foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
            $academicYearID = $resultsApp->academic_year_id;
            $academicYr = $resultsApp->academicYear->academic_year;
            $pricipalLoan = $moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID, $academicYearID);
            $valueInterval = $firstVRFCondition_getCompleteYrs - $iterations;
            $value_year = EmployedBeneficiary::getExplodeAcademicYear($academicYr);
            if ($value_year < $currentYear) {
                $totlaVRF1 +=$valueInterval * $pricipalLoan * $VRF;
            }
            ++$iterations;
        }
        //---here VRF will stop automatically once the remaining priciple loan is zero
        $outstandingPrincipalLoan = EmployedBeneficiary::getOutstandingPrincipalLoan($applicantID);
        $totlaVRF2 = ($secondVRFCondition_getTotalDaysInCurrentYr * $VRF * $outstandingPrincipalLoan) / 365;
        $paidVRFTotal = EmployedBeneficiary::getIndividualEmployeePaidVRF($applicantID);
        $overallVRFPending = ($totlaVRF1 + $totlaVRF2) - $paidVRFTotal;
        if ($overallVRFPending > 0) {
            $overallVRFPending1 = $overallVRFPending;
        } else {
            $overallVRFPending1 = 0;
        }
        $value_VRFTOTAL = (count($overallVRFPending1) == 0) ? '0' : $overallVRFPending1;
        return $value_VRFTOTAL;
        //return $totlaVRF2;
    }

    public function getIndividualEmployeesVRFUnderBill($applicantID, $loan_summary_id) {
        $itemCodeVRF = "VRF";
        $vrf_id = EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);

//        $detailsAmountChargesVRF_3 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1, C.amount AS amount FROM loan_summary_detail A INNER JOIN (select b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='".$vrf_id."' AND D.payment_status='1' group by b.loan_summary_id) C on A.loan_summary_id = C.loan_summary_id "
//                . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='".$vrf_id."'")->one();
//        

        $detailsAmountChargesVRF_3_1 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1 FROM loan_summary_detail A "
                        . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='" . $vrf_id . "'")->one();
        $detailsAmountChargesVRF_paid_1 = LoanRepaymentDetail::findBySql("select b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='" . $vrf_id . "' AND D.payment_status='1' group by b.loan_summary_id")->one();


        $TotalChargesInBillVRF_3 = $detailsAmountChargesVRF_3_1->amount1;
        $TotalChargesPaidUnderBillVRF_3 = $detailsAmountChargesVRF_paid_1->amount;
        $vrf_3 = $TotalChargesInBillVRF_3 - $TotalChargesPaidUnderBillVRF_3;
        $value_topay = (count($vrf_3) == 0) ? '0' : $vrf_3;
        return $value_topay;
        //return $totlaVRF2;
    }

    public function getIndividualEmployeesVRFuptonow($applicantID) {
        $moder = new EmployedBeneficiary();
        /*
          $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
          $VRF=$details_VRF->percent;
         */
        $details_VRF = $this->getVRFsetting();
        $VRF = $details_VRF->percent;

        $filter = "ASC";
        $value_academicY = EmployedBeneficiary::getstartToEndAcademicYrOfBeneficiary($applicantID, $filter);
        $firstAcademicYear = EmployedBeneficiary::getExplodeAcademicYear($value_academicY);
        $currentYear = date("Y");
        $vrfGeneralCalculationMode = 2;
        if ($firstAcademicYear != 0) {
            if ($vrfGeneralCalculationMode == 2) {
                //---get total years from the first accademic year--
                $firstVRFCondition_getCompleteYrs = $currentYear - $firstAcademicYear;
                //-----end of total years from the first accademic year--
                //----get total days passed for the current year---
                $secondVRFCondition_getTotalDaysInCurrentYr = date('z') + 1;
            }
            //-----end total days passed for the current year
        }
        //--------end checking time interval-----
        $iterations = 0;
        $totlaVRF1 = 0;
        $getDistinctAccademicYrPerApplicant = Application::findBySql("SELECT application.academic_year_id AS 'academic_year_id',academic_year.academic_year AS 'academic_year' FROM application INNER JOIN academic_year ON academic_year.academic_year_id=application.academic_year_id  WHERE  application.applicant_id='$applicantID' GROUP BY application.academic_year_id  ORDER BY application.application_id ASC")->all();
        foreach ($getDistinctAccademicYrPerApplicant as $resultsApp) {
            $academicYearID = $resultsApp->academic_year_id;
            $academicYr = $resultsApp->academicYear->academic_year;
            $pricipalLoan = $moder->getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID, $academicYearID);
            $valueInterval = $firstVRFCondition_getCompleteYrs - $iterations;
            $value_year = EmployedBeneficiary::getExplodeAcademicYear($academicYr);
            if ($value_year < $currentYear) {
                $totlaVRF1 +=$valueInterval * $pricipalLoan * $VRF;
            }
            ++$iterations;
        }
        //---here VRF will stop automatically once the remaining priciple loan is zero
        $outstandingPrincipalLoan = EmployedBeneficiary::getOutstandingPrincipalLoan($applicantID);
        $totlaVRF2 = ($secondVRFCondition_getTotalDaysInCurrentYr * $VRF * $outstandingPrincipalLoan) / 365;
        //$paidVRFTotal=$this->getIndividualEmployeePaidVRF($applicantID);
        $overallVRFPending = ($totlaVRF1 + $totlaVRF2);
        if ($overallVRFPending > 0) {
            $overallVRFPending1 = $overallVRFPending;
        } else {
            $overallVRFPending1 = 0;
        }
        $value_VRFTOTAL = (count($overallVRFPending1) == 0) ? '0' : $overallVRFPending1;
        return $value_VRFTOTAL;
        //return $totlaVRF2;
    }

    public static function getIndividualEmployeeTotalLoan($applicantID) {
        //getOutstandingPrincipalLoan($applicantID)
        //$totalLoan=$this->getIndividualEmployeesPrincipalLoan($applicantID) + $this->getIndividualEmployeesPenalty($applicantID) + $this->getIndividualEmployeesLAF($applicantID) + $this->getIndividualEmployeesVRF($applicantID);
        $totalLoan = EmployedBeneficiary::getOutstandingPrincipalLoan($applicantID) + EmployedBeneficiary::getIndividualEmployeesPenalty($applicantID) + EmployedBeneficiary::getIndividualEmployeesLAF($applicantID) + EmployedBeneficiary::getIndividualEmployeesVRF($applicantID);

        $value_totalLoan = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value_totalLoan;
    }

    public function getIndividualEmployeeTotalLoanUnderBill($applicantID, $loan_summary_id) {
        $totalLoan = EmployedBeneficiary::getOutstandingPrincipalLoanUnderBill($applicantID, $loan_summary_id) + EmployedBeneficiary::getIndividualEmployeesPenaltyUnderBill($applicantID, $loan_summary_id) + EmployedBeneficiary::getIndividualEmployeesLAFUnderBill($applicantID, $loan_summary_id) + EmployedBeneficiary::getIndividualEmployeesVRFUnderBill($applicantID, $loan_summary_id);

        $value_totalLoan = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value_totalLoan;
    }

    public function getIndividualEmployeeTotalLoanOriginal($applicantID) {
        $totalLoan = EmployedBeneficiary::getIndividualEmployeesPrincipalLoan($applicantID) + EmployedBeneficiary::getIndividualEmployeesPenaltyOriginal($applicantID) + EmployedBeneficiary::getIndividualEmployeesLAForiginal($applicantID) + EmployedBeneficiary::getIndividualEmployeesVRFuptonow($applicantID);

        $value_totalLoan = (count($totalLoan) == 0) ? '0' : $totalLoan;
        return $value_totalLoan;
    }

    public function getAllEmployeesUnderBillunderEmployer($employerID) {
        $details_count = $this->findBySql("SELECT COUNT(employed_beneficiary_id) AS 'totalLoanees' FROM employed_beneficiary WHERE  employed_beneficiary.employer_id='$employerID'  AND employed_beneficiary.applicant_id IS NOT NULL AND employed_beneficiary.loan_summary_id IS NULL AND employed_beneficiary.employment_status='ONPOST'")->one();
        $totalLoanees = $details_count->totalLoanees;

        $value = (count($totalLoanees) == 0) ? '0' : $totalLoanees;
        return $value;
    }

    public function getTotalLoanInBill($employerID) {
        /* 	
          $details_pnt = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT'")->one();
          $PNT=$details_pnt->percent;
          $details_LAF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF'")->one();
          $LAF=$details_LAF->percent;
          $details_VRF = LoanRepaymentSetting::findBySql("SELECT percent*0.01 AS 'percent' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF'")->one();
          $VRF=$details_VRF->percent;
         */
        $details_pnt = $this->getPNTsetting();
        $PNT = $details_pnt->percent;

        $details_LAF = $this->getLAFsetting();
        $LAF = $details_LAF->percent;

        $details_VRF = $this->getVRFsetting();
        $VRF = $details_VRF->percent;


        $details_totalAccumulatedLoan = Disbursement::findBySql("SELECT SUM((disbursed_amount)+('$PNT'*disbursed_amount)+('$LAF'*disbursed_amount)+('$VRF'*disbursed_amount)) AS 'disbursed_amount' "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id INNER JOIN employed_beneficiary ON employed_beneficiary.applicant_id=application.applicant_id "
                        . "WHERE  employed_beneficiary.employer_id='$employerID' AND employed_beneficiary.applicant_id IS NOT NULL AND employed_beneficiary.loan_summary_id IS NULL AND employed_beneficiary.employment_status='ONPOST'")->one();
        $total = $details_totalAccumulatedLoan->disbursed_amount;
        $value = (count($total) == 0) ? '0' : $total;
        return $value;
    }

    public function getloanRepaymentItemID($itemCode) {
        $details_item = LoanRepaymentItem::findBySql("SELECT loan_repayment_item_id FROM loan_repayment_item WHERE  loan_repayment_item.item_code='$itemCode'")->one();
        $details_v = $details_item->loan_repayment_item_id;
        $value = (count($details_v) == 0) ? '0' : $details_v;
        return $value;
    }

    public function getIndividualEmployeesPrincipalLoanPerAccademicYR($applicantID, $academicYearID) {
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM(disbursed_amount) AS disbursed_amount "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id WHERE  application.applicant_id='$applicantID' AND application.academic_year_id='$academicYearID'")->one();
        $principal = $details_disbursedAmount->disbursed_amount;

        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
    }

    public function getIndividualEmployeePaidPrincipalLoan($applicantID) {
        $principleCode = "PRC";
        $PRC_id = EmployedBeneficiary::getloanRepaymentItemID($principleCode);
        $details_paidLoan = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$PRC_id' AND loan_repayment_detail.applicant_id='$applicantID'")->one();
        $paidAmount = $details_paidLoan->amount;

        $value = (count($paidAmount) == 0) ? '0' : $paidAmount;
        return $value;
    }

    public function getIndividualEmployeePaidPrincipalLoanUnderBill($applicantID, $loan_summary_id) {
        $principleCode = "PRC";
        $PRC_id = EmployedBeneficiary::getloanRepaymentItemID($principleCode);
        $details_paidLoan = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$PRC_id' AND loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_summary_id='$loan_summary_id'")->one();
        $paidAmount = $details_paidLoan->amount;

        $value = (count($paidAmount) == 0) ? '0' : $paidAmount;
        return $value;
    }

    public function getIndividualEmployeePaidVRF($applicantID) {
        $principleCode = "VRF";
        $VRF_id = EmployedBeneficiary::getloanRepaymentItemID($principleCode);
        $details_paidVRF = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$VRF_id' AND loan_repayment_detail.applicant_id='$applicantID'")->one();
        $paidAmount = $details_paidVRF->amount;

        $value = (count($paidAmount) == 0) ? '0' : $paidAmount;
        return $value;
    }

    public function getGracePeriodSetting() {
        $details_gracePeriod = SystemSetting::findBySql("SELECT setting_value FROM system_setting WHERE  setting_code='LRGPD' AND is_active='1'")->one();
        $gracePeriod = $details_gracePeriod->setting_value;
        return $gracePeriod;
    }

    public function getEmployedBeneficiaryPaymentSetting() {
        $value = SystemSetting::findBySql("SELECT system_setting.setting_value*0.01 AS 'setting_value' FROM system_setting WHERE  setting_code='EMLRP' AND is_active='1'")->one();
        $value_v = $value->setting_value;
        return $value_v;
    }

    public function getNonEmployedBeneficiaryPaymentSetting() {
        $value = SystemSetting::findBySql("SELECT setting_value FROM system_setting WHERE  setting_code='SEMLRA' AND is_active='1'")->one();
        $value_v = $value->setting_value;
        return $value_v;
    }

    public function getVRFsetting() {
        $details_VRF = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.percent*0.01 AS 'percent',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1'")->one();
        return $details_VRF;
    }

    public function getLAFsetting() {
        $details_LAF = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.percent*0.01 AS 'percent',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF' AND loan_repayment_setting.is_active='1'")->one();
        return $details_LAF;
    }

    public function getPNTsetting() {
        $details_PNT = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.percent*0.01 AS 'percent',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT' AND loan_repayment_setting.is_active='1'")->one();
        return $details_PNT;
    }

    public static function retrieveApplicantDetailsUsingIdentifiers($applcantF4IndexNo, $NIN) {
        $employee_details = Applicant::findOne(['f4indexno' => $applcantF4IndexNo]);
        if ($employee_details) {
            return $employee_details->applicant_id;
        } else {
            $employee_details = Applicant::findOne(['NID' => $NIN]);
            return $employee_details->applicant_id;
        }
    }
	public function getWardID($wardName){
	$wardID=Ward::find()->where(['ward_name'=>$wardName])->one();
	if(count($wardID) >0){
	$wardID=$wardID->ward_id;
	}else{
	$wardID='';
	}
	return $wardID;
	}
	public function getLearningInstitutionID($institution_code){
	$learning_institution_id=LearningInstitution::find()->where(['institution_code'=>$institution_code])->one();
	if(count($learning_institution_id) >0){
	$learning_institution_id=$learning_institution_id->learning_institution_id;
	}else{
	$learning_institution_id='';
	}
	return $learning_institution_id;
	}
	public function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public function updateUser($loggedin,$firstname,$middlename,$surname,$phone_number)
    {
        User::updateAll(['firstname' => $firstname, 'middlename' => $middlename, 'surname' => $surname, 'phone_number' => $phone_number], 'user_id ="' . $loggedin . '"');
    }
	public function updateUserPassword($loggedin,$password_hash,$auth_key)
    {
        User::updateAll(['status'=>'0','password_hash' => $password_hash, 'auth_key' => $auth_key], 'user_id ="' . $loggedin . '"');
    }
	public function updateUserRecoverPassword($loggedin,$password_hash,$auth_key)
    {
        User::updateAll(['status'=>'10','password_hash' => $password_hash, 'auth_key' => $auth_key], 'user_id ="' . $loggedin . '"');
    }
	public static function formatRowData($rowData) {
       $formattedRowData = str_replace(",", "", str_replace("  ", " ", str_replace("'", "", trim($rowData))));
       return $formattedRowData;
   }
   
   public static function getBeneficiaryOutstandingLoan($applicantID){
   $outstandingLoan=EmployedBeneficiary::getIndividualEmployeeTotalLoan($applicantID) - LoanRepaymentDetail::getAmountTotalPaidLoanee($applicantID);
   return $outstandingLoan;
   }
   public function getUnverifiedEmployees($verification_status,$employerID){
        $details_count = $this->findBySql("SELECT COUNT(employed_beneficiary_id) AS 'totalLoanees' FROM employed_beneficiary WHERE  employed_beneficiary.applicant_id IS NOT NULL  AND employed_beneficiary.employment_status='ONPOST' AND employed_beneficiary.verification_status='$verification_status' AND employed_beneficiary.employer_id='$employerID'")->one();
        $totalLoanees=$details_count->totalLoanees;
   
        $value = (count($totalLoanees) == 0) ? '0' : $totalLoanees;
        return $value;
        }
    public function confirmBeneficiaryByEmployer($employerID){
        $this->updateAll(['verification_status' =>'1'], 'verification_status="3" AND employer_id="'.$employerID.'" AND employment_status="ONPOST"');
 }
}
