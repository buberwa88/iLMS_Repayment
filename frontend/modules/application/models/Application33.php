<?php

namespace frontend\modules\application\models;

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
    
    public $page_number_two;
    public $page_number_five;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_id', 'academic_year_id', 'application_study_year', 'current_study_year','loanee_category','applicant_category_id', 'created_at'], 'safe'],
            [['applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status'], 'integer'],
            [['amount_paid', 'needness'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'created_at','loanee_category'], 'safe'],
            [['student_status'], 'string'],
            [['bill_number', 'control_number', 'receipt_number', 'bank_account_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['bank_account_name'], 'string', 'max' => 60],
            [['bank_branch_name'], 'string', 'max' => 45],
             [['allocation_comment','passport_photo','passport_photo_comment','application_form_number'], 'string', 'max' => 500],
            [['page_number_two','page_number_five'], 'file', 'extensions'=>['pdf']],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['applicant_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['applicant_category_id' => 'applicant_category_id']],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Bank::className(), 'targetAttribute' => ['bank_id' => 'bank_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
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
            'application_study_year' => 'Application Study Year',
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
            'page_number_two' => 'Attach Page Number Two',
            'page_number_five' => 'Attach Page Number Five',
             'application_form_number' => 'Application Form #',
            'loan_application_form_status' => 'Loan Application Forms Status'
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
        return $this->hasMany(ApplicantAttachment::className(), ['application_id' => 'application_id']);
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
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
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
        return $this->hasOne(\backend\modules\application\models\Bank::className(), ['bank_id' => 'bank_id']);
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
        return $this->hasOne(Education::className(), ['application_id' => 'application_id']);
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
  
    public static function getApplicantSex($sex)
    {
      $sex = '';
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
      $applicant_disability_status = '';
      if($applicantDisability == 'NO'){
         $applicant_disability_status = 'Mwombaji hana ulemavu wowote (Applicant is NOT Disabled)';
        }
        elseif($applicantDisability == 'YES'){
            $applicant_disability_status = 'Mwombaji ni mlemavu (Applicant is Disabled)';
        }
        return $applicant_disability_status;
    } 


     public static function getFatherAliveStatus($father_status)
    {
      $father_alive_status = '';
      if($father_status == 'YES'){
          $father_alive_status = 'Baba yuko hai';
         }
       elseif($father_status == 'NO'){
           $father_alive_status = 'Baba hayuko hai';
        }
        return $father_alive_status;
    } 

    public static function getMotherAliveStatus($mother_status)
    {
        $mother_alive_status = '';
      if($mother_status == 'YES'){
          $mother_alive_status = 'Mama yuko hai';
         }
       elseif($mother_status == 'NO'){
           $mother_alive_status = 'Mama hayuko hai';
        }
        return $mother_alive_status;
    } 

    public static function getParentsDisabilityStatus($motherDisabilityStatus,$fatherDisabilityStatus){
       $parents_disability_status = '';
      if($motherDisabilityStatus == 'NO' && $fatherDisabilityStatus == 'NO' ){
          $parents_disability_status = 'Wazazi wa mwombaji hawana ulemavu (Applicant Parents are NOT Disabled)';
        } 
        elseif($motherDisabilityStatus == 'YES' || $fatherDisabilityStatus == 'YES'){
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
        elseif($applicant_category_id == 3){
            $title_en = 'DIPLOMA IN SCIENCE EDUCATION STUDENT LOAN APPLICATION FORM';
            $title_sw = '(Maombi ya Mkopo kwa Wanafunzi wa Stashahada ya Ualimu wa Masomo ya Sayansi)';
         }
         else{
            $title_en = '';
            $title_sw = '';
         }
        return ['title_eng' => $title_en,'title_sw' => $title_sw];
    }

    public function generateFormNumber($application_id,$applicant_category)
    {
        $form_number = $application_id.$applicant_category.date('Y');
        return $form_number;
    }

}
