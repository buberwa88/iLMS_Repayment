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
use frontend\modules\application\models\Education;

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
	const SALARY_SOURCE_CENTRAL = 1;
	const SALARY_SOURCE_OWN = 2;    
    const SALARY_SOURCE_BOTH = 3;
	const MINIMUM_AMOUNT_FOR_SELF_BENEFICIARY=500;
	 
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
	public $salary_source_check;


    public function rules() {
        return [
            [['employee_check_number', 'employee_mobile_phone_no', 'basic_salary', 'employee_FIRST_NAME', 'employee_MIDDLE_NAME', 'employee_SURNAME', 'employee_DATE_OF_BIRTH', 'employee_PLACE_OF_BIRTH', 'employee_NAME_OF_INSTITUTION_OF_STUDY'], 'required', 'on' => 'Uploding_employed_beneficiaries'],
            [['support_document','employmentStatus2'], 'required', 'on'=>'deactivate_double_employed'],
            [['support_document'], 'file', 'extensions'=>['pdf']],
			[['firstname', 'middlename','surname','f4indexno','employee_id','phone_number','basic_salary', 'sex', 'learning_institution_id', 'district', 'place_of_birth', 'date_of_birth','region','programme_entry_year','programme_completion_year','programme','programme_level_of_study','salary_source'], 'required', 'on' => 'additionalEmployee'],
			[['firstname', 'middlename','surname','f4indexno','employee_id','phone_number','basic_salary', 'sex', 'learning_institution_id', 'place_of_birth', 'date_of_birth','programme_entry_year','programme_completion_year','programme','programme_level_of_study','salary_source'], 'required', 'on' => 'upload_employees'],
            [['firstname', 'middlename','surname','f4indexno','employee_id','phone_number','basic_salary', 'sex', 'learning_institution_id', 'place_of_birth', 'date_of_birth','programme_entry_year','programme_completion_year','programme','programme_level_of_study','salary_source'], 'required', 'on' => 'upload_employees2'],
			//['salary_source', 'required', 'when' => function ($model) {
    //return $model->salary_source_check == 3;
//}, 'whenClient' => "function (attribute, value) {
    //return $('#salary_source_check').val() == 3;
//}"],
			[['date_of_birth'], 'validateDateOfBirth','skipOnEmpty' => false],
			[['f4indexno', 'employee_f4indexno'], 'validateF4indexnoFormat','skipOnEmpty' => true],
			[['firstname', 'middlename','surname','f4indexno','employee_id','phone_number','basic_salary', 'sex', 'learning_institution_id','district', 'place_of_birth','region', 'date_of_birth','programme_entry_year','programme_completion_year','programme','programme_level_of_study'], 'required', 'on' => 'Uploding_beneficiaries'],
                        //[['programme_entry_year','programme_completion_year'],'compare','operator'=>'<','skipOnEmpty' => false,'message'=>'Error: Entry year can not be grater than completion year'],
                        ['programme_entry_year', 'compare', 'compareAttribute' => 'programme_completion_year', 'operator' => '<', 'enableClientValidation' => false],
			
			[['firstname', 'middlename','surname','f4indexno','employee_id','phone_number','basic_salary', 'sex', 'learning_institution_id', 'district', 'place_of_birth', 'date_of_birth','region'], 'required', 'on' => 'update_employee'],
			[['firstname', 'middlename','surname','employee_id','phone_number','basic_salary', 'sex','employment_status'], 'required', 'on' => 'update_beneficiary'],			
			[['firstname', 'middlename', 'surname'], 'match','not' => true, 'pattern' => '/[^a-zA-Z_-]/','message' => 'Only Characters  Are Allowed...'],			
            [['employer_id', 'applicant_id', 'created_by', 'employee_mobile_phone_no', 'loan_summary_id','programme_entry_year','programme_completion_year'], 'integer'],
            [['f4indexno'],'validateNewEmployee','on'=>'additionalEmployee'],
            ['employee_mobile_phone_no', 'string', 'length' => [10, 12]],
            [['basic_salary','phone_number'], 'number'],
	    ['phone_number', 'string', 'length' => [0, 12]],
            [['employment_status', 'employee_FIRST_NAME', 'employee_MIDDLE_NAME', 'employee_SURNAME', 'employee_DATE_OF_BIRTH', 'employee_PLACE_OF_BIRTH', 'employee_YEAR_OF_COMPLETION_STUDIES', 'employee_ACADEMIC_AWARD', 'employee_NAME_OF_INSTITUTION_OF_STUDY'], 'string'],
            [['employer_id', 'employee_id', 'applicant_id', 'employment_status', 'created_at', 'created_by', 'created_at',
            'employee_current_nameifchanged', 'NID', 'f4indexno', 'phone_number', 'loan_summary_id','principal','penalty','LAF','VRF','totalLoan','paid','outstanding', 'totalLoanees', 'employee_FIRST_NAME', 'employee_MIDDLE_NAME', 'employee_SURNAME', 'employee_DATE_OF_BIRTH', 'employee_PLACE_OF_BIRTH', 'employee_YEAR_OF_COMPLETION_STUDIES', 'employee_ACADEMIC_AWARD', 'employee_NAME_OF_INSTITUTION_OF_STUDY', 'amount', 'verification_status' , 'employerName','district','place_of_birth','learning_institution_id','sex','firstname','middlename','surname','region','firstname1','employmentStatus2','employment_start_date','employment_end_date','upload_status','upload_error','programme_entry_year','programme_completion_year','programme','programme_level_of_study','employee_status','current_name','upload_status','uploaded_learning_institution_code','uploaded_level_of_study','uploaded_programme_studied','uploaded_place_of_birth','uploaded_sex','confirmed','mult_employed','support_document','vote_number','salary_source','salary_source_check','updated_by','updated_at'], 'safe'],
            [['employeesFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,xls', 'on' => 'upload_employees'],
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
			[['place_of_birth'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['place_of_birth' => 'ward_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'employed_beneficiary_id' => 'Employed Beneficiary ID',
            'employer_id' => 'Employer ID',
            'employee_id' => 'Employee ID',
            'applicant_id' => 'Applicant ID',
            'basic_salary' => 'Gross Salary',
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
			'place_of_birth'=>'Place of Birth',
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
			'employment_start_date'=>'Employment Start Date',
			'employment_end_date'=>'Employment End Date',
            'upload_status'=>'Upload Status',
            'upload_error'=>'Upload Error',
            'employeesFile'=>'Upload Employee File',
            'programme_entry_year'=>'Entry Year',
            'programme_completion_year'=>'Completion Year',
            'programme'=>'Programme',
            'programme_level_of_study'=>'Level of Study',
            'employee_status'=>'Employee Status',
            'current_name'=>'Current Name',
            'upload_status'=>'Upload status',
            'uploaded_learning_institution_code'=>'uploaded_learning_institution_code',
            'uploaded_level_of_study'=>'uploaded_level_of_study',
            'uploaded_programme_studied'=>'uploaded_programme_studied',
            'uploaded_place_of_birth'=>'uploaded_place_of_birth',
            'uploaded_sex'=>'uploaded_sex',
            'confirmed'=>'Confirmed',
            'mult_employed'=>'Mult Employed',
            'support_document'=>'Support Document',
			'salary_source'=>'Salary Source',
			
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
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'place_of_birth']);
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
    /*
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
	*/
	
	public static function getApplicantDetails($regNo,$f4CompletionYear,$NIN) {
        if (($regNo != '' && $f4CompletionYear != '') && $NIN != '') {

            $details1 = \frontend\modules\application\models\Applicant::findBySql("SELECT applicant.applicant_id AS applicant_id FROM education INNER JOIN application ON education.application_id=application.application_id INNER JOIN applicant ON applicant.applicant_id=application.applicant_id  WHERE  education.registration_number='$regNo' AND education.completion_year='$f4CompletionYear' AND applicant.NID='$NIN' AND education.level='OLEVEL' ORDER BY applicant_id DESC")->one();            

            $value1 = (count($details1) == 0) ? '0' : '1';
            if ($value1 == 0) {
                $details2 = \frontend\modules\application\models\Applicant::findBySql("SELECT applicant.applicant_id AS applicant_id FROM education INNER JOIN application ON education.application_id=application.application_id INNER JOIN applicant ON applicant.applicant_id=application.applicant_id  WHERE  education.registration_number='$regNo' AND education.completion_year='$f4CompletionYear' AND education.level='OLEVEL' ORDER BY applicant_id DESC")->one();
                
                $value2 = (count($details2) == 0) ? '0' : '1';
                if ($value2 == 0) {
                    $details3 = \frontend\modules\application\models\Applicant::findBySql("SELECT applicant.applicant_id AS applicant_id  FROM applicant  WHERE NID='$NIN' ORDER BY applicant_id DESC")->one();
                    $value3 = (count($details3) == 0) ? '0' : '1';
                    if ($value3 == 1) {
                        $resultsFound = $details3;
                    } else {
                        $resultsFound = $details3;
                    }
                } else {
                    $resultsFound = $details2;
                }
            } else {
                $resultsFound = $details1;
            }
        } else if (($regNo == '' && $f4CompletionYear == '') && $NIN != '') {
            $details_4 = \frontend\modules\application\models\Applicant::find()
                            ->where(['NID' => $NIN])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
            $resultsFound = $details_4;
        } else if (($regNo != '' && $f4CompletionYear != '') && $NIN == '') {
            $details_5 = \frontend\modules\application\models\Applicant::findBySql("SELECT applicant.applicant_id AS applicant_id FROM education INNER JOIN application ON education.application_id=application.application_id INNER JOIN applicant ON applicant.applicant_id=application.applicant_id  WHERE  education.registration_number='$regNo' AND education.completion_year='$f4CompletionYear' AND education.level='OLEVEL' ORDER BY applicant_id DESC")->one();
            $resultsFound = $details_5;
        } else if (($regNo == '' && $f4CompletionYear == '') && $NIN == '') {
            $resultsFound = "";
        }
        return $resultsFound;
    }
	

    public function getApplicantDetailsUsingNonUniqueIdentifiers($firstname, $middlename, $surname, $dateofbirth, $placeofbirth, $academicInstitution,$studyLevel,$programmeStudied,$EntryAcademicYear,$CompletionAcademicYear) {
        $details_applicant = Applicant::findBySql("SELECT * FROM applicant INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN application ON application.applicant_id=applicant.applicant_id INNER JOIN programme ON programme.programme_id=application.programme_id INNER JOIN education ON education.application_id=application.application_id "
                        . "WHERE  user.firstname='$firstname' AND user.middlename='$middlename' AND user.surname='$surname' AND applicant.date_of_birth='$dateofbirth' AND applicant.place_of_birth='$placeofbirth' AND programme.learning_institution_id ='$academicInstitution' AND application.applicant_category_id='$studyLevel' AND application.programme_id ='$programmeStudied' AND application.application_study_year ='$EntryAcademicYear' AND application.current_study_year ='$CompletionAcademicYear' ORDER BY applicant.applicant_id DESC")->one();
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
        /*
        $details_employee_existance = $this->find()
                        ->where(['applicant_id' => $applicantId, 'employer_id' => $employerId, 'employee_id' => $employeeId])
                        ->orderBy('employed_beneficiary_id DESC')
                        ->limit(1)->one();
         * 
         */
        
        
        if (EmployedBeneficiary::find()
                        ->where(['applicant_id' => $applicantId, 'employer_id' => $employerId, 'employee_id' => $employeeId])->exists()) {
            return 1;
        }else{
            return 0;
        }
    }
    public static function getEmployeeExists($applicantId, $employerId, $employeeId) {
        $details_employee_existance = EmployedBeneficiary::find()
                        ->where(['applicant_id' => $applicantId, 'employer_id' => $employerId, 'employee_id' => $employeeId])->one();                        
        return $details_employee_existance;
       
    }

    public function checkEmployeeExistsNonApplicant($f4indexno, $employerId, $employeeId) {
        /*
        $employee_existance_nonApplicant = $this->find()
                        ->where(['f4indexno' => $f4indexno, 'employer_id' => $employerId, 'employee_id' => $employeeId])
                        ->orderBy('employed_beneficiary_id DESC')
                        ->limit(1)->one();
        return $employee_existance_nonApplicant;
         * 
         */
        
        if (EmployedBeneficiary::find()
                        ->where(['f4indexno' => $f4indexno, 'employer_id' => $employerId, 'employee_id' => $employeeId])->exists()) {
            return 1;
        }else{
            return 0;
        }
        
        
    }
    public static function getEmployeeExistsNonApplicantID($f4indexno, $employerId, $employeeId) {
        $employee_existance_nonApplicant = EmployedBeneficiary::find()
                        ->where(['f4indexno' => $f4indexno, 'employer_id' => $employerId, 'employee_id' => $employeeId])->one();
        return $employee_existance_nonApplicant;
    }

    public function updateBeneficiaryNonApplicant($checkIsmoney, $results_nonApplicantFound, $f4indexno, $firstname, $phone_number, $NID) {
        $this->updateAll(['basic_salary' => $checkIsmoney, 'f4indexno' => $f4indexno, 'firstname' => $firstname, 'phone_number' => $phone_number, 'NID' => $NID], 'employed_beneficiary_id ="' . $results_nonApplicantFound . '"');
    }

    public static function getIndividualEmployeesPrincipalLoan($applicantID) {
		$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicantID);
        $details_disbursedAmount = Disbursement::findBySql("SELECT SUM(disbursed_amount) AS disbursed_amount "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id INNER JOIN disbursement_batch ON disbursement_batch.disbursement_batch_id=disbursement.disbursement_batch_id WHERE  disbursement.application_id IN($allApplications) AND application.student_status<>'ONSTUDY' AND disbursement.status='8' AND disbursement_batch.disbursement_batch_id=disbursement.disbursement_batch_id AND  disbursement_batch.is_approved='1'")->one();
        $principal = $details_disbursedAmount->disbursed_amount;

        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
    }

    public static function getIndividualEmployeesPrincipalLoanUnderBill($applicantID, $loan_summary_id,$loan_given_to) {
        $itemCodePrincipal = "PRC";
        $principal_id = EmployedBeneficiary::getloanRepaymentItemID($itemCodePrincipal);
        $details_amount = LoanSummaryDetail::findBySql("SELECT SUM(amount) AS amount "
                        . "FROM loan_summary_detail WHERE  applicant_id='$applicantID' AND loan_repayment_item_id='$principal_id' AND loan_summary_id='$loan_summary_id' AND loan_given_to='$loan_given_to'")->one();
        $principal = $details_amount->amount;

        $value2 = (count($principal) == 0) ? '0' : $principal;
        return $value2;
    }

    public function getOutstandingPrincipalLoan($applicantID) {
        $OutstandingAmount = EmployedBeneficiary::getIndividualEmployeesPrincipalLoan($applicantID) - EmployedBeneficiary::getIndividualEmployeePaidPrincipalLoan($applicantID);
        //$OutstandingAmount=$this->getIndividualEmployeesPrincipalLoan($applicantID);
        $value = (count($OutstandingAmount) == 0) ? '0' : $OutstandingAmount;
        return $value;
    }

    public static function getOutstandingPrincipalLoanUnderBill($applicantID, $loan_summary_id,$loan_given_to) {
        $OutstandingAmount = EmployedBeneficiary::getIndividualEmployeesPrincipalLoanUnderBill($applicantID, $loan_summary_id,$loan_given_to) - EmployedBeneficiary::getIndividualEmployeePaidPrincipalLoanUnderBill($applicantID, $loan_summary_id,$loan_given_to);
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
        $PNT = $details_pnt->rate;
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
        $value_academicY = EmployedBeneficiary::getstartToEndAcademicYrOfBeneficiary($applicantID, $filter);
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

    public function getIndividualEmployeesPenaltyUnderBill($applicantID, $loan_summary_id,$loan_given_to) {
        $itemCodePNT = "PNT";
        $PNT_id = EmployedBeneficiary::getloanRepaymentItemID($itemCodePNT);

        $detailsAmountChargesPNT_3_1 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1 FROM loan_summary_detail A "
                        . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='" . $PNT_id . "' AND A.loan_given_to='$loan_given_to'")->one();
        $detailsAmountChargesPNT_paid_1 = LoanRepaymentDetail::findBySql("select b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='" . $PNT_id . "' AND D.payment_status='1' AND b.loan_given_to='$loan_given_to' group by b.loan_summary_id")->one();

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
        $PNT = $details_pnt->rate;
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
        $LAF = $details_LAF->rate;
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

    public function getIndividualEmployeesLAFUnderBill($applicantID, $loan_summary_id,$loan_given_to) {
        $itemCodeLAF = "LAF";
        $LAF_id = EmployedBeneficiary::getloanRepaymentItemID($itemCodeLAF);
        $detailsAmountChargesLAF_3_1 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1 FROM loan_summary_detail A "
                        . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='" . $LAF_id . "' AND A.loan_given_to='$loan_given_to'")->one();
        $detailsAmountChargesLAF_paid_1 = LoanRepaymentDetail::findBySql("select b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='" . $LAF_id . "' AND D.payment_status='1' AND b.loan_given_to='$loan_given_to' group by b.loan_summary_id")->one();

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
        $LAF = $details_LAF->rate;
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
        $VRF = $details_VRF->rate;
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

    public function getIndividualEmployeesVRFUnderBill($applicantID, $loan_summary_id,$loan_given_to) {
        $itemCodeVRF = "VRF";
        $vrf_id = EmployedBeneficiary::getloanRepaymentItemID($itemCodeVRF);
        $detailsAmountChargesVRF_3_1 = LoanSummaryDetail::findBySql("SELECT SUM(A.amount) AS amount1 FROM loan_summary_detail A "
                        . "WHERE  A.applicant_id='$applicantID' AND A.loan_summary_id='$loan_summary_id' AND A.loan_repayment_item_id='" . $vrf_id . "' AND A.loan_given_to='$loan_given_to'")->one();
        $detailsAmountChargesVRF_paid_1 = LoanRepaymentDetail::findBySql("select b.loan_summary_id, sum(b.amount) as amount from loan_repayment_detail b INNER JOIN loan_repayment D ON D.loan_repayment_id=b.loan_repayment_id "
                        . "WHERE b.applicant_id='$applicantID' AND b.loan_summary_id='$loan_summary_id' AND b.loan_repayment_item_id='" . $vrf_id . "' AND D.payment_status='1' AND b.loan_given_to='$loan_given_to' group by b.loan_summary_id")->one();


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
        $VRF = $details_VRF->rate;

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

    public function getIndividualEmployeeTotalLoanUnderBill($applicantID, $loan_summary_id,$loan_given_to) {
        $totalLoan = EmployedBeneficiary::getOutstandingPrincipalLoanUnderBill($applicantID, $loan_summary_id,$loan_given_to) + EmployedBeneficiary::getIndividualEmployeesPenaltyUnderBill($applicantID, $loan_summary_id,$loan_given_to) + EmployedBeneficiary::getIndividualEmployeesLAFUnderBill($applicantID, $loan_summary_id,$loan_given_to) + EmployedBeneficiary::getIndividualEmployeesVRFUnderBill($applicantID, $loan_summary_id,$loan_given_to);

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
        $PNT = $details_pnt->rate;

        $details_LAF = $this->getLAFsetting();
        $LAF = $details_LAF->rate;

        $details_VRF = $this->getVRFsetting();
        $VRF = $details_VRF->rate;


        $details_totalAccumulatedLoan = Disbursement::findBySql("SELECT SUM((disbursed_amount)+('$PNT'*disbursed_amount)+('$LAF'*disbursed_amount)+('$VRF'*disbursed_amount)) AS 'disbursed_amount' "
                        . "FROM disbursement INNER JOIN application ON application.application_id=disbursement.application_id INNER JOIN employed_beneficiary ON employed_beneficiary.applicant_id=application.applicant_id "
                        . "WHERE  employed_beneficiary.employer_id='$employerID' AND employed_beneficiary.applicant_id IS NOT NULL AND employed_beneficiary.loan_summary_id IS NULL AND employed_beneficiary.employment_status='ONPOST'")->one();
        $total = $details_totalAccumulatedLoan->disbursed_amount;
        $value = (count($total) == 0) ? '0' : $total;
        return $value;
    }

    public static function getloanRepaymentItemID($itemCode) {
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

    public static function getIndividualEmployeePaidPrincipalLoanUnderBill($applicantID, $loan_summary_id,$loan_given_to) {
        $principleCode = "PRC";
        $PRC_id = EmployedBeneficiary::getloanRepaymentItemID($principleCode);
        $details_paidLoan = LoanRepaymentDetail::findBySql("SELECT SUM(loan_repayment_detail.amount) AS amount "
                        . "FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id "
                        . "WHERE  loan_repayment.payment_status='1' AND loan_repayment_detail.loan_repayment_item_id='$PRC_id' AND loan_repayment_detail.applicant_id='$applicantID' AND loan_repayment_detail.loan_summary_id='$loan_summary_id' AND loan_repayment_detail.loan_given_to='$loan_given_to'")->one();
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
        $details_VRF = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='2'")->one();
        return $details_VRF;
    }

    public function getLAFsetting() {
        $details_LAF = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='LAF' AND loan_repayment_setting.is_active='1'")->one();
        return $details_LAF;
    }

    public function getPNTsetting() {
        $details_PNT = LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id' FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='PNT' AND loan_repayment_setting.is_active='1'")->one();
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
        $details_count = $this->findBySql("SELECT COUNT(employed_beneficiary_id) AS 'totalLoanees' FROM employed_beneficiary WHERE  employed_beneficiary.applicant_id IS NOT NULL  AND employed_beneficiary.employment_status='ONPOST' AND employed_beneficiary.verification_status='$verification_status' AND employed_beneficiary.employer_id='$employerID' AND employed_beneficiary.loan_confirmed='0'")->one();
        $totalLoanees=$details_count->totalLoanees;
   
        $value = (count($totalLoanees) == 0) ? '0' : $totalLoanees;
        return $value;
        }
    public function confirmBeneficiaryByEmployer($employerID,$employed_beneficiary_id){
        $this->updateAll(['loan_confirmed' =>'1'], 'verification_status="1" AND employer_id="'.$employerID.'" AND employment_status="ONPOST" AND employed_beneficiary_id="'.$employed_beneficiary_id.'" AND employed_beneficiary.loan_confirmed="0"');
 }
    public function validateDateOfBirth($attribute, $params){
    // Maximum date today - 18 years
     $maxBirthday = new \DateTime();
     $maxBirthday->sub(new \DateInterval('P18Y'));
    if($this->date_of_birth > $maxBirthday->format('Y-m-d')){
        $this->addError($attribute,'Please give correct Date of Birth');
    }
  }
    public function validateF4indexnoFormat($attribute, $params)
{
    $f4indexno=str_replace(".","",str_replace("S","",str_replace("P","",$this->f4indexno)));	
	 if (!preg_match('/^[0-9]*$/', $f4indexno)) {
    $this->addError($attribute, 'Incorrect Form IV index Number');
    } 
	if(strlen($f4indexno) !=12){
	$this->addError($attribute, 'Incorrect Form IV index Number');
	}
}
    public static function getEntryYear($entryYear){
        $query = "SELECT academic_year_id FROM `academic_year` where `academic_year` LIKE '$entryYear%'";
                 $result = AcademicYear::findBySql($query)->one();
        return $result->academic_year_id;
    }
    public static function getCompletionYear($completionYear){
        $query = "SELECT academic_year_id FROM `academic_year` where `academic_year` LIKE '%$completionYear'";
                 $result = AcademicYear::findBySql($query)->one();
        return $result->academic_year_id;
    }
    public static function getEmployeeOnStudyStatus($applicantID){
       $query = "SELECT application_id FROM `application` where `student_status`='ONSTUDY' AND applicant_id='$applicantID'";
                 $result = Application::findBySql($query)->one();
        return $result->application_id; 
    }
    public static function updateEmployeeReuploaded($employer_id,$employee_id,$applicant_id,$basic_salary,$employment_status,$NID,$f4indexno,$firstname,$middlename,$surname,$sex,$date_of_birth,$place_of_birth,$learning_institution_id,$phone_number,$upload_status,$upload_error,$programme_entry_year,$programme_completion_year,$programme,$programme_level_of_study,$employee_status,$current_name,$uploaded_learning_institution_code,$uploaded_level_of_study,$uploaded_programme_studied,$uploaded_place_of_birth,$uploaded_sex,$verification_status,$employeeExistsId,$salary_source) {
        EmployedBeneficiary::updateAll(['employer_id' => $employer_id,'employee_id'=>$employee_id,'applicant_id'=>$applicant_id,'basic_salary'=>$basic_salary,'employment_status'=>$employment_status,'NID'=>$NID,'f4indexno'=>$f4indexno,'firstname'=>$firstname,'middlename'=>$middlename,'surname'=>$surname,'sex'=>$sex,'date_of_birth'=>$date_of_birth,'place_of_birth'=>$place_of_birth,'learning_institution_id'=>$learning_institution_id,'phone_number'=>$phone_number,'upload_status'=>$upload_status,'upload_error'=>$upload_error,'programme_entry_year'=>$programme_entry_year,'programme_completion_year'=>$programme_completion_year,'programme'=>$programme,'programme_level_of_study'=>$programme_level_of_study,'employee_status'=>$employee_status,'current_name'=>$current_name,'uploaded_learning_institution_code'=>$uploaded_learning_institution_code,'uploaded_level_of_study'=>$uploaded_level_of_study,'uploaded_programme_studied'=>$uploaded_programme_studied,'uploaded_place_of_birth'=>$uploaded_place_of_birth,'uploaded_sex'=>$uploaded_sex,'verification_status'=>$verification_status,'salary_source'=>$salary_source], 'employed_beneficiary_id ="' . $employeeExistsId . '"');
    }
    
    public static function getEmployeesFailed($employerID,$uploadStatus,$offset,$limit){
    $employeeDetails = EmployedBeneficiary::find()   
        ->where(['employer_id'=>$employerID,'upload_status'=>$uploadStatus])  
        ->limit($limit)
        ->offset($offset)    
        ->orderBy(['employed_beneficiary_id' => SORT_ASC])
        //->asArray()    
        ->all();
		return $employeeDetails;	  
        }
    public function validateNewEmployee($attribute) {
        if ($attribute && $this->f4indexno && $this->employment_status && $this->employer_id) {
            if (self::find()->where('f4indexno=:f4indexno AND employment_status=:employment_status AND employer_id=:employer_id', [':f4indexno' => $this->f4indexno,'employment_status'=>'ONPOST','employer_id'=>$this->employer_id])
                            ->exists()) {
                $this->addError($attribute,'Employee Exists');
                return FALSE;
            }
        }
        return true;
    }
  public static function checkDoubleEmployed($applicantID,$employerID){     
    $details_employeed_beneficiary = self::find()
                            ->where(['applicant_id'=>$applicantID,'employment_status'=>'ONPOST','confirmed'=>1])
                            ->andWhere(['not',
                                ['employer_id'=>$employerID]
                            ])
                            ->limit(1)->one();
    if($details_employeed_beneficiary->employed_beneficiary_id > 0){
                return 1;
            }else{
               return 0; 
            } 
  }
static function getSalarySource() {
        return [
		    self::SALARY_SOURCE_CENTRAL => 'central government',
            self::SALARY_SOURCE_OWN => 'own source',
            self::SALARY_SOURCE_BOTH => 'both',
        ];
    }
public static function getBeneficiariesForPaymentProcess($loan_summary_id){
	return self::findBySql("SELECT * FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST' AND verification_status='1'")->all();
}
public static function getBeneficiariesForPaymentProcessSalarySourceBases($loan_summary_id){
	return self::findBySql("SELECT * FROM employed_beneficiary WHERE  employed_beneficiary.loan_summary_id='$loan_summary_id' AND employment_status='ONPOST' AND verification_status='1' AND salary_source IN(2,3)")->all();
}	
}
