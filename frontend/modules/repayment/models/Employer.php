<?php

namespace frontend\modules\repayment\models;

use Yii;
use backend\modules\repayment\models\EmployedType;

/**
 * This is the model class for table "employer".
 *
 * @property integer $employer_id
 * @property integer $user_id
 * @property string $employer_name
 * @property string $employer_code
 * @property string $type
 * @property string $postal_address
 * @property string $phone_number
 * @property string $physical_address
 * @property integer $ward_id
 * @property string $email_address
 * @property integer $loan_summary_requested
 * @property string $created_at
 *
 * @property EmployedBeneficiary[] $employedBeneficiaries
 * @property User $user
 * @property Ward $ward
 * @property LoanRepayment[] $LoanRepaymentes
 * @property LoanSummary[] $LoanSummarys
 */
class Employer extends \yii\db\ActiveRecord
{
    
    const EMPLOYER_TYPE_PRIVATE = 1;
    const EMPLOYER_TYPE_GOVERNMENT = 2;
    const EMPLOYER_TYPE_FOREIGN = 3;
	const EMPLOYER_CODE_FORMAT = "000000";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer';
    }

    /**
     * @inheritdoc
     */
    public $district;
	public $employerName;
	public $countEmployer;
	public $region;
	public $email_verification_code2;
	public $email_address2;
	public $phone_number2;
        public $sector;
        public $industry;
    public function rules()
    {
        return [
            //[['user_id', 'employer_name', 'employer_code', 'phone_number', 'physical_address', 'email_address'], 'required'],
            [['user_id','employer_name','postal_address','ward_id','employer_type_id','district','nature_of_work_id','physical_address','employerName','region','email_address','phone_number'], 'required', 'on'=>'employer_details'],
			[['employer_name','employer_type_id','postal_address','ward_id','district','nature_of_work_id','physical_address','region','email_address','phone_number'], 'required', 'on'=>'employer_update_information'],
			[['salary_source','vote_number'], 'required', 'on'=>'employer_update_salary_source'],
			[['email_address','email_address2'], 'required', 'on'=>'employer_forgot_password_reset'],
            [['user_id', 'ward_id','district','employer_type_id','nature_of_work_id'], 'integer'],
			//[['employer_name'], 'unique', 'message'=>'Employer Exists'],
            [[ 'short_name'], 'string'],			
            [['created_at', 'email_address','employer_code', 'short_name','phone_number','verification_status','TIN','countEmployer','district','region','ward_id','fax_number','email_verification_code','email_verification_code2','nature_of_work_other','salary_source','sector','industry','vote_number'], 'safe'],
            /*['industry', 'required', 'when' => function ($model) {
    return $model->employer_type_id == 1 || $model->employer_type_id == 3;
}, 'whenClient' => "function (attribute, value) {
    return $('#employer_type_id').val() == 1;
}"],
             
        ['sector', 'required', 'when' => function ($model) {
    return $model->employer_type_id == 2;
}, 'whenClient' => "function (attribute, value) {
    return $('#employer_type_id').val() == 2;
}"],
             * 
             */
            [['employer_name', 'physical_address', 'email_address'], 'string', 'max' => 100],
            [['employer_code'], 'string', 'max' => 20],
            [['postal_address'], 'string', 'max' => 30],
            [['phone_number'], 'string', 'max' => 50],
			//['phone_number', 'checkphonenumber','on'=>'employer_details'],
            ['email_address', 'email'],			
	        [['email_verification_code'],'checkEmployerVerificationCodeExists','on'=>'employer_confirm_verification_code'],	
            [['email_verification_code'],'required','on'=>'employer_confirm_verification_code'],			
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['ward_id' => 'ward_id']],
			[['nature_of_work_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\NatureOfWork::className(), 'targetAttribute' => ['nature_of_work_id' => 'nature_of_work_id']],
			[['employer_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\EmployerType::className(), 'targetAttribute' => ['employer_type_id' => 'employer_type_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employer_id' => 'Employer ID',
            'user_id' => 'User ID',
            'employer_name' => 'Employer Name',
            'employer_code' => 'Employer Code',
            'employer_type_id' => 'Employer Type',
            'postal_address' => 'Postal Address',
            'phone_number' => 'Office Telephone No.',
            'physical_address' => 'Physical Address',
            'ward_id' => 'Ward',
            'email_address' => 'Office Email Address',
            'created_at' => 'Created At',
            'district'=>'District',
            'short_name'=>'Employer Short Name',
            'nature_of_work_id'=>'Sector',
            'short_name'=>'Employer Short Name',
            'verification_status'=>'Verification Status',
			'TIN'=>'TIN',
			'employerName'=>'Employer Name',
			'countEmployer'=>'Total Employer',
			'region'=>'Region',
			'fax_number'=>'Fax Number',
			'email_verification_code'=>'Email Verification Code',
			'email_verification_code2'=>'Verification Code',
			'phone_number2'=>'Contact Person Phone Number:',
			'email_address2'=>'Contact Person Email Address:',
			'nature_of_work_other'=>'Other Sector',
			'salary_source'=>'Salary Source',
                        'sector'=>'Sector',
                        'industry'=>'Industry',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployedBeneficiaries()
    {
        return $this->hasMany(EmployedBeneficiary::className(), ['employer_id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWard()
    {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'ward_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentes()
    {
        return $this->hasMany(LoanRepayment::className(), ['employer_id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSummarys()
    {
        return $this->hasMany(LoanSummary::className(), ['employer_id' => 'employer_id']);
    }
	/**
     * @return \yii\db\ActiveQuery
     */
	public function getNatureOfWork()
    {
        return $this->hasOne(\backend\modules\repayment\models\NatureOfWork::className(), ['nature_of_work_id' => 'nature_of_work_id']);
    }
	/**
     * @return \yii\db\ActiveQuery
     */
	public function getEmployerType()
    {
        return $this->hasOne(\backend\modules\repayment\models\EmployerType::className(), ['employer_type_id' => 'employer_type_id']);
    }
        
    public static function getWardName($districtId) {
            $data2 = \backend\modules\application\models\Ward::findBySql(" SELECT ward_id AS id, ward_name AS name FROM ward WHERE district_id='$districtId'")->asArray()->all();
            $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            return $value2;
        
    }
	public static function getDistrictName($RegionId) {
            $data2 = \common\models\District::findBySql(" SELECT district_id AS id, district_name AS name FROM district WHERE region_id='$RegionId'")->asArray()->all();
            $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
            return $value2;
        
    }
    public function updateEmployerCode($employerID,$employerCode){
        $this->updateAll(['employer_code' =>$employerCode], 'employer_id ="'.$employerID.'"');
 }
 public function checkEmployerExists($employerName){
        $employerFound = $this->findBySql("SELECT employer_id FROM employer  WHERE  employer_name='$employerName'")->one();
		if((count($employerFound) > 0)){
		$employerFoundStatus=$employerFound->employer_id;
		}else{
		$employerFoundStatus=0;
		}
		return $employerFoundStatus;
        }
		/*
 public function checkEmployerVerificationCodeExists($employer_id,$verification_code){
		$employerEmailVerificationCodeFound = $this->find()->where(['employer_id="'.$employer_id.'" AND email_verification_code="'.$verification_code.'"'])->one();
		if((count($employerEmailVerificationCodeFound) > 0)){
		$userID=$employerEmailVerificationCodeFound->user_id;
		}else{
		$userID=0;
		}
		return $userID;
        }	
*/		
		
  public function checkEmployerVerificationCodeExists($attribute_name, $params) {
       $code = $this->find()->where(['email_verification_code' => $this->$attribute_name])->one();
       if ($code) {
	   return true;
       }
        $this->addError($attribute_name, 'Invalid verification code...');
        return false;
   }
   public function getEmployerDetais($employerOfficeEmail,$EmployerContactPersonEmail) {
        $details_employer_details = $this->findBySql("SELECT * FROM employer INNER JOIN user ON user.user_id=employer.user_id "
                        . "WHERE  employer.email_address='$employerOfficeEmail' AND user.email_address ='$EmployerContactPersonEmail' ORDER BY employer.employer_id DESC")->one();
		if(count($details_employer_details)>0){
		$employer_idR = $details_employer_details->employer_id;
		}else{
		$employer_idR=0;
		}
        return $employer_idR;
    }
	public function getEmployerDetaisUsingEmployerID($employerID) {
        $details_employer_details = $this->findBySql("SELECT * FROM employer INNER JOIN user ON user.user_id=employer.user_id "
                        . "WHERE  employer.employer_id='$employerID' ORDER BY employer.employer_id DESC")->one();
		if(count($details_employer_details)>0){
		$employer_idR = $details_employer_details;
		}else{
		$employer_idR=0;
		}
        return $employer_idR;
    }
	
	public function checkphonenumber($attribute, $params)
{
    $phone=str_replace(",","",$this->phone_number);
    //Here you do your validation logic
    if(!is_int($phone))
    {
        $this->addError('phone_number', 'Incorrect phone number');
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
}
     public static function getEmployerSalarySource($employerID)
{
						
						$employerDetails=Employer::findBySql("SELECT employer.employer_id AS employer_id,employer_type.employer_type_id AS employer_type_id,employer_type.employer_type AS employer_type,salary_source FROM employer INNER JOIN employer_type ON employer.employer_type_id=employer_type.employer_type_id "
                        . " WHERE  employer.employer_id='$employerID' AND employer_type.employer_type='Government' AND (salary_source IS NULL OR salary_source ='')")->one();
	 if (count($employerDetails)>0){
        $result=1;
    }else{
	    $result=0;
	}
    return 	$result;
}

public static function getEmployerSalarySource2($employerID)
{
						
$employerDetails=Employer::findBySql("SELECT salary_source FROM employer WHERE  employer_id='$employerID'")->one();
	 if ($employerDetails->salary_source==1){
        $result=1;
    }else{
	    $result=0;
	}
    return 	$result;
}

public static function getEmployerCategory($employerID)
{
						
						$employerDetails2=Employer::findBySql("SELECT employer.employer_id AS employer_id,employer_type.employer_type_id AS employer_type_id,employer_type.employer_type AS employer_type,salary_source FROM employer INNER JOIN employer_type ON employer.employer_type_id=employer_type.employer_type_id "
                        . " WHERE  employer.employer_id='$employerID'")->one();
    return 	$employerDetails2;
}

static function getEmployerTypeValues() {
        return [
            self::EMPLOYER_TYPE_PRIVATE => 'Private',
            self::EMPLOYER_TYPE_GOVERNMENT => 'Government',
            self::EMPLOYER_TYPE_FOREIGN => 'Foreign',            
        ];
    }
}
