<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "gvt_employee".
 *
 * @property integer $gvt_employee
 * @property string $vote_number
 * @property string $vote_name
 * @property string $Sub_vote
 * @property string $sub_vote_name
 * @property string $check_number
 * @property string $f4indexno
 * @property string $first_name
 * @property string $middle_name
 * @property string $surname
 * @property string $sex
 * @property string $NIN
 * @property string $employment_date
 * @property string $created_at
 * @property string $payment_date
 */
class GvtEmployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gvt_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employment_date', 'created_at', 'payment_date','applicant_id','applicant_date_checked','action_taken','action_taken_date','action_taken_by','checked_status','checked_at','matching'], 'safe'],
            [['vote_number', 'Sub_vote', 'check_number'], 'string', 'max' => 50],
            [['vote_name', 'sub_vote_name', 'first_name', 'middle_name', 'surname', 'NIN'], 'string', 'max' => 100],
            [['f4indexno'], 'string', 'max' => 20],
            [['sex'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gvt_employee_id' => 'Gvt Employee',
            'vote_number' => 'Vote Number',
            'vote_name' => 'Vote Name',
            'Sub_vote' => 'Sub Vote',
            'sub_vote_name' => 'Sub Vote Name',
            'check_number' => 'Check Number',
            'f4indexno' => 'F4indexno',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'NIN' => 'Nin',
            'employment_date' => 'Employment Date',
            'created_at' => 'Created At',
            'payment_date' => 'Payment Date',
			'applicant_id'=>'applicant_id',
			'applicant_date_checked'=>'applicant_date_checked',
			'action_taken'=>'action_taken',
			'action_taken_date'=>'action_taken_date',
			'action_taken_by'=>'action_taken_by',
			'checked_status'=>'checked_status',
			'checked_at'=>'checked_at',
			'matching'=>'matching',
        ];
    }
public static function insertGSPPallEmployeesMonthly($CheckDate,$CheckNumber,$DateHired,$DeductionAmount,$DeductionCode,$DeductionDesc,$DeptName,$FirstName,$MiddleName,$LastName,$NationalId,$Sex,$VoteName,$Votecode,$created_at){
	if(self::find()->where(['payment_date'=>$CheckDate,'check_number'=>$CheckNumber])->count()==0){	
Yii::$app->db->createCommand("INSERT IGNORE INTO gvt_employee(vote_number,vote_name,Sub_vote,sub_vote_name, 	check_number,first_name,middle_name,surname,sex,NIN,employment_date,created_at,payment_date) VALUES('$Votecode','$VoteName','$Deptcode','$DeptName','$CheckNumber','$FirstName','$MiddleName','$LastName','$Sex','$NationalId','$DateHired','$created_at','$CheckDate')")->execute();	
}
}
public static function checkBeneficiaryFromGSPPemployees(){
$results=self::findBySql("SELECT gvt_employee_id,first_name,middle_name,surname,NIN,sex FROM gvt_employee WHERE  checked_status='0' ORDER BY gvt_employee_id ASC")->all();
$i=0;
foreach($results as $employeeDetail){
	$matching='Matching=>';
	$first_name=$employeeDetail->first_name;
	$middle_name=$employeeDetail->middle_name;
	$surname=$employeeDetail->surname;
	$NIN=$employeeDetail->NIN;
	$sex=$employeeDetail->sex;
	$gvt_employee_id=$employeeDetail->gvt_employee_id;
	$applicant_date_found=date("Y-m-d H:i:s");
	$applicant_id=\frontend\modules\repayment\models\EmployedBeneficiary::getCheckApplicantNamesMatchGeneral($first_name, $middle_name, $surname,$NIN)->applicant_id;
	//echo $applicant_id;exit;
	if($applicant_id !=''){
		if($NIN !=''){
	$matchingByNINCount=\frontend\modules\repayment\models\EmployedBeneficiary::getCheckApplicantNamesMatchByNIN($NIN);
	}
	$matchingCount=$matchingByNINCount;
	if($matchingByNINCount==0){
	$matchingCount=\frontend\modules\repayment\models\EmployedBeneficiary::getCheckApplicantNamesMatchGSPP($first_name, $middle_name, $surname);	
	}
	$matching .=$matchingCount;
  self::updateAll(['applicant_id'=>$applicant_id,'applicant_date_checked'=>$applicant_date_found,'checked_status'=>1,'matching'=>$matching], 'gvt_employee_id="'.$gvt_employee_id.'"'); 
	}else{
	self::updateAll(['applicant_date_checked'=>$applicant_date_found,'checked_status'=>1], 'gvt_employee_id="'.$gvt_employee_id.'"');	
	}
	++$i;
}	
	}
}
