<?php

namespace backend\modules\repayment\models;

use Yii;
use backend\modules\repayment\models\EmployedBeneficiary;
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
    public $region;
    public $district;
    public $employerCode;
    public $totatEmployees;
	public $employerID;
    public function rules()
    {
        return [
            //[['user_id', 'employer_name', 'employer_code', 'phone_number', 'physical_address', 'email_address'], 'required'],
            [['user_id','employer_name', 'employer_code', 'phone_number','employer_type_id','postal_address','ward_id','district','short_name','nature_of_work_id'], 'required', 'on'=>'employer_details'],
			[['rejection_reason'], 'required' , 'on'=>'employer_rejection'],			
            [['user_id', 'ward_id','district','phone_number'], 'integer'],
            [['employer_type_id','employerCode', 'short_name', 'nature_of_work_id'], 'string'],
            [['created_at', 'email_address','employerCode', 'short_name', 'totatEmployees', 'verification_status', 'region', 'nature_of_work_id','rejection_date','employerID','rejection_reason','vote_number'], 'safe'],
            [['employer_name', 'physical_address', 'email_address','nature_of_work_id'], 'string', 'max' => 100],
			[['rejection_reason'], 'string', 'max' => 500],
            [['employer_code'], 'string', 'max' => 20],
            [['postal_address'], 'string', 'max' => 30],
            [['phone_number'], 'string', 'max' => 50],            
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
            'employer_name' => 'Name',
            'employer_code' => 'Code',
            'employer_type_id' => 'Type',
            'postal_address' => 'Postal Address',
            'phone_number' => 'Fixed Telesphone No.',
            'physical_address' => 'Physical Address',
            'ward_id' => 'Ward',
            'email_address' => 'Email Address',
            'created_at' => 'Created At',
            'district'=>'District',
            'employerCode'=>'Employer Code',
            'short_name'=>'Employer Short Name',
            'nature_of_work_id'=>'Nature of Work',
            'totatEmployees'=>'Employees',
            'verification_status'=>'Status',
            'region'=>'Region',
            'nature_of_work_id'=>'Nature of Work',
			'rejection_reason'=>'Reason',
			'rejection_date'=>'Rejection Date',
			'employerID'=>'Employer Id',
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
    
    public function getTotalEmployees($employerID){
    $totatEmployees = EmployedBeneficiary::findBySql("SELECT COUNT(*) AS 'employer_id' FROM  employed_beneficiary WHERE   employed_beneficiary.employer_id='$employerID' AND employment_status='ONPOST'")->one();
      //$total=$totatEmployees->employer_id;
    //$total_value = (count($totatEmployees) == 0) ? '0' : $total;
	if(count($totatEmployees) > 0){
	$totalV=$totatEmployees->employer_id;
	}else{
	$totalV=0;
	}
  return $totalV;
 }
 
 public static function getEmployerDetails($employerID){
    return self::findBySql("SELECT * FROM  employer WHERE   employer_id='$employerID'")->one();
}
 
    public function updateEmployerVerificationStatus($employerID,$actionID){
        Employer::updateAll(['verification_status' =>$actionID], 'employer_id ="'.$employerID.'"');
 }
 
    public function updateEmployerVerificationStatus2($employerID,$actionID,$rejectionReason){
        $rejectionDate=date("Y-m-d H:i:s");
        Employer::updateAll(['verification_status' =>$actionID,'rejection_reason'=>$rejectionReason,'rejection_date'=>$rejectionDate], 'employer_id ="'.$employerID.'"');
 }
    public static function updateEmployerCode($employerID,$employerCode){
        Employer::updateAll(['employer_code' =>$employerCode], 'employer_id ="'.$employerID.'"');
 }
       
}
