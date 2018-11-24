<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $sex
 * @property string $username
 * @property string $password_hash
 * @property integer $security_question_id
 * @property string $security_answer
 * @property string $email_address
 * @property string $passport_photo
 * @property string $phone_number
 * @property integer $is_default_password
 * @property integer $status
 * @property string $status_comment
 * @property integer $login_counts
 * @property string $last_login_date
 * @property string $date_password_changed
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $activation_email_sent
 * @property integer $email_verified
 * @property string $created_at
 * @property integer $created_by
 *
 * @property AdmissionBatch[] $admissionBatches
 * @property AllocationBatch[] $allocationBatches
 * @property AllocationSetting[] $allocationSettings
 * @property Applicant $applicant
 * @property Disbursement[] $disbursements
 * @property DisbursementBatch[] $disbursementBatches
 * @property EmployedBeneficiary[] $employedBeneficiaries
 * @property Employer[] $employers
 * @property InstitutionPaymentRequest[] $institutionPaymentRequests
 * @property LearningInstitution[] $learningInstitutions
 * @property LearningInstitutionFee[] $learningInstitutionFees
 * @property LoanRepaymentBill[] $loanRepaymentBills
 * @property LoanRepaymentItem[] $loanRepaymentItems
 * @property LoanRepaymentSetting[] $loanRepaymentSettings
 * @property QuestionTrigger[] $questionTriggers
 * @property Staff[] $staff
 * @property StudentExamResult[] $studentExamResults
 * @property SecurityQuestion $securityQuestion
 * @property User $createdBy
 * @property User[] $users
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public $password;
    public $confirm_password;
    public $confirm_email;
    public $confirm_telephone_no;
    public $captcha;
    


    public function rules()
    {
        return [
            //[['firstname', 'surname', 'username', 'password_hash', 'email_address', 'phone_number', 'last_login_date', 'auth_key', 'created_at'], 'required'],
            [['firstname', 'surname', 'middlename', 'password_hash', 'email_address', 'password', 'created_at', 'confirm_password', 'phone_number'], 'required', 'on'=>'employer_registration'],
	    ['password', 'string', 'length' => [8, 24]],            
            [['security_question_id', 'is_default_password', 'status', 'login_counts', 'activation_email_sent', 'email_verified', 'created_by', 'phone_number'], 'integer'],
            [['status_comment'], 'string'],
            [['last_login_date', 'date_password_changed', 'created_at'], 'safe'],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            //[['sex'], 'string', 'max' => 1],
            [['username', 'passport_photo'], 'string', 'max' => 200],
            [['password_hash', 'auth_key', 'password_reset_token', 'password', 'confirm_password'], 'string', 'max' => 255],
            [['security_answer', 'phone_number'], 'string', 'max' => 50],
            [['email_address'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['email_address'], 'unique'],
            ['email_address', 'email'],
           // [['captcha'], 'captcha'],
            [['confirm_email'], 'email'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords must be retyped exactly", 'on' => 'employer_registration' ],
            //[['security_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\SecurityQuestion::className(), 'targetAttribute' => ['security_question_id' => 'security_question_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            //'sex' => 'Sex',
            'username' => 'Username',
            'password_hash' => 'Password',
            'confirm_password'=>'Retype Password',
            'password'=>'Password',
            'security_question_id' => 'Security Question ID',
            'security_answer' => 'Security Answer',
            'email_address' => 'Email Address',
            'passport_photo' => 'Passport Photo',
            'phone_number' => 'Mobile Telephone No.',
            'is_default_password' => 'Is Default Password',
            'status' => 'Status',
            'status_comment' => 'Status Comment',
            'login_counts' => 'Login Counts',
            'last_login_date' => 'Last Login Date',
            'date_password_changed' => 'Date Password Changed',
            'auth_key' => 'Verification Code',
            'password_reset_token' => 'Password Reset Token',
            'activation_email_sent' => 'Activation Email Sent',
            'email_verified' => 'Email Verified',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionBatches()
    {
        return $this->hasMany(AdmissionBatch::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationBatches()
    {
        return $this->hasMany(AllocationBatch::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationSettings()
    {
        return $this->hasMany(AllocationSetting::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant()
    {
        return $this->hasOne(Applicant::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursements()
    {
        return $this->hasMany(Disbursement::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches()
    {
        return $this->hasMany(DisbursementBatch::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployedBeneficiaries()
    {
        return $this->hasMany(EmployedBeneficiary::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployers()
    {
        return $this->hasMany(Employer::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequests()
    {
        return $this->hasMany(InstitutionPaymentRequest::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutions()
    {
        return $this->hasMany(LearningInstitution::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutionFees()
    {
        return $this->hasMany(LearningInstitutionFee::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBills()
    {
        return $this->hasMany(LoanRepaymentBill::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentItems()
    {
        return $this->hasMany(LoanRepaymentItem::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentSettings()
    {
        return $this->hasMany(LoanRepaymentSetting::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionTriggers()
    {
        return $this->hasMany(QuestionTrigger::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults()
    {
        return $this->hasMany(StudentExamResult::className(), ['created_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecurityQuestion()
    {
        return $this->hasOne(\backend\modules\application\models\SecurityQuestion::className(), ['security_question_id' => 'security_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['created_by' => 'user_id']);
    }
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}
