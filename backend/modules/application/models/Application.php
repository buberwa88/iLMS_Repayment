<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property integer $application_id
 * @property integer $applicant_id
 * @property integer $academic_year_id
 * @property string $bill_number
 * @property string $control_number
 * @property string $receipt_number
 * @property double $amount_paid
 * @property string $pay_phone_number
 * @property string $date_bill_generated
 * @property string $date_control_received
 * @property string $date_receipt_received
 * @property integer $programme_id
 * @property integer $application_study_year
 * @property integer $current_study_year
 * @property integer $applicant_category_id
 * @property string $bank_account_number
 * @property string $bank_account_name
 * @property integer $bank_id
 * @property string $bank_branch_name
 * @property integer $submitted
 * @property integer $verification_status
 * @property double $needness
 * @property integer $allocation_status
 * @property string $allocation_comment
 * @property string $student_status
 * @property string $created_at
 * @property string $passport_photo_comment
 *
 * @property Allocation[] $allocations
 * @property ApplicantAssociate[] $applicantAssociates
 * @property ApplicantAttachment[] $applicantAttachments
 * @property ApplicantCriteriaScore[] $applicantCriteriaScores
 * @property ApplicantProgrammeHistory[] $applicantProgrammeHistories
 * @property ApplicantQuestion[] $applicantQuestions
 * @property AcademicYear $academicYear
 * @property Applicant $applicant
 * @property ApplicantCategory $applicantCategory
 * @property Bank $bank
 * @property Programme $programme
 * @property Disbursement[] $disbursements
 * @property Education[] $educations
 * @property InstitutionPaymentRequestDetail[] $institutionPaymentRequestDetails
 * @property Loan[] $loans
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
   
    public static function tableName()
    {
        return 'application';
    }

    /**
     * @inheritdoc
     */
     
     // public $assignee;
     // public $number_of_applications;

    public $Bachelor;
    public $Masters;
    public $Diploma;
    public $Postgraduate_Diploma;
    public $PhD;
    public $criteraValue;
    public $systemStatus;
    public $totalApplication;
    //for report purpose
    public $exportCategory;
    public $uniqid;
    public $firstname;
    public $middlename;
    public $surname;
    public $regNumber;
    public $completion_year;
    public $pageIdentifyStud;
	public $export_mode;
    //end
    public function rules()
    {
        return [
            [['applicant_id', 'academic_year_id','transfer_status','application_study_year', 'current_study_year', 'applicant_category_id', 'created_at','registration_number','passport_photo_comment','criteraValue'], 'safe'],
            [['applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status'], 'integer'],
            [['amount_paid', 'needness'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'created_at','Bachelor','Masters','Diploma','Postgraduate_Diploma','PhD','assignee','systemStatus','last_verified_by','date_verified','totalApplication','released'], 'safe'],
            [['student_status'], 'string'],
             ['passport_photo', 'image', 'minWidth' => 150, 'maxWidth' => 150,'minHeight' => 160, 'maxHeight' => 160, 'extensions' => 'jpg,jpeg, png'],
            [['bill_number', 'control_number', 'receipt_number', 'bank_account_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['bank_account_name'], 'string', 'max' => 60],
            [['bank_branch_name'], 'string', 'max' => 45],
            [['allocation_comment','passport_photo','passport_photo_comment'], 'string', 'max' => 500],
            //[['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['applicant_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['applicant_category_id' => 'applicant_category_id']],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'bank_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
            [['assignee'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['assignee' => 'user_id']],       

 ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'application_id' => 'Application ID',
            'applicant_id' => 'Applicant ID',
            'academic_year_id' => 'Academic Year ID',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'receipt_number' => 'Receipt Number',
            'amount_paid' => 'Amount Paid',
            'pay_phone_number' => 'Pay Phone Number',
            'date_bill_generated' => 'Date Bill Generated',
            'date_control_received' => 'Date Control Received',
            'date_receipt_received' => 'Date Receipt Received',
            'programme_id' => 'Programme ID',
            'application_study_year' => 'Year of Study',
            'current_study_year' => 'Current Study Year',
            'applicant_category_id' => 'Applicant Category ID',
            'bank_account_number' => 'Bank Account Number',
            'bank_account_name' => 'Bank Account Name',
            'bank_id' => 'Bank ID',
            'bank_branch_name' => 'Bank Branch Name',
            'submitted' => 'Submitted',
            'verification_status' => 'Verification Status',
            'needness' => 'Needness',
            'allocation_status' => 'Allocation Status',
            'allocation_comment' => 'Allocation Comment',
            'student_status' => 'Student Status',
            'created_at' => 'Created At',
            'passport_photo_comment' => 'Comment',
            'assignee' => 'Assignee',
            'number_of_applications' => 'Number of Applications',
            'systemStatus'=>'Syatem Status',
            'last_verified_by'=>'Last Verified By',
            'date_verified'=>'Date Verified',
            'totalApplication'=>'Total Application',
            'released'=>'Released',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocations()
    {
        return $this->hasMany(Allocation::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantAssociates()
    {
        return $this->hasMany(ApplicantAssociate::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantAttachments()
    {
        return $this->hasMany(\frontend\modules\application\models\ApplicantAttachment::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCriteriaScores()
    {
        return $this->hasMany(ApplicantCriteriaScore::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantProgrammeHistories()
    {
        return $this->hasMany(ApplicantProgrammeHistory::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantQuestions()
    {
        return $this->hasMany(ApplicantQuestion::className(), ['application_id' => 'application_id']);
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
        return $this->hasOne(Applicant::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategory()
    {
        return $this->hasOne(ApplicantCategory::className(), ['applicant_category_id' => 'applicant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['bank_id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme()
    {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursements()
    {
        return $this->hasMany(Disbursement::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(\common\models\Education::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequestDetails()
    {
        return $this->hasMany(InstitutionPaymentRequestDetail::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoans()
    {
        return $this->hasMany(Loan::className(), ['application_id' => 'application_id']);
    }
    public function getStudentName()
    {
        return $this->hasMany(Loan::className(), ['application_id' => 'application_id']);
    } 

    public function getAssignee0()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'assignee']);
    }


   public static function getApplicantSex($sex)
    {
      if($sex == 'M'){
          $applicant_sex = 'Male';
         }
       else{
           $applicant_sex = 'Female';
        }
        return $applicant_sex;
    }
      

    public static function getApplicantDisabilityStatus($applicantDisability)
    {
      if($applicantDisability == 'NO'){
         $applicant_disability_status = 'Mwombaji hana ulemavu wowote (Applicant is NOT Disabled)';
        }
        else{
            $applicant_disability_status = 'Mwombaji ni mlemavu (Applicant is Disabled)';
        }
        return $applicant_disability_status;
    } 


     public static function getFatherAliveStatus($father_status)
    {
      if($father_status == 'YES'){
          $father_alive_status = 'Baba yuko hai';
         }
       else{
           $father_alive_status = 'Baba hayuko hai';
        }
        return $father_alive_status;
    } 

    public static function getMotherAliveStatus($mother_status)
    {
      if($mother_status == 'YES'){
          $mother_alive_status = 'Mama yuko hai';
         }
       else{
           $mother_alive_status = 'Mama hayuko hai';
        }
        return $father_alive_status;
    } 

    public static function getParentsDisabilityStatus($motherDisabilityStatus,$fatherDisabilityStatus){
      if($motherDisabilityStatus == 'NO' && $fatherDisabilityStatus == 'NO' ){
          $parents_disability_status = 'Wazazi wa mwombaji hawana ulemavu (Applicant Parents are NOT Disabled)';
        } 
        else{
            $parents_disability_status = 'Wazazi wa mwombaji wana ulemavu (Applicant Parents are Disabled)';
        }
        return $parents_disability_status;
    }

    public static function getApplicationFormTitle($applicant_category_id)
    {
        if($applicant_category_id == 1){
            $title_en = 'LOCAL UNDERGRADUATE STUDENT LOAN APPLICATION FORM';
            $title_sw = '(Fomu ya Maombi ya Mkopo kwa Wanafunzi wa Shahada ya Kwanza Ndani ya Nchi)';
         }
        elseif($applicant_category_id == 2){
            $title_en = 'LOCAL POSTGRADUATE STUDENTS LOAN APPLICATION FORM';
            $title_sw = '[Fomu ya Maombi ya Mkopo kwa Wanafunzi wa Shahada za Uzamili na Uzamivu Ndani ya Nchi]';
         }
        else{
            $title_en = 'DIPLOMA IN SCIENCE EDUCATION STUDENT LOAN APPLICATION FORM';
            $title_sw = '(Maombi ya Mkopo kwa Wanafunzi wa Stashahada ya Ualimu wa Masomo ya Sayansi)';
         }
        return ['title_eng' => $title_en,'title_sw' => $title_sw];
    }
	
	##bill and controll number issue
    public static function saveBillNumber($applicationID,$bill_number,$amount){
        $date_bill_generated=date("Y-m-d H:i:s");	
		Application::updateAll(['bill_number'=>$bill_number,'date_bill_generated'=>$date_bill_generated,'amount_paid'=>$amount], 'application_id ="'.$applicationID.'"');
        }
    public static function getApplicantDetails($applicantID){	
		$results_applicant=\frontend\modules\application\models\Applicant::find()
		          ->where(['applicant_id'=>$applicantID])
		          ->one();
		return	$results_applicant;	  
        }
    public static function getControlNumber($userID){	
		$controlNumberDetails=Application::find()
		          ->joinWith('applicant')
		          ->where(['applicant.user_id'=>$userID])
                          ->orderBy('application.application_id DESC')
		          ->one();
		return $controlNumberDetails;	  
        }
    ##end bill and control number issue	

   public static function getVerificationReport($searches,$verification_status2,$assignee,$offset,$limit){
    set_time_limit(0);         
    $applicationDetails = Application::find()
        ->select(['user.firstname','user.middlename','user.surname','applicant.f4indexno','applicant.sex','application.application_id','applicant.applicant_id','application.applicant_category_id','applicant_category.applicant_category','application.verification_status','application.date_verified','application.assignee','applicant_attachment.application_id'])
        ->joinWith('applicant', ['application.applicant_id'=>'applicant.applicant_id'])
        ->joinWith('applicant.user', ['applicant.user_id'=>'user.user_id'])
        ->joinWith('applicantCategory', ['application.applicant_category_id'=>'applicant_category.applicant_category_id'])
        ->joinWith('applicantAttachments', ['applicantAttachments.application_id'=>'application.application_id'])->groupBy(['applicant_attachment.application_id','application.applicant_id','applicant.user_id','application.application_id'])  
        ->where(['application.verification_status'=>$verification_status2,'application.loan_application_form_status'=>3])    
        ->andWhere($searches.$assignee)
       //->limit('1000')
        ->limit($limit)
        ->offset($offset)    
        ->orderBy(['application.application_id' => SORT_ASC])
        //->asArray()    
        ->all();
		return $applicationDetails;	  
        }

}
