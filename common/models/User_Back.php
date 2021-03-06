<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
 * @property integer $login_type
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
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    
    public $password;
    public $confirm_password;
    public $validated;
    public $verifyCode;
    
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['user_id'], 'safe'],      
            [['firstname', 'surname',  'password', 'email_address', 'login_type','validated','phone_number'], 'required'],
            [['security_question_id', 'is_default_password', 'status', 'login_counts', 'activation_email_sent', 'email_verified', 'created_by', 'phone_number'], 'integer'],
            [['status_comment'], 'string'],
            [['last_login_date', 'date_password_changed','middlename', 'created_at'], 'safe'],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            [['sex'], 'string', 'max' => 1],
            [['username', 'passport_photo'], 'string', 'max' => 200],
           // [['password_hash', 'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['security_answer', 'phone_number'], 'string', 'max' => 50],
            [['phone_number'], 'number', 'max' =>10,'min'=>10],
            [['email_address'], 'string', 'max' => 100],
            [['username'], 'unique'],
            //[['email_address'], 'unique'],
            ['email_address', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['email_address', 'email'],
            [['confirm_password'],'required'],
            ['password','match','pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message' =>'Password must contain at least one lower and upper case character and a digit.'],
            ['confirm_password','compare','compareAttribute'=>'password'],
            ['verifyCode', 'captcha'],
            //[['security_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\SecurityQuestion::className(), 'targetAttribute' => ['security_question_id' => 'security_question_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
          
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'verifyCode'=>'Type below the blue characters. Click on the blue characters to get a new one if not clearly seen',
            'sex' => 'Sex',
            'username' => 'Username',
            'password_hash' => 'Password ',
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
            'login_type' => 'Login Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
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
}