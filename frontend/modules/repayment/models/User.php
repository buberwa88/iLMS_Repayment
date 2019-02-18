<?php
namespace frontend\modules\repayment\models;

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
 * @property integer $updated_at
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
	public $confirm_email;
	public $recover_password;
	public $TIN;
	public $employer_type_id;
    public $employer_id;
	public $phone_number_employer;
	public $fax_number;
	public $verifyCode;	
	public $region;
	public $district;
	public $ward_id;

    public $validated;
	public $staffLevel;

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
            [['user_id','sex','employer_id'], 'safe'],      
			//[['firstname', 'surname', 'middlename', 'password_hash', 'email_address', 'login_type', 'created_at','phone_number_employer'], 'required','on'=>['employer_registration','heslb_employer_registration']],
			[['firstname', 'surname','phone_number'], 'required','on'=>'update_contact_person'],
			[['firstname', 'surname','email_address','phone_number'], 'required','on'=>'employer_contact_person'],
			[['firstname', 'surname', 'middlename', 'password_hash', 'email_address', 'password', 'confirm_password','phone_number','confirm_email','employer_type_id','region','district','ward_id'], 'required', 'on'=>['employer_registration']],
			[['firstname', 'surname', 'email_address', 'password','confirm_password','phone_number','staffLevel'], 'required', 'on'=>'add_staffs'],
			[['firstname', 'surname', 'middlename', 'password_hash', 'password', 'confirm_password','phone_number','employer_type_id','region','district','ward_id'], 'required', 'on'=>['heslb_employer_registration']],
			[['firstname', 'surname', 'middlename', 'email_address','phone_number'], 'required', 'on'=>'employer_update_information'],
			[['password_hash','confirm_password'], 'required', 'on'=>'employer_change_password'],
			['password', 'string', 'length' => [8, 24]],
			[['TIN'], 'checkEmployerTypeTIN','skipOnEmpty' => false],
            [['recover_password'], 'required', 'on'=>'recover_password'],
            [['security_question_id', 'is_default_password', 'status', 'login_counts', 'activation_email_sent', 'email_verified', 'created_by'], 'integer'],
            [['status_comment'], 'string'],
			[['firstname', 'middlename', 'surname'], 'match','not' => true,'pattern' => '/[^a-zA-Z_-]/','message' => 'Only Characters  Are Allowed...'],
            [['last_login_date', 'date_password_changed', 'created_at','updated_at','updated_by'], 'safe'],
            [['firstname', 'middlename', 'surname'], 'string', 'max' => 45],
            //[['sex'], 'string', 'max' => 1],
            [['username', 'passport_photo'], 'string', 'max' => 200],
            [['password_hash', 'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['security_answer', 'phone_number'], 'string', 'max' => 50],
            [['email_address'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['email_address'], 'unique'],
            ['email_address', 'email'],
			['verifyCode', 'captcha','on'=>'employer_registration'],
			['phone_number', 'checkphonenumber'],
			['phone_number_employer', 'checkphonenumberemployer'],
			['fax_number', 'checkFaxNumber','skipOnEmpty' => true],
			['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords must be retyped exactly", 'on' => ['employer_registration','heslb_employer_registration']],
			['confirm_email', 'compare', 'compareAttribute'=>'email_address', 'message'=>"Email must be retyped exactly", 'on' => ['employer_registration']],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords must be retyped exactly", 'on' => 'employer_contact_person' ],
			['confirm_email', 'compare', 'compareAttribute'=>'email_address', 'message'=>"Email must be retyped exactly", 'on' => 'employer_contact_person'],
			['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords must be retyped exactly", 'on' => 'employer_change_password' ],
			['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords must be retyped exactly"],
            [['security_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\SecurityQuestion::className(), 'targetAttribute' => ['security_question_id' => 'security_question_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
			[['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
			['password','match','pattern' => '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message' =>'Password must contain at least one lower and upper case character and a digit.'],
            [['password','confirm_password'],'required','on'=>['employer_registration','employer_contact_person','change_pwd_contact_person','heslb_employer_registration']],
			//[['password'], StrengthValidator::className(), 'min'=>8, 'digit'=>0, 'special'=>3]
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Last Name',
            //'sex' => 'Sex',
            'username' => 'Username',
            'password_hash' => 'Password',
            'security_question_id' => 'Security Question ID',
            'security_answer' => 'Security Answer',
            'email_address' => 'Email Address',
            'passport_photo' => 'Passport Photo',
            'phone_number' => 'Mobile Phone No.',
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
            'created_by' => 'Created By',
			'confirm_password'=>'Retype Password',
			'password'=>'Password',
			'updated_at'=>'updated_at',
			'confirm_email'=>'Confirm Email',
			'recover_password'=>'Email Address or Form IV Index Number:',
			'updated_by'=>'Updated by',
			'TIN'=>'TIN',
			'employer_type_id'=>'Employer Type',
            'employer_id'=>'employer_id',
			'phone_number_employer'=>'Work Phone No.',
			'verifyCode'=>'Type below the blue characters:',
			'staffLevel'=>'Role',
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['created_by' => 'user_id']);
    }
	public function checkphonenumber($attribute, $params)
{
    $phone=str_replace(" ","",str_replace(",","",$this->phone_number));
	 if (!preg_match('/^[0-9]*$/', $phone)) {
    $this->addError('phone_number', 'Incorrect Mobile Phone No.');
    } 
}
public function checkphonenumberemployer($attribute, $params)
{
    $phone=str_replace(" ","",str_replace(",","",$this->phone_number_employer));
	 if (!preg_match('/^[0-9]*$/', $phone)) {
    $this->addError('phone_number_employer', 'Incorrect Work Phone No.');
    } 
}
public function checkEmployerTypeTIN($attribute, $params)
{
    $employerType=\backend\modules\repayment\models\EmployerType::find()
	->andWhere(['employer_type_id' =>$this->employer_type_id])
	->andWhere(['has_TIN' =>1])
	->one();
	 if (count($employerType)>0 && $this->TIN==''){
    $this->addError('TIN', 'TIN can not be blank');
    } 
	if (count($employerType)>0 && $this->TIN !=''){
	$EmployerTIN=\frontend\modules\repayment\models\Employer::find()
	->andWhere(['TIN' =>$this->TIN])
	->one();
	if (count($EmployerTIN)>0){
    $this->addError('TIN', 'TIN  exists');
	}
    }
	$employerType=\backend\modules\repayment\models\EmployerType::find()
	->andWhere(['employer_type_id' =>$this->employer_type_id])
	->andWhere(['has_TIN' =>1])
	->one();
	 if (count($employerType)>0 && $this->TIN !=''){
		 $tinCount=strlen(str_replace("_","",str_replace("-","",$this->TIN)));
		 if($tinCount < 9){
    $this->addError('TIN', 'Incorrect TIN');
		 }
    }  
}
public function checkFaxNumber($attribute, $params)
{
    $phone=str_replace(" ","",str_replace(",","",$this->fax_number));
	 if (!preg_match('/^[0-9]*$/', $phone)) {
    $this->addError('fax_number', 'Incorrect Fax Number.');
    } 
}
}
