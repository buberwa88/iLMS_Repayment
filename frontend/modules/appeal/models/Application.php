<?php

namespace frontend\modules\appeal\models;

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
 * @property string $loanee_category
 * @property string $bank_account_number
 * @property string $bank_account_name
 * @property integer $bank_id
 * @property string $bank_branch_name
 * @property integer $submitted
 * @property integer $verification_status
 * @property double $needness
 * @property string $programme_cost
 * @property double $myfactor
 * @property double $ability
 * @property double $fee_factor
 * @property double $student_fee
 * @property integer $allocation_status
 * @property string $allocation_comment
 * @property string $student_status
 * @property string $created_at
 * @property integer $transfer_status
 * @property string $application_number
 * @property string $passport_photo
 * @property integer $passport_photo_verified
 * @property string $passport_photo_comment
 * @property string $application_form_number
 * @property integer $loan_application_form_status
 *
 * @property Allocation[] $allocations
 * @property AllocationPlanStudent[] $allocationPlanStudents
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
            [['applicant_id', 'academic_year_id'], 'required'],
            [['applicant_id', 'academic_year_id', 'programme_id', 'application_study_year', 'current_study_year', 'applicant_category_id', 'bank_id', 'submitted', 'verification_status', 'allocation_status', 'transfer_status', 'passport_photo_verified', 'loan_application_form_status'], 'integer'],
            [['amount_paid', 'needness', 'programme_cost', 'myfactor', 'ability', 'fee_factor', 'student_fee'], 'number'],
            [['date_bill_generated', 'date_control_received', 'date_receipt_received', 'created_at'], 'safe'],
            [['loanee_category', 'student_status'], 'string'],
            [['registration_number', 'bill_number', 'control_number', 'receipt_number', 'bank_account_number'], 'string', 'max' => 20],
            [['pay_phone_number'], 'string', 'max' => 13],
            [['bank_account_name'], 'string', 'max' => 60],
            [['bank_branch_name'], 'string', 'max' => 45],
            [['allocation_comment'], 'string', 'max' => 500],
            [['application_number'], 'string', 'max' => 30],
            [['passport_photo'], 'string', 'max' => 200],
            [['passport_photo_comment'], 'string', 'max' => 300],
            [['application_form_number'], 'string', 'max' => 255],
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
            'loanee_category' => 'Loanee Category',
            'bank_account_number' => 'Bank Account Number',
            'bank_account_name' => 'Bank Account Name',
            'bank_id' => 'Bank ID',
            'bank_branch_name' => 'Bank Branch Name',
            'submitted' => 'Submitted',
            'verification_status' => 'Verification Status',
            'needness' => 'Needness',
            'programme_cost' => 'Programme Cost',
            'myfactor' => 'Myfactor',
            'ability' => 'Ability',
            'fee_factor' => 'Fee Factor',
            'student_fee' => 'Student Fee',
            'allocation_status' => 'Allocation Status',
            'allocation_comment' => 'Allocation Comment',
            'student_status' => 'Student Status',
            'created_at' => 'Created At',
            'transfer_status' => 'Transfer Status',
            'application_number' => 'Application Number',
            'passport_photo' => 'Passport Photo',
            'passport_photo_verified' => 'Passport Photo Verified',
            'passport_photo_comment' => 'Passport Photo Comment',
            'application_form_number' => 'Application Form Number',
            'loan_application_form_status' => 'Loan Application Form Status',
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
    public function getAllocationPlanStudents()
    {
        return $this->hasMany(AllocationPlanStudent::className(), ['application_id' => 'application_id']);
    }
}
