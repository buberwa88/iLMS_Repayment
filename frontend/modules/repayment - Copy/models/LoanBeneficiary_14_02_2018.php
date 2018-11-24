<?php

namespace frontend\modules\repayment\models;

use Yii;
use frontend\modules\application\models\Applicant;
//use frontend\modules\application\models\User;
use \common\models\User;
/**
 * This is the model class for table "loan_beneficiary".
 *
 * @property integer $loan_beneficiary_id
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $f4indexno
 * @property string $NID
 * @property string $date_of_birth
 * @property integer $place_of_birth
 * @property integer $learning_institution_id
 * @property string $postal_address
 * @property string $physical_address
 * @property string $phone_number
 * @property string $email_address
 * @property string $password
 *
 * @property Ward $placeOfBirth
 * @property LearningInstitution $learningInstitution
 */
class LoanBeneficiary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loan_beneficiary';
    }

    /**
     * @inheritdoc
     */
    public $confirm_password;
    public $region;
	public $district;
    public function rules()
    {
        return [
            [['firstname', 'middlename', 'surname', 'date_of_birth', 'place_of_birth', 'learning_institution_id', 'physical_address', 'phone_number', 'email_address', 'password','district','confirm_password','sex','region'], 'required', 'on' => 'loanee_registration'],
            ['password', 'string', 'length' => [8, 24]],
            [['date_of_birth','created_at','updated_at','updated_by','sex','region'], 'safe'],
            [['place_of_birth', 'learning_institution_id', 'phone_number'], 'integer'],
            [['firstname', 'middlename', 'surname', 'f4indexno'], 'string', 'max' => 45],
            [['NID', 'postal_address'], 'string', 'max' => 30],
            [['physical_address', 'email_address'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            //[['email_address'], 'unique','message'=>'Email Address Exist'],
            ['email_address', 'email'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords must be retyped exactly", 'on' => 'loanee_registration' ],
            [['place_of_birth'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Ward::className(), 'targetAttribute' => ['place_of_birth' => 'ward_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_beneficiary_id' => 'Loan Beneficiary ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'f4indexno' => 'F4indexno',
            'NID' => 'Nid',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => 'Place Of Birth(Ward)',
            'learning_institution_id' => 'Learning Institution ID',
            'postal_address' => 'Postal Address',
            'physical_address' => 'Physical Address',
            'phone_number' => 'Phone Number',
            'email_address' => 'Email Address',
            'password' => 'Password',
            'confirm_password'=>'Confirm Password',
            'district'=>'Place of Birth(District)', 
            'created_at'=>'Created at',
            'updated_at'=>'Updated at',
            'updated_by'=>'Updated by',
			'place_of_birth'=>'Ward',
			'sex'=>'Sex',
			'region'=>'Region',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceOfBirth()
    {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['place_of_birth' => 'ward_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution()
    {
        return $this->hasOne(\backend\modules\application\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'updated_by']);
    }
    public function getUser($applicantID){
        $details_applicant = Applicant::findBySql("SELECT a.user_id AS user_id,b.username AS username FROM applicant a INNER JOIN user b ON a.user_id=b.user_id  WHERE  a.applicant_id='$applicantID' ORDER BY a.applicant_id DESC")->one();
        $user_id=$details_applicant->user_id;        
        $value = (count($user_id) == 0) ? '0' : $details_applicant;
        return $value;
        }
    public function updateUserBasicInfo($username,$password,$auth_key,$user_id){
        User::updateAll(['username' =>$username,'password_hash' =>$password,'auth_key' =>$auth_key,'status'=>'0' ], 'user_id ="'.$user_id.'"');
 }    
}
