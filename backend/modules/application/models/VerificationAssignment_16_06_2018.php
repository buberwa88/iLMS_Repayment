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
    public function rules()
    {
        return [
            [['assignee', 'total_applications', 'assigned_by', 'created_at'], 'required'],
            [['assignee', 'study_level', 'total_applications', 'assigned_by'], 'integer'],
            [['created_at','Bachelor','Masters','Diploma','Postgraduate_Diploma','PhD'], 'safe'],
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
        $applicationDetails = Application::findBySql("SELECT * FROM application WHERE  (assignee ='' OR assignee IS NULL) $applicant_category_id ORDER BY application_id ASC LIMIT $totalApplications")->all();
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
                    where assignee IS NULL OR assignee=''")->one();
        return $applicationDetails;
        }    
}
