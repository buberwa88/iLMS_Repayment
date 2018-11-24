<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_assignment".
 *
 * @property integer $verification_assignment_id
 * @property integer $assignee
 * @property integer $study_level
 * @property integer $total_applications
 * @property integer $assigned_by
 * @property string $created_at
 *
 * @property User $assignee0
 * @property User $assignedBy
 */
class VerificationAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_UNVERIFIED = 0;
    const STATUS_INCOMPLETE = 2;
    const STATUS_WAITING = 3;
    const STATUS_INVALID = 4;
    const STATUS_PENDING = 5;
    
    
    public static function tableName()
    {
        return 'verification_assignment';
    }

    /**
     * @inheritdoc
     */
    public $Bachelor;
    public $Masters;
    public $Diploma;
    public $Postgraduate_Diploma;
    public $PhD;
    public $application_status;
    public function rules()
    {
        return [
            [['assignee', 'total_applications', 'assigned_by', 'created_at','study_level'], 'required', 'on'=>'create_assignment'],
            [['assignee', 'total_applications', 'assigned_by', 'created_at','application_status'], 'required', 'on'=>'reverse_assignment'],
            [['assignee', 'study_level', 'total_applications', 'assigned_by'], 'integer'],                        
            [['total_applications'],'compare','compareValue'=>'0','operator'=>'>','message'=>'Number of applications must be greater than zero'],
            [['study_level'],'validateNumberofApplicationToAssign', 'on'=>'create_assignment'],
            [['study_level'],'validateNumberofApplicationToReverse', 'on'=>'reverse_assignment'],
            [['created_at','Bachelor','Masters','Diploma','Postgraduate_Diploma','PhD','application_status'], 'safe'],
            [['assignee'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['assignee' => 'user_id']],
            [['assigned_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['assigned_by' => 'user_id']],
            [['study_level'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['study_level' => 'applicant_category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_assignment_id' => 'Verification Assignment ID',
            'assignee' => 'Assignee',
            'study_level' => 'Study Level',
            'total_applications' => 'Total Applications',
            'assigned_by' => 'Assigned By',
            'created_at' => 'Created At',
            'application_status'=>'Applications Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignee0()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'assignee']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'assigned_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudyLevel()
    {
        return $this->hasOne(ApplicantCategory::className(), ['applicant_category_id' => 'study_level']);
    }
    public static function getUnverifiedApplication($applicant_category_id,$totalApplications) {        
        $applicationDetails = Application::findBySql("SELECT * FROM application WHERE loan_application_form_status=3 AND (assignee ='' OR assignee IS NULL) $applicant_category_id ORDER BY application_id ASC LIMIT $totalApplications")->all();
        return $applicationDetails;
    }
    public static function saveNewValueTotal($verification_assignment_id,$totalApplication){
		self::updateAll(['total_applications'=>$totalApplication], 'verification_assignment_id ="'.$verification_assignment_id.'"');
        }
    public static function getTotalApplicationByCategory(){
		$applicationDetails = Application::findBySql("SELECT 
                    COUNT(CASE WHEN applicant_category_id = 1 THEN 1 ELSE NULL END) AS 'Bachelor', 
                    COUNT(CASE WHEN applicant_category_id = 2 THEN 1 ELSE NULL END) AS 'Masters', 
                    COUNT(CASE WHEN applicant_category_id = 3 THEN 1 ELSE NULL END) AS 'Diploma',
                    COUNT(CASE WHEN applicant_category_id = 4 THEN 1 ELSE NULL END) AS 'Postgraduate_Diploma',
                    COUNT(CASE WHEN applicant_category_id = 5 THEN 1 ELSE NULL END) AS 'PhD'	   
                    FROM application
                    where loan_application_form_status=3 AND (assignee IS NULL OR assignee='')")->one();
        return $applicationDetails;
        }
    public function validateTotalApplication($attribute) {
          if($attribute && $this->total_applications){
              if($this->total_applications <= 0){
               $this->addError($attribute,' Incorrect number of applications');
                return FALSE;   
              }
          }       
        return true;
    }
    
    public function validateNumberofApplicationToAssign($attribute) {
        if ($attribute && $this->total_applications && $this->study_level) {
            $totalApplications=$this->total_applications;
            $studyLevel=$this->study_level;
            if($totalApplications >=1){
           $applicationDetails = Application::findBySql("SELECT * FROM application WHERE  loan_application_form_status=3 AND (assignee IS NULL OR assignee='') AND applicant_category_id='$studyLevel' ORDER BY application_id ASC LIMIT $totalApplications")->all();
           if(count($applicationDetails)==0){
                $this->addError($attribute,' Incorrect Study level selected');
                return FALSE;
            }else{                
                return true;
            }
        }else{
         return true;   
        }
        }
        return true;
    }
    public static function getReverseApplicationsBulk($applicant_category_id,$totalApplications,$assignee,$ofStatus) {        
        $applicationDetails = Application::findBySql("SELECT * FROM application WHERE loan_application_form_status=3 AND assignee ='$assignee' AND verification_status='$ofStatus'  $applicant_category_id ORDER BY application_id ASC LIMIT $totalApplications")->all();
        return $applicationDetails;
    }
    static function getApplicationsStatus() {
        return array(
            self::STATUS_UNVERIFIED => 'Unverified',
            self::STATUS_INCOMPLETE => 'Incomplete',
            self::STATUS_WAITING => 'Waiting',
            self::STATUS_INVALID => 'Invalid',
            self::STATUS_PENDING => 'Pending',
        );
    }
    
    public function validateNumberofApplicationToReverse($attribute,$params) {

        if ($attribute && $this->total_applications && $this->assignee) {
            $totalApplications=$this->total_applications;
            $studyLevel=$this->study_level;
            $assignee=$this->assignee;
            $application_status=$this->application_status;
            if($this->study_level){
             $studyLevels=" AND applicant_category_id='" . $studyLevel . "'";   
            }else{
              $studyLevels="";  
            }
            if($totalApplications >=1){                
           $applicationDetails = Application::findBySql("SELECT * FROM application WHERE  loan_application_form_status=3 AND assignee='$assignee'  AND verification_status='$application_status' $studyLevels ORDER BY application_id ASC LIMIT $totalApplications")->all();
           if(count($applicationDetails)==0){
                $this->addError($attribute,' Incorrect Study level selected');
                return FALSE;
            }else{                
                return true;
            }
        }else{
         return true;   
        }
        }
        return true;
    }
public static function getTotalApplicationAttempted($loggedIn,$todate){
		$applicationDetails = Application::findBySql("SELECT 
                    COUNT(application_id) AS 'totalApplication'	   
                    FROM application
                    where loan_application_form_status=3 AND assignee='$loggedIn' AND date_verified like '%$todate%' AND last_verified_by='$loggedIn'")->one();
        return $applicationDetails->totalApplication;
        }
public static function getTotalApplicationNotAttempted($loggedIn,$todate){
		$applicationDetails = Application::findBySql("SELECT 
                    COUNT(application_id) AS 'totalApplication'	   
                    FROM application
                    where loan_application_form_status=3 AND assignee='$loggedIn'  AND (last_verified_by='' OR last_verified_by IS NULL)")->one();
        return $applicationDetails->totalApplication;
        }
     
}
