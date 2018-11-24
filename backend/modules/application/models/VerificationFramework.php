<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_framework".
 *
 * @property integer $verification_framework_id
 * @property string $verification_framework_title
 * @property string $verification_framework_desc
 * @property integer $verification_framework_stage
 * @property string $created_at
 * @property integer $created_by
 * @property integer $confirmed_by
 * @property string $confirmed_at
 * @property integer $is_active
 *
 * @property VerificationFrameworkItem[] $verificationFrameworkItems
 */
class VerificationFramework extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_CLOSED = 2;
const VERIFICATION_COMMENT_NOT_VISIBLE = "NOT VISIBLE";
const VERIFICATION_COMMENT_BAD_QUALITY = "BAD QUALITY";
const VERIFICATION_COMMENT_INVALID_ATTACHMENT = "INVALID ATTACHMENT";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_framework';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_framework_title','category'], 'required'],
            [['verification_framework_stage', 'created_by', 'confirmed_by', 'is_active'], 'integer'],
            [['verification_framework_title'],'validateVerificationFrameworkActive','on'=>'addNewFramework'],
            [['verification_framework_title'],'validateVerificationFrameworkNotConfirmed','on'=>'addNewFramework'],
            [['created_at', 'confirmed_at'], 'safe'],
            [['verification_framework_title'], 'string', 'max' => 100],
            [['verification_framework_desc'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_framework_id' => 'Verification Framework ID',
            'verification_framework_title' => 'Title',
            'verification_framework_desc' => 'Description',
            'verification_framework_stage' => 'Confirmed',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'confirmed_by' => 'Confirmed By',
            'confirmed_at' => 'Confirmed At',
            'is_active' => 'Is Active',
            'category'=>'Study Level',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerificationFrameworkItems()
    {
        return $this->hasMany(VerificationFrameworkItem::className(), ['verification_framework_id' => 'verification_framework_id']);
    }


public function getCategory0()
    {
        return $this->hasOne(ApplicantCategory::className(), ['applicant_category_id' => 'category']);
    }


    function hasApplication() {
        if (Application::find()->where(['verification_framework_id' => $this->verification_framework_id])->exists()) {
            return TRUE;
        }
        return FALSE;
    }
/*
    public function validateVerificationFrameworkActive($attribute) {
        
            if (self::find()->where('is_active=:is_active', [':is_active' => 1])
                            ->exists()) {
                $this->addError($attribute,' Active verification framework already exists');
                return FALSE;
            }
        
        return true;
    }
*/

public function validateVerificationFrameworkActive($attribute) {
          if ($attribute && $this->verification_framework_title && $this->category) {
            if (self::find()->where('is_active=:is_active AND category=:category', [':is_active' => 1,':category'=>$this->category])
                            ->exists()) {
                $this->addError($attribute,' Active verification framework already exists');
                return FALSE;
            }
          }
        return true;
    }


    function hasVerificationItem(){
     if (VerificationFrameworkItem::find()->where(['verification_framework_id' => $this->verification_framework_id])->exists()) {
            return TRUE;
        }
        return FALSE;
    }
/*
    public function validateVerificationFrameworkNotConfirmed($attribute) {
        
            if (self::find()->where('is_active=:is_active AND verification_framework_stage=:verification_framework_stage', [':is_active' =>0,':verification_framework_stage'=>0])
                            ->exists()) {
                $this->addError($attribute,' Verification framework already exists');
                return FALSE;
            }
        
        return true;
    }
*/

public function validateVerificationFrameworkNotConfirmed($attribute) {
           if ($attribute && $this->verification_framework_title && $this->category) {
            if (self::find()->where('is_active=:is_active AND verification_framework_stage=:verification_framework_stage AND category=:category', [':is_active' =>0,':verification_framework_stage'=>0,':category'=>$this->category])
                            ->exists()) {
                $this->addError($attribute,' Verification framework already exists');
                return FALSE;
            }
           }
        return true;
    }

/*
public static function getActiveFramework(){
        $results= VerificationFramework::find()->where(['is_active'=>1])->one();
        return $results;
    }
*/

public static function getActiveFramework($applicantCategory){
        $results= VerificationFramework::find()->where(['is_active'=>1,'category'=>$applicantCategory])->one();
        return $results;
    }

public static function getGeneralSystemStatus($applicationID,$applicantID,$verification_framework_id,$applicant_category_id){
       $results=\backend\modules\application\models\VerificationCustomCriteria::getActiveCustomerCriteria($verification_framework_id,$applicant_category_id); 
				 $i=0;
				 $generalCriteriaValue=1;
                                 if(count($results > 0)){
				 foreach($results AS $values){
                   $tableName=$values->applicant_source_table; $tableColumn=$values->applicant_souce_column; $tableColumnValue=$values->applicant_source_value;$operator=$values->operator;$applicationID=$applicationID;$applicantID=$applicantID;$level=$values->level;
                   if($tableName=='applicant'){
                  $resultsFinal=\backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteria2($tableName,$tableColumn,$tableColumnValue,$operator,$applicantID);   
                  }else if($tableName=='education'){
                  $resultsFinal=\backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteriaEducation($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID,$level);
                  }else{
                  $resultsFinal=\backend\modules\application\models\VerificationCustomCriteria::getCustomerCriteria($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID);   
                  }    
                        if($resultsFinal==0){
                           $generalCriteriaValue=0; 
                        }
                 ++$i;
                    $results_check_criteria_general =$generalCriteriaValue;				 
                 }
}
                 if($i > 0 && $results_check_criteria_general==0){
                     //failled
                    $verification_criteria_status=0;					
				 }else if($i > 0 && $results_check_criteria_general==1){
                    //success                 
                    $verification_criteria_status=1;
                                 }else{
                    //NO FRAMEWORK AVAILABLE                 
                    $verification_criteria_status=1;                 
                                 }
    return  $verification_criteria_status;                         
    } 
public static function getGeneralSystemStatusMandatoryAttachments($applicationID,$verification_framework_id,$applicant_category_id){
       $results=\backend\modules\application\models\VerificationFrameworkItem::getAllMandatoryAttachments($verification_framework_id,$applicant_category_id); 
				 $i=0;
				 $generalCriteriaValue=1;
                                 if(count($results) > 0){
				 foreach($results AS $values){
                   $attachment_definition_id=$values->attachment_definition_id;                   
                   $resultsPath=\backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($attachment_definition_id,$applicationID);
                   /*
    if($resultsPath->attachment_path !='' && $resultsPath->attachment_path != "applicant_attachment/profile/verification_missing_image.jpg"){
                $resultsFinal=1;       
                   }else{
                  $resultsFinal=0;     
                   }
                    * 
                    */
        $file_name = '../'.$resultsPath->attachment_path;
        $file_contents  = @file_get_contents($file_name);
        if($resultsPath->attachment_path != "applicant_attachment/profile/verification_missing_image.jpg"){
       if($file_contents != NULL){
          $resultsFinal=1;  
       }else{
          $resultsFinal=0; 
       }
        }else{
          $resultsFinal=0;   
        }           
                        if($resultsFinal==0){
                           $generalCriteriaValue=0; 
                        }
                 ++$i;
                    $results_check_criteria_general =$generalCriteriaValue;				 
                 }
                 if($i > 0 && $results_check_criteria_general==0){
                     //failled
                    $verification_criteria_status=0;					
				 }else if($i > 0 && $results_check_criteria_general==1){
                    //success                 
                    $verification_criteria_status=1;
                                 }else{
                    //NO FRAMEWORK AVAILABLE                 
                    $verification_criteria_status=0;                 
                                 }
                                 }
    return  $verification_criteria_status;                         
    }

static function getVerificationComments() {
        return array(
            self::VERIFICATION_COMMENT_NOT_VISIBLE => "NOT VISIBLE",
            self::VERIFICATION_COMMENT_BAD_QUALITY => "BAD QUALITY",
            self::VERIFICATION_COMMENT_INVALID_ATTACHMENT => "INVALID ATTACHMENT",
        );
    }

}
