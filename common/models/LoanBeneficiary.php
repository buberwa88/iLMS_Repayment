<?php

namespace common\models;

use Yii;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Application;
use frontend\modules\repayment\models\Employer;
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
	public $ward_id;
	public $operation;
	public $check_search;
	public $start_date;
	public $end_date;
    public function rules()
    {
        return [
            [['firstname', 'middlename', 'surname', 'date_of_birth', 'place_of_birth', 'learning_institution_id', 'physical_address', 'phone_number', 'email_address', 'password','district','confirm_password','sex','region'], 'required', 'on' => 'loanee_registration'],
			[['start_date', 'end_date'], 'required', 'on' => 'reprocessloan'],
            ['password', 'string', 'length' => [8, 24]],
            [['date_of_birth','created_at','updated_at','updated_by','sex','region','applicant_id','NID','ward_id','operation','check_search','start_date','end_date'], 'safe'],
            [['place_of_birth', 'learning_institution_id', 'phone_number','applicant_id'], 'integer'],
            [['firstname', 'middlename', 'surname', 'f4indexno'], 'string', 'max' => 45],
			[['firstname', 'middlename', 'surname'], 'match','not' => true,'pattern' => '/[^a-zA-Z_-]/','message' => 'Only Characters  Are Allowed...'],
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
			[['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_beneficiary_id' => 'Loan Beneficiary ID',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'surname' => 'Last Name',
            'f4indexno' => 'Form IV Index No.',
            'NID' => 'National Identification No.',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => 'Place Of Birth(Ward)',
            'learning_institution_id' => 'Learning Institution',
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
			//'place_of_birth'=>'Ward',
			'sex'=>'Sex',
			'region'=>'Region',
			'applicant_id'=>'applicant_id',
			'ward_id'=>'Ward',
			'operation'=>'operation',
			'start_date'=>'From',
			'end_date'=>'To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
	 public function getApplicant() {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
    }
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceOfBirth()
    {
        return $this->hasOne(\backend\modules\application\models\Ward::className(), ['ward_id' => 'place_of_birth']);
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
    public function getApplicantDetails($applcantF4IndexNo, $NIN) {
        if ($applcantF4IndexNo != '' && $NIN != '') {

            $details1 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE  f4indexno='$applcantF4IndexNo' AND NID='$NIN' ORDER BY applicant_id DESC")->one();
            $applicantResult = $details1->applicant_id;

            $value1 = (count($applicantResult) == 0) ? '0' : '1';
            if ($value1 == 0) {
                $details2 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE f4indexno='$applcantF4IndexNo' ORDER BY applicant_id DESC")->one();
                $applicantResult2 = $details2->applicant_id;
                $value2 = (count($applicantResult2) == 0) ? '0' : '1';
                if ($value2 == 0) {
                    $details3 = \frontend\modules\application\models\Applicant::findBySql("SELECT * FROM applicant  WHERE NID='$NIN' ORDER BY applicant_id DESC")->one();
                    $applicantResult3 = $details3->applicant_id;
                    $value3 = (count($applicantResult3) == 0) ? '0' : '1';
                    if ($value3 == 1) {
                        $resultsFound = $applicantResult3;
                    } else {
                        $resultsFound = $applicantResult3;
                    }
                } else {
                    $resultsFound = $details2;
                }
            } else {
                $resultsFound = $details1;
            }
        } else if ($applcantF4IndexNo == '' && $NIN != '') {
            $details_4 = \frontend\modules\application\models\Applicant::find()
                            ->where(['NID' => $NIN])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
            $resultsFound = $details_4;
        } else if ($applcantF4IndexNo != '' && $NIN == '') {
            $details_5 = \frontend\modules\application\models\Applicant::find()
                            ->where(['f4indexno' => $applcantF4IndexNo])
                            ->orderBy('applicant_id DESC')
                            ->limit(1)->one();
            $resultsFound = $details_5;
        } else if ($applcantF4IndexNo == '' && $NIN == '') {
            $resultsFound = "";
        }
        return $resultsFound;
    } 
	public function getApplicantDetailsUsingNonUniqueIdentifiers($f4indexno, $dateofbirth, $placeofbirth, $learningInstitution) {
        $details_applicant = Applicant::findBySql("SELECT * FROM applicant INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN application ON application.applicant_id=applicant.applicant_id INNER JOIN programme ON programme.programme_id=application.programme_id INNER JOIN ward ON ward.ward_id=applicant.place_of_birth "
                        . "WHERE  applicant.date_of_birth='$dateofbirth' AND applicant.f4indexno='$f4indexno' AND ward.ward_id='$placeofbirth' AND programme.learning_institution_id ='$learningInstitution' ORDER BY applicant.applicant_id DESC")->one();
		if(count($details_applicant)>0){
		$applicant_idR = $details_applicant->applicant_id;
		}else{
		$applicant_idR=0;
		}
        return $applicant_idR;
    }
	public static function getApplicantDetailsUsingApplicantID($id) {
        $details_applicant = Applicant::findBySql("SELECT * FROM applicant INNER JOIN user ON user.user_id=applicant.user_id INNER JOIN application ON application.applicant_id=applicant.applicant_id INNER JOIN programme ON programme.programme_id=application.programme_id INNER JOIN ward ON ward.ward_id=applicant.place_of_birth "
                        . "WHERE  applicant.applicant_id='$id' ORDER BY applicant.applicant_id DESC")->one();
		if(count($details_applicant)>0){
		$applicant_idR = $details_applicant;
		}else{
		$applicant_idR=0;
		}
        return $applicant_idR;
    }
	public function getApplicantLearningInstitution($applicantID) {
        $details_application = Application::findBySql("SELECT * FROM application INNER JOIN  programme ON programme.programme_id=application.programme_id  "
                        . "WHERE application.applicant_id='$applicantID' ORDER BY application.applicant_id DESC")->one();
		if(count($details_application)>0){
		$institutionDetail = $details_application;
		}else{
		$institutionDetail=0;
		}
        return $institutionDetail;
    }
	public function getUserIDFromEmployer($employerID){
      $results=Employer::find()->where(['employer_id'=>$employerID])->one();
	  if(count($results) > 0){
	  $userID=$results;
	  }else{
	  $userID=0;
	  }
	return $userID;	
 }
	public function updateUserVerifyEmail($user_id){
        User::updateAll(['email_verified' =>'1'], 'user_id ="'.$user_id.'"');
 }
 public function updateUserActivateAccount($user_id){
        User::updateAll(['status' =>10,'activation_email_sent' =>1], 'user_id ="'.$user_id.'"');
 }
 public function getUserDetailsFromUserID($userID){
      $results_user=User::find()->where(['user_id'=>$userID])->one();
	  if(count($results_user) > 0){
	  $userID=$results_user;
	  }else{
	  $userID=0;
	  }
	return $userID;	
 }
 
 public function getUserDetailsGeneral($username){
      $userDetails = User::findBySql("SELECT * FROM user "
                        . "WHERE user.email_address='$username' OR user.username='$username'")->one();
		if(count($userDetails)>0){
		$results = $userDetails;
		}else{
		$results=0;
		}		
		if($results==0){
		
		$userDetailsApplicant = Applicant::findBySql("SELECT * FROM applicant "
                        . "WHERE f4indexno='$username'")->one();
		if(count($userDetailsApplicant)>0){
		$results_userID = $userDetailsApplicant->user_id;
		$userDetailsApplicant2 = User::findBySql("SELECT * FROM user "
                        . "WHERE user_id='$results_userID'")->one();
						if(count($userDetailsApplicant2)>0){
						$results_final=$userDetailsApplicant2;
						}else{
						$results_final=0;
						}
		}else{
		$results_final=0;
		}
		return $results_final;
		}else{
		return $results;
		}
		
		
 }
    public function updateEmployerVerifiedEmail($employerID,$verification_status){
        Employer::updateAll(['verification_status' =>$verification_status], 'employer_id ="'.$employerID.'"');
 }
    public function updateBeneficiaryVerifiedEmail($loan_beneficiary_id,$verification_status){
        LoanBeneficiary::updateAll(['email_verified' =>$verification_status], 'loan_beneficiary_id="'.$loan_beneficiary_id.'"');
 }
    public function getBeneficiaryDetails($loan_beneficiary_id){
        $resultsBeneficiary=LoanBeneficiary::findBySql("SELECT * FROM loan_beneficiary "
                        . "WHERE loan_beneficiary_id='$loan_beneficiary_id'")->one();
						if(count($resultsBeneficiary)>0){
						$results_final=$resultsBeneficiary;
						}else{
						$results_final=0;
						}
	return $results_final;					
 }
    public function updateUserBasicInfo3($username,$password,$auth_key,$user_id){
        User::updateAll(['username' =>$username,'password_hash' =>$password,'auth_key' =>$auth_key,'status'=>'10' ], 'user_id ="'.$user_id.'"');
 }
    public function deactivateUser($user_id,$statusD,$updatedBy){
	    $updatedAt=date("Y-m-d H:i:s");
        User::updateAll(['status'=>$statusD,'updated_at'=>$updatedAt,'updated_by'=>$updatedBy ], 'user_id ="'.$user_id.'"');
 }
    public function findApplicant($id)
    {
        if (($model = Applicant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	public static function getAcademicYearTrend($applicant_id){
	$academicYearTrend=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id',disbursement.status_date AS 'status_date' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.status='8' AND  disbursement_batch.is_approved='1' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement_batch.academic_year_id ASC")->all();
	return $academicYearTrend;					
	}
	public static function getLoanItemsProvided($applicant_id){
	$resultLoanItems=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND (disbursement.status='8' OR disbursement.status='10') GROUP BY disbursement.loan_item_id ORDER BY disbursement.loan_item_id ASC")->all();
	
	return $resultLoanItems;
	}
	
	public static function getAmountPerLoanItemsProvided($applicant_id,$loanItem,$academic_yearID){
	$amountPerLoanItemProvided=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.loan_item_id='$loanItem' AND  disbursement_batch.academic_year_id='$academic_yearID' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_batch_id ASC")->one();
	
	return $amountPerLoanItemProvided;
	}
	public static function getAmountSubtotal($applicant_id){
	$amountSubTotal=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND (disbursement.status='5' OR disbursement.status='2') GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->all();
	return $amountSubTotal;					
	}
	public static function getLoanItemsReturned($applicant_id){
	$loanItemReturns =\backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.status='10' AND disbursement_batch.is_approved='1' GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->all();
	return $loanItemReturns;					
	}
	public static function getLoanItemsAmountReturned($applicant_id,$returnedItem,$academic_yearIDQ){
	$amount1Return =\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.loan_item_id='$returnedItem' AND disbursement.status='10' AND disbursement_batch.academic_year_id='$academic_yearIDQ' AND disbursement_batch.is_approved='1' GROUP BY disbursement_batch.academic_year_id  ORDER BY disbursement.disbursement_batch_id ASC")->one();
	return $amount1Return;					
	}
	public static function getAmountSubtotalReturned($applicant_id,$academic_yearIDQR){
	$amountSubTotalReturned=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_Batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.status='10' AND disbursement_batch.academic_year_id='$academic_yearIDQR' GROUP BY disbursement_batch.academic_year_id AND disbursement_batch.is_approved='1' ORDER BY disbursement.disbursement_id ASC")->one();
	return $amountSubTotalReturned;					
	}
	public static function getAmountSubtotalPerAccademicY($applicant_id,$academic_yearIDQR){
	$amountSubTotalPerAcDemic=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND (disbursement.status='8' OR disbursement.status='10') AND disbursement_batch.academic_year_id='$academic_yearIDQR' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->one();
	return $amountSubTotalPerAcDemic;					
	}
	public static function getSubTotalAfterReturn($applicant_id,$academic_yearIDQR){
	$subtotalOriginal=LoanBeneficiary::getAmountSubtotalPerAccademicY($applicant_id,$academic_yearIDQR);
	$returned=LoanBeneficiary::getAmountSubtotalReturned($applicant_id,$academic_yearIDQR);
	$amountsub=$subtotalOriginal->disbursed_amount-$returned->disbursed_amount;
	return $amountsub;	
	}
	public static function getFooterInfosCustomerStatement(){
	return "telesphory";
	}
	public static function checkForReturnForLoanee($applicant_id){
	$loanItemReturnedCheck =\backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.status='10' AND disbursement_batch.is_approved='1' GROUP BY disbursement.loan_item_id  ORDER BY disbursement.loan_item_id ASC")->all();
	if(count($loanItemReturnedCheck)>0){
	$results=1;
	}else{
	$results=0;
	}
	return $results;
	}
	public static function getAmountSubtotalPerAccademicYNoReturned($applicant_id,$academic_yearIDQR){
		$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
	$amountSubTotalPerAcDemicNoReturned=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.status='8' AND disbursement_batch.academic_year_id='$academic_yearIDQR' AND disbursement.application_id IN($allApplications) AND  disbursement_batch.is_approved='1' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement.disbursement_id ASC")->one();
	return $amountSubTotalPerAcDemicNoReturned;					
	}
	public static function getAcademicYear($applicant_id,$filter){
	$academicYearTrend=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.loan_item_id AS 'loan_item_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN loan_item ON loan_item.loan_item_id=disbursement.loan_item_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' GROUP BY disbursement_batch.academic_year_id ORDER BY disbursement_batch.academic_year_id $filter")->one();
	return $academicYearTrend;					
	}
	public static function getTotalLoanNoReturn($applicant_id,$loanRepaymentItemRate){
		$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
	$totalLoanNoreturn=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM('$loanRepaymentItemRate'*disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id "
                        . "  WHERE disbursement.application_id IN($allApplications) AND disbursement.status='8' AND disbursement_batch.is_approved='1'")->one();
	return $totalLoanNoreturn;					
	}
	public static function getPrincipleNoReturn($applicant_id){
		$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
	$principalNoreturn=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.application_id IN($allApplications) AND disbursement.status='8' AND disbursement_batch.is_approved='1'")->one();
	return $principalNoreturn;					
	}
	public static function getPrinciplePlusReturn($applicant_id){
	$principalPlusreturn=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND (disbursement.status='8' OR disbursement.status='10')")->one();
	return $principalPlusreturn->disbursed_amount;					
	}
	
	public static function getAmountReturned($applicant_id){
	$amountSubTotalReturned=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT SUM(disbursed_amount) AS 'disbursed_amount', disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE application.applicant_id='$applicant_id' AND disbursement.status='10' AND disbursement_batch.is_approved='1' ORDER BY disbursement.disbursement_id ASC")->one();
	return $amountSubTotalReturned->disbursed_amount;					
	}
        
        public static function getNewLoanSummaryAfterDeceasedBeneficiary($LoanSummaryID, $employerID){
            $LoanSummaryModel = new \frontend\modules\repayment\models\LoanSummary();
	    $LoanSummaryModel->ceaseBillIfEmployedBeneficiaryDisabled($LoanSummaryID, $employerID);
                        // start generating loan summary  getTotalLoanInBillAfterDecease
                        $totalAcculatedLoan = \backend\modules\repayment\models\EmployedBeneficiary::getTotalLoanInBillAfterDecease($employerID);
                        $resultsEmployer = \backend\modules\repayment\models\LoanSummary::getEmployerDetails($employerID);
                        $billNumber = $resultsEmployer->employer_code . "-" . date("Y") . "-" . \backend\modules\repayment\models\LoanSummary::getLastBillID($employerID);
                        $status = 0;
                        $description = "Due to Value Retention Fee(VRF) which is charged daily, the total loan amount will be changing accordingly.";
                        $created_by = Yii::$app->user->identity->user_id;
                        $created_at = date("Y-m-d H:i:s");
                        $vrf_accumulated = 0.00;
                        $vrf_last_date_calculated = $created_at;
                        \backend\modules\repayment\models\LoanSummary::insertNewValuesAfterTermination($employerID, $totalAcculatedLoan, $billNumber, $status, $description, $created_by, $created_at, $vrf_accumulated, $vrf_last_date_calculated);
                        $New_loan_summary_id = \backend\modules\repayment\models\LoanSummary::getLastLoanSummaryID($employerID);
                        \backend\modules\repayment\models\LoanSummaryDetail::insertAllBeneficiariesUnderBillAfterDeceased($employerID, $New_loan_summary_id);
                        \backend\modules\repayment\models\LoanSummary::updateCeasedBill($employerID);
                        \backend\modules\repayment\models\EmployedBeneficiary::updateAll(['loan_summary_id' =>$New_loan_summary_id], 'employer_id="'.$employerID.'" AND verification_status=1 AND employment_status="ONPOST"');
                        //here end generate new loan summary
                        return true;
	}
	public static function getAllApplicantApplications($applicantID){
		$resultsAllocation=\frontend\modules\application\models\Application::findBySql("SELECT GROUP_CONCAT(application_id) as application_id FROM application WHERE  applicant_id='{$applicantID}'")->asArray()->one();
        $valuesXcF=$resultsAllocation['application_id'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	
		}else{
			$valuesXcF=-1;
		}
		return $valuesXcF;
	}
	public static function getGraduationDate($applicantID){
		$results=\frontend\modules\application\models\Application::findBySql("SELECT date_graduated  FROM application WHERE  applicant_id='{$applicantID}' AND student_status<>'ONSTUDY' ORDER BY application_id DESC")->asArray()->one();
        $valuesXcF=$results['date_graduated'];
		if($valuesXcF !=''){
		$valuesXcF=$valuesXcF;	
		}else{
			$valuesXcF=0;
		}
		return $valuesXcF;
	}
	public static function getAllProgrammeStudied($applicant_id){
		$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
	$programmesResults=\frontend\modules\application\models\Application::findBySql("SELECT GROUP_CONCAT(DISTINCT(programme.programme_code)) as 'programme_name',GROUP_CONCAT(DISTINCT(learning_institution.institution_code)) as 'institution_code' FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN application ON application.application_id=disbursement.application_id INNER JOIN programme ON programme.programme_id=disbursement.programme_id INNER JOIN learning_institution ON learning_institution.learning_institution_id=programme.learning_institution_id"
                        . " WHERE disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id AND disbursement.application_id IN($allApplications) AND  application.applicant_id=:applicant_id",[':applicant_id'=>$applicant_id])->one();
	return $programmesResults;					
	}
        public static function getAmountNoReturned($applicant_id){
		$allApplications=\common\models\LoanBeneficiary::getAllApplicantApplications($applicant_id);
	$amountNoReturned=\backend\modules\disbursement\models\Disbursement::findBySql("SELECT disbursed_amount, disbursement_batch.academic_year_id AS 'academic_year_id',disbursement.disbursement_batch_id AS 'disbursement_batch_id',disbursement.status_date,academic_year.end_date FROM disbursement INNER JOIN  disbursement_batch ON disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id INNER JOIN academic_year ON academic_year.academic_year_id=disbursement_batch.academic_year_id INNER JOIN application ON application.application_id=disbursement.application_id"
                        . "  WHERE disbursement.disbursement_batch_id=disbursement_batch.disbursement_batch_id AND disbursement.status='8' AND disbursement.application_id IN($allApplications) AND  disbursement_batch.is_approved='1' ORDER BY disbursement.disbursement_id ASC")->all();
	return $amountNoReturned;					
	}
        
        public static function getVrFBeforeRepayment($disbusementDate){
            //check bound
            $details_VRF = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT * FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id AND loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1' AND (loan_repayment_setting.end_date IS NOT NULL OR loan_repayment_setting.end_date !='') AND loan_repayment_setting.formula_stage='1'")->all();
            //end check for bound
            if(count($details_VRF) > 0){
                //get bound date
             $boundDate = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.end_date,loan_repayment_setting.loan_repayment_setting_id FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id AND loan_repayment_item.item_code='VRF' AND (loan_repayment_setting.end_date IS NOT NULL OR loan_repayment_setting.end_date !='') AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one();  
             $endDate=$boundDate->end_date;
             $Bound_loan_repayment_setting_id=$boundDate->loan_repayment_setting_id;
             //check bound end date formula_stage_level
             if($endDate >=$disbusementDate){
             $vrfApplicableFormula = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id',loan_repayment_setting.formula_stage_level,loan_repayment_setting.formula_stage_level_condition,loan_repayment_setting.grace_period  FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.loan_repayment_setting_id='$Bound_loan_repayment_setting_id' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one();            
            }else{
            $vrfApplicableFormula = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id',loan_repayment_setting.formula_stage_level,loan_repayment_setting.formula_stage_level_condition,loan_repayment_setting.grace_period  FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_item.item_code='VRF' AND loan_repayment_setting.loan_repayment_setting_id<>'$Bound_loan_repayment_setting_id'  AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one();    
            }
             //end check bound end date formula_stage_level
             
            }else{
             $vrfApplicableFormula = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT loan_repayment_setting.rate*0.01 AS 'rate',loan_repayment_setting.calculation_mode AS 'calculation_mode',loan_repayment_setting.loan_repayment_item_id AS 'loan_repayment_item_id',loan_repayment_setting.formula_stage_level,loan_repayment_setting.formula_stage_level_condition,loan_repayment_setting.grace_period  FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id AND loan_repayment_item.item_code='VRF' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='1'")->one(); 
            }		
    return $vrfApplicableFormula;					
	}
	 
}
