<?php

namespace frontend\modules\application\models;

use Yii;
use backend\modules\allocation\models\Allocation;
use backend\modules\disbursement\models\Disbursement;

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
	public $programme_name;
    public $institution_code;
    public $f4indexno;
    public $sex;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['loanee_category','applicant_category_id'], 'required'],
            [['applicant_id', 'academic_year_id', 'application_study_year', 'current_study_year',' 	resubmit','loanee_category','applicant_category_id', 'created_at','admission_letter','employer_letter'], 'safe'],
            [['admission_letter','employer_letter'], 'required', 'when' => function ($model) {
                    return ($model->applicant_category_id ==2||$model->applicant_category_id ==5);
                },
                'whenClient' => "function (attribute, value) { 
                
                     if($('#application-applicant_category_id').val() == 2||$('#application-applicant_category_id').val() == 5) {
                       if($('#application-employer_letter').val() == ''||$('#application-admission_letter').val() == '') {
                        return 0;
                     } else {
                        return 1;
                     }
                     }
                     else{
                       return 0;  
                       }
                      }"],
            [['applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status'], 'integer'],
            [['amount_paid', 'needness'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'created_at','loanee_category'], 'safe'],
            [['student_status'], 'string'],
            [['bill_number', 'control_number', 'receipt_number', 'bank_account_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['bank_account_name'], 'string', 'max' => 60],
            [['bank_branch_name'], 'string', 'max' => 45],
            [['allocation_comment','passport_photo','passport_photo_comment','application_form_number'], 'string', 'max' => 500],
            [['page_number_two','page_number_five','admission_letter','employer_letter'], 'file', 'extensions'=>['pdf']],
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
            'academic_year_id' => 'Academic Year ',
            'bill_number' => 'Bill Number',
            'control_number' => 'Control Number',
            'receipt_number' => 'Receipt Number',
            'amount_paid' => 'Amount Paid',
            'pay_phone_number' => 'Pay Phone Number',
            'date_bill_generated' => 'Date Bill Generated',
            'date_control_received' => 'Date Control Received',
            'date_receipt_received' => 'Date Receipt Received',
            'programme_id' => 'Programme ',
            'application_study_year' => 'Application Study Year',
            'current_study_year' => 'Current Study Year',
            'applicant_category_id' => 'Study Level ',
            'loanee_category' => 'Applicant Category ',
            'bank_account_number' => 'Bank Account Number',
            'bank_account_name' => 'Bank Account Name',
            'bank_id' => 'Bank ',
            'bank_branch_name' => 'Bank Branch Name',
            'submitted' => 'Submitted',
            'verification_status' => 'Verification Status',
            'needness' => 'Needness',
            'allocation_status' => 'Allocation Status',
            'allocation_comment' => 'Allocation Comment',
            'student_status' => 'Student Status',
            
            'admission_letter' => 'Admission Letter',
            'employer_letter' => 'Employer Introduction Letter',
            
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
     // $sex = '';
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
        elseif($motherDisabilityStatus == 'YES' && $fatherDisabilityStatus == 'YES'){
            $parents_disability_status = 'Wazazi wa mwombaji wana ulemavu (Applicant Parents are Disabled)';
        }
       elseif($motherDisabilityStatus == 'YES' && $fatherDisabilityStatus == 'NO'){
             $parents_disability_status = 'Mama wa mwombaji ni mlemavu (Applicant Mother is Disabled)';
           }
       elseif($motherDisabilityStatus == 'NO' && $fatherDisabilityStatus == 'YES'){
             $parents_disability_status = 'Baba wa mwombaji ni mlemavu (Applicant Fathe is Disabled)';
           }
        return $parents_disability_status;
    }

    public static function getApplicationFormTitle($applicant_category_id)
    {
        if($applicant_category_id == 1){
            $title_en = 'LOCAL UNDERGRADUATE STUDENT LOAN APPLICATION FORM';
            $title_sw = '(Fomu ya Maombi ya Mkopo kwa Wanafunzi wa Shahada ya Kwanza Ndani ya Nchi)';
         }
        elseif($applicant_category_id == 2||$applicant_category_id == 5){
            $title_en = 'LOCAL POSTGRADUATE STUDENTS LOAN APPLICATION FORM';
            $title_sw = '[Fomu ya Maombi ya Mkopo kwa Wanafunzi wa Shahada za Uzamili na Uzamivu Ndani ya Nchi]';
         }
         elseif($applicant_category_id == 4){
            $title_en = ' POSTGRADUATE DIPLOMA IN LEGAL PRACTICES LOAN APPLICATION FORM';
            $title_sw = '[Fomu ya Maombi ya Mkopo kwa Wanafunzi wa Stashahada ya Sheria - Law School of Tanzania ]';
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
        $form_number = $application_id.strtotime(date('Y-m-d H:i:s')).$applicant_category.date('Y');
        return $form_number;
    }
   public function SaveAttachment($application_id,$attachment_id,$attachment_name)
    {
   Yii::$app->db->createCommand("DELETE FROM `applicant_attachment` WHERE `application_id`='{$application_id}', `attachment_definition_id`='{$attachment_id}'")->execute();
      
        $model= New ApplicantAttachment();
            $model->application_id=$application_id;
            $model->attachment_definition_id=$attachment_id;
            $model->attachment_path=$attachment_name;
        $model->save();
        return $model;
    }
    /*
    static function getLoanItemsAllocated($id,$academicYearID){
          return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\Allocation::find()->where('application_id=:application_id AND academic_year_id=:academic_year_id AND is_canceled=:is_canceled',[':application_id' => $id,':academic_year_id'=>$academicYearID,':is_canceled'=>0]),
        ]);
    }
     * 
     */
    static function getLoanItemsAllocated($id,$academicYearID){
        
        $resultsDisb=\backend\modules\allocation\models\Allocation::findBySql("SELECT GROUP_CONCAT(DISTINCT allocation.allocation_batch_id) as allocation_batch_id FROM allocation INNER JOIN allocation_batch ON allocation.allocation_batch_id=allocation_batch.allocation_batch_id WHERE  allocation_batch.academic_year_id='$academicYearID' AND allocation_batch.is_approved='1' AND allocation_batch.is_canceled='0' AND allocation.is_canceled='0' AND allocation.application_id='$id'")->asArray()->one();
        $valuesXcF=$resultsDisb['allocation_batch_id'];
		if($valuesXcF !=''){
			$valuesXcF=$valuesXcF;
		}else{
			$valuesXcF=-1;
		}
                
          return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\Allocation::find()->where("allocation_batch_id IN($valuesXcF) AND application_id='$id' AND is_canceled='0'"),
        ]);
    }
    public static function getTotalLoanAllocatedPerAcademicYear($id,$academicYearID){
        $resultsDisb=\backend\modules\allocation\models\Allocation::findBySql("SELECT GROUP_CONCAT(DISTINCT allocation.allocation_batch_id) as allocation_batch_id FROM allocation INNER JOIN allocation_batch ON allocation.allocation_batch_id=allocation_batch.allocation_batch_id WHERE  allocation_batch.academic_year_id='$academicYearID' AND allocation_batch.is_approved='1' AND allocation_batch.is_canceled='0' AND allocation.is_canceled='0' AND allocation.application_id='$id'")->asArray()->one();
        $valuesXcF=$resultsDisb['allocation_batch_id'];   
        if($valuesXcF !=''){
			$valuesXcF=$valuesXcF;
		}else{
			$valuesXcF=-1;
		}		

$query = (new \yii\db\Query())->from('allocation')->where("allocation_batch_id IN($valuesXcF) AND application_id='$id' AND is_canceled='0'");
$sum = $query->sum('allocated_amount');
return $sum;
    }
    /*
     * To get Total Disbursed Loan Per Academic Year Per Semister Per Installment
     */
    public static function getTotalDisbursedLoan($application_id,$academic_year_id,$semester_number,$instalment_definition_id){
    $resultsDisb=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT GROUP_CONCAT(DISTINCT disbursement.disbursement_batch_id) as disbursement_batch_id FROM disbursement INNER JOIN disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id WHERE  disbursement_batch.academic_year_id='$academic_year_id' AND disbursement_batch.semester_number='$semester_number' AND disbursement_batch.instalment_definition_id='$instalment_definition_id' AND disbursement_batch.is_approved='1' AND disbursement.application_id='$application_id' AND disbursement.status='8'")->asArray()->one();
        $valuesXcF=$resultsDisb['disbursement_batch_id'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	
		}else{
			$valuesXcF=-1;
		}
        
      $query = (new \yii\db\Query())->from('disbursement')->where("disbursement_batch_id IN($valuesXcF) AND application_id='$application_id' AND status='8'");
$sum = $query->sum('disbursed_amount');
return $sum;
//return $valuesXcF;
}
    static function getLoanItemsDisbursed($application_id,$academic_year_id,$semester_number,$instalment_definition_id){
    $resultsDisb=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT GROUP_CONCAT(DISTINCT disbursement.disbursement_batch_id) as disbursement_batch_id FROM disbursement INNER JOIN disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id WHERE  disbursement_batch.academic_year_id='$academic_year_id' AND disbursement_batch.semester_number='$semester_number' AND disbursement_batch.instalment_definition_id='$instalment_definition_id' AND disbursement_batch.is_approved='1' AND disbursement.application_id='$application_id' AND disbursement.status='8'")->asArray()->one();
        $valuesXcF=$resultsDisb['disbursement_batch_id'];
		if($valuesXcF !=''){
			$valuesXcF=$valuesXcF;
		}else{
			$valuesXcF=-1;
		}
        
          return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\disbursement\models\disbursement::find()->where("disbursement_batch_id IN($valuesXcF) AND application_id='$application_id' AND status='8'"),
        ]);
    }
    public static function checkLoanAllocated($applicantID){ 
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$applicantID}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	
		}else{
			$valuesXcF=-1;
		}
        
$query = (new \yii\db\Query())->from('allocation')->where("application_id IN($valuesXcF) AND  is_canceled='0'");
$sum = $query->sum('allocated_amount');

return $sum;
    }
    public static function checkDisbursedLoan($applicantID){ 
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$applicantID}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
			$valuesXcF=$valuesXcF;
		}else{
			$valuesXcF=-1;
		}
        
$query = (new \yii\db\Query())->from('disbursement')->where("application_id IN($valuesXcF) AND status='3'");
$sum = $query->sum('disbursed_amount');
return $sum;
    }
    public static function checkExistAllocation($applicantID){ 
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$applicantID}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;		
		}else{
			$valuesXcF=-1;
		}

if (Allocation::find()->where("application_id IN($valuesXcF) AND  is_canceled='0'")->exists()) {
            return 1;
        }

return 0;
    }
    public static function checkExistDisbursment($applicantID){ 
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$applicantID}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
			$valuesXcF=$valuesXcF;
		}else{
			$valuesXcF=-1;
		}

if (Disbursement::find()->where("application_id IN($valuesXcF) AND status='3'")->exists()) {
            return 1;
        }

return 0;
    }
    public static function dropdownq() {
        $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$modelApplicant->applicant_id}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
        /*
    $models = \common\models\AcademicYear::findBySql("SELECT academic_year.academic_year_id AS 'academic_year_id',academic_year.academic_year AS 'academic_year' FROM academic_year INNER JOIN allocation ON allocation.academic_year_id=academic_year.academic_year_id WHERE allocation.application_id IN($valuesXcF) AND  allocation.is_canceled='0'")->all();
         * 
         */
		 if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	 
		 }else{
		$valuesXcF=-1;
		 }
		 
    
    $models = \common\models\AcademicYear::findBySql("SELECT academic_year.academic_year_id AS 'academic_year_id',academic_year.academic_year AS 'academic_year' FROM academic_year INNER JOIN allocation_batch ON allocation_batch.academic_year_id=academic_year.academic_year_id INNER JOIN allocation ON allocation.allocation_batch_id=allocation_batch.allocation_batch_id WHERE allocation.application_id IN($valuesXcF) AND  allocation.is_canceled='0' AND allocation_batch.is_approved='1' AND allocation_batch.is_canceled='0'")->all();
    
    foreach ($models as $model) {
        $dropdown[$model->academic_year_id] = $model->academic_year;
    }
    return $dropdown;
}
public static function dropdownDisb() {
        $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$modelApplicant->applicant_id}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	
		}else{
		$valuesXcF=-1;	
		}
    $models = \common\models\AcademicYear::findBySql("SELECT academic_year.academic_year_id AS 'academic_year_id',academic_year.academic_year AS 'academic_year' FROM academic_year INNER JOIN disbursement_batch ON disbursement_batch.academic_year_id=academic_year.academic_year_id INNER JOIN disbursement ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id WHERE disbursement.application_id IN($valuesXcF) AND  disbursement.status='8'")->all();
    foreach ($models as $model) {
        $dropdown[$model->academic_year_id] = $model->academic_year;
    }
    return $dropdown;
}
public static function dropdownDisbSermister() {
        $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$modelApplicant->applicant_id}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	
		}else{
			$valuesXcF=-1;
		}
    $models = \common\models\Semester::findBySql("SELECT semester.semester_id AS 'semester_id',semester.description AS 'description' FROM semester INNER JOIN disbursement_batch ON disbursement_batch.semester_number=semester.semester_id INNER JOIN disbursement ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id WHERE disbursement.application_id IN($valuesXcF) AND  disbursement.status='8'")->all();
    foreach ($models as $model) {
        $dropdown[$model->semester_id] = $model->description;
    }
    return $dropdown;
}
public static function dropdownDisbInstalment() {
        $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $resultsAllocation=Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$modelApplicant->applicant_id}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
			$valuesXcF=$valuesXcF;
		}else{
			$valuesXcF=-1;
		}
    $models = \backend\modules\disbursement\models\InstalmentDefinition::findBySql("SELECT instalment_definition.instalment_definition_id AS 'instalment_definition_id',instalment_definition.instalment_desc AS 'instalment_desc' FROM instalment_definition INNER JOIN disbursement_batch ON disbursement_batch.instalment_definition_id=instalment_definition.instalment_definition_id INNER JOIN disbursement ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id WHERE disbursement.application_id IN($valuesXcF) AND  disbursement.status='8'")->all();
    foreach ($models as $model) {
        $dropdown[$model->instalment_definition_id] = $model->instalment_desc;
    }
    return $dropdown;
}
public static function dropdownApp() {
        $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
    $models = \common\models\AcademicYear::findBySql("SELECT academic_year.academic_year_id AS 'academic_year_id',academic_year.academic_year AS 'academic_year' FROM academic_year INNER JOIN application ON application.academic_year_id=academic_year.academic_year_id WHERE application.applicant_id='$modelApplicant->applicant_id'")->all();
    foreach ($models as $model) {
        $dropdown[$model->academic_year_id] = $model->academic_year;
    }
    return $dropdown;
}
public static function dropdownApplicantCateg() {
        $user_id = Yii::$app->user->identity->id;
       $modelUser = \common\models\User::findOne($user_id);
       $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
    $models = \frontend\modules\application\models\ApplicantCategory::findBySql("SELECT applicant_category.applicant_category_id AS 'applicant_category_id',applicant_category.applicant_category AS 'applicant_category' FROM applicant_category INNER JOIN application ON application.applicant_category_id=applicant_category.applicant_category_id WHERE application.applicant_id='$modelApplicant->applicant_id'")->all();
    foreach ($models as $model) {
        $dropdown[$model->applicant_category_id] = $model->applicant_category;
    }
    return $dropdown;
}
static function getLoanItemsDisbursedheslb($application_id,$academic_year_id,$applicant_id){
    
    $getAllApplications=\frontend\modules\application\models\Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  application.applicant_id='$applicant_id'")->asArray()->one(); 
    $applicationsResults=$getAllApplications['application_id'];
    if($applicationsResults !=''){
			$applicationsResults=$applicationsResults;
		}else{
			$applicationsResults=-1;
		}
    $resultsDisb=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT GROUP_CONCAT(DISTINCT disbursement.disbursement_batch_id) as disbursement_batch_id FROM disbursement INNER JOIN disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id WHERE  disbursement_batch.academic_year_id='$academic_year_id' AND disbursement_batch.is_approved='1' AND disbursement.application_id IN($applicationsResults) AND disbursement.status='8'")->asArray()->one();
        $valuesXcF=$resultsDisb['disbursement_batch_id'];
		if($valuesXcF !=''){
			$valuesXcF=$valuesXcF;
		}else{
			$valuesXcF=-1;
		}
        
          return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\disbursement\models\disbursement::find()->where("disbursement_batch_id IN($valuesXcF) AND application_id IN($applicationsResults) AND status='8'"),
        ]);
    }
	public static function getTotalDisbursedLoanheslb($application_id,$academic_year_id,$applicant_id){
        $getAllApplications=\frontend\modules\application\models\Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  application.applicant_id='$applicant_id'")->asArray()->one(); 
    $applicationsResults=$getAllApplications['application_id'];
    if($applicationsResults !=''){
			$applicationsResults=$applicationsResults;
		}else{
			$applicationsResults=-1;
		}
    $resultsDisb=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT GROUP_CONCAT(DISTINCT disbursement.disbursement_batch_id) as disbursement_batch_id FROM disbursement INNER JOIN disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id WHERE  disbursement_batch.academic_year_id='$academic_year_id' AND disbursement_batch.is_approved='1' AND disbursement.application_id IN($applicationsResults) AND disbursement.status='8'")->asArray()->one();
        $valuesXcF=$resultsDisb['disbursement_batch_id'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	
		}else{
			$valuesXcF=-1;
		}
        
      $query = (new \yii\db\Query())->from('disbursement')->where("disbursement_batch_id IN($valuesXcF) AND disbursement.application_id IN($applicationsResults) AND status='8'");
$sum = $query->sum('disbursed_amount');
return $sum;
//return $valuesXcF;
}
}
