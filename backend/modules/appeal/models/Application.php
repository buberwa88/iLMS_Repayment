<?php

namespace backend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property integer $application_id
 * @property integer $applicant_id
 * @property string $registration_number
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
 * @property integer $transfer_status
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
    public function rules()
    {
        return [
            [['applicant_id', 'academic_year_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'created_at', 'transfer_status'], 'required'],
            [['applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status', 'transfer_status'], 'integer'],
            [['amount_paid', 'needness'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'created_at'], 'safe'],
            [['student_status'], 'string'],
            [['registration_number', 'bill_number', 'control_number', 'receipt_number', 'bank_account_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['bank_account_name'], 'string', 'max' => 60],
            [['bank_branch_name'], 'string', 'max' => 45],
            [['allocation_comment'], 'string', 'max' => 500],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['applicant_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['applicant_category_id' => 'applicant_category_id']],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'bank_id']],
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
            'registration_number' => 'Registration Number',
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
            'transfer_status' => 'Transfer Status',
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
        return $this->hasMany(Education::className(), ['application_id' => 'application_id']);
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
}
