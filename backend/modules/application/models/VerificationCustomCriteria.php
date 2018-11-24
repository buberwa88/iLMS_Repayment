<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_custom_criteria".
 *
 * @property integer $verification_custom_criteria_id
 * @property integer $verification_framework_id
 * @property string $criteria_name
 * @property string $applicant_source_table
 * @property string $applicant_souce_column
 * @property string $applicant_source_value
 * @property string $operator
 * @property integer $created_by
 * @property string $created_at
 *
 * @property User $createdBy
 * @property VerificationFramework $verificationFramework
 */
class VerificationCustomCriteria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_custom_criteria';
    }
    public $column_value1;
    public $column_value2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_framework_id', 'criteria_name', 'applicant_source_table', 'applicant_souce_column', 'applicant_source_value', 'created_by', 'created_at','operator'], 'required','on'=>'creating_custom_criteria_tab1'],
            [['verification_framework_id', 'criteria_name', 'applicant_source_table', 'applicant_souce_column', 'applicant_source_value', 'created_by', 'created_at','operator','level'], 'required','on'=>'creating_custom_criteria_tab2'],
            [['verification_framework_id', 'created_by'], 'integer'],
            [['applicant_souce_column'],'validateCustomerCriteriaItems','on'=>'creating_custom_criteria_tab1'],
            [['applicant_souce_column'],'validateCustomerCriteriaItemsLevel','on'=>'creating_custom_criteria_tab2'],
            [['created_at','level','is_active','column_value1','column_value2'], 'safe'],
            [['criteria_name'], 'string', 'max' => 100],
            [['applicant_source_table', 'applicant_souce_column', 'applicant_source_value'], 'string', 'max' => 50],
            [['operator'], 'string', 'max' => 2],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['verification_framework_id'], 'exist', 'skipOnError' => true, 'targetClass' => VerificationFramework::className(), 'targetAttribute' => ['verification_framework_id' => 'verification_framework_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_custom_criteria_id' => 'Verification Custom Criteria ID',
            'verification_framework_id' => 'Verification Framework ID',
            'criteria_name' => 'Criteria Name',
            'applicant_source_table' => 'Applicant Source Table',
            'applicant_souce_column' => 'Applicant Souce Column',
            'applicant_source_value' => 'Applicant Source Value',
            'operator' => 'Operator',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'level'=>'Education Level',
            'column_value1'=>'Columns Value',
	    'column_value2'=>'Columns Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerificationFramework()
    {
        return $this->hasOne(VerificationFramework::className(), ['verification_framework_id' => 'verification_framework_id']);
    }
    static function getVerificationCustomCriteriaById($id){
          return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where('verification_framework_id=:id AND level=:level',[':id' => $id,'level'=>'NONE']),
        ]);
    }
    static function getVerificationCustomCriteriaById2($id){
          return new \yii\data\ActiveDataProvider([
            'query' => self::find()
                             ->andWhere('verification_framework_id=:id',[':id' => $id])
                             ->andWhere(['not',['level' => 'NONE'],])
        ]);
    }
    public static function getActiveCustomerCriteria($verificationFrameworkID,$applicantCategory){
      if($verificationFrameworkID==''){
        $verificationF=\backend\modules\application\models\VerificationFramework::getActiveFramework($applicantCategory);
        $verificationFrameworkID1=$verificationF->verification_framework_id;  
      }else{
        $verificationFrameworkID1=$verificationFrameworkID;  
      }  
    $verificationCustmDetails = VerificationCustomCriteria::find()->joinWith('verificationFramework')->where(['verification_framework.verification_framework_id' =>$verificationFrameworkID1,'verification_custom_criteria.is_active'=>1])->all();
      return $verificationCustmDetails;
    }
    public static function getCustomerCriteria($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID){
        $tableColumnValue2="'$tableColumnValue'";
        $operator1=" ".$operator." ";
        $applicationDetails = Application::findBySql("SELECT $tableName.$tableColumn FROM application INNER JOIN $tableName ON $tableName.application_id=application.application_id WHERE $tableName.$tableColumn$operator1$tableColumnValue2 AND application.application_id='$applicationID'")->one();
        if(count($applicationDetails)>0){
         return 1;   
        }else{
         return 0;   
        }
    }
    public static function getCustomerCriteriaEducation($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID,$level){
        $tableColumnValue2="'$tableColumnValue'";
        $operator1=" ".$operator." ";
        $applicationDetails = Application::findBySql("SELECT $tableName.$tableColumn FROM application INNER JOIN $tableName ON $tableName.application_id=application.application_id WHERE $tableName.$tableColumn$operator1$tableColumnValue2 AND application.application_id='$applicationID' AND $tableName.level='$level'")->one();
        if(count($applicationDetails)>0){
         return 1;   
        }else{
         return 0;   
        }
    }
    public static function getCustomerCriteria2($tableName,$tableColumn,$tableColumnValue,$operator,$applicantID){ 
        $tableColumnValue2="'$tableColumnValue'";
        $operator1=" ".$operator." ";
        $applicationDetails = Application::findBySql("SELECT $tableName.$tableColumn FROM application INNER JOIN $tableName ON $tableName.applicant_id=application.applicant_id WHERE $tableName.$tableColumn$operator1$tableColumnValue2 AND application.applicant_id='$applicantID'")->one();
        if(count($applicationDetails)>0){
         return 1;   
        }else{
         return 0;   
        }
    }
    public static function getCustomerCriteriaFound($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID){
        $tableColumnValue2="'$tableColumnValue'";
        $operator1=" ".$operator." ";
        $applicationDetails = Application::findBySql("SELECT $tableName.$tableColumn AS 'criteraValue' FROM application INNER JOIN $tableName ON $tableName.application_id=application.application_id WHERE $tableName.$tableColumn$operator1$tableColumnValue2 AND application.application_id='$applicationID'")->one();
        if(count($applicationDetails)>0){
         return $applicationDetails->criteraValue;   
        }else{
         return '';   
        }
    }
    public static function getCustomerCriteriaFoundEducation($tableName,$tableColumn,$tableColumnValue,$operator,$applicationID,$level){
        $tableColumnValue2="'$tableColumnValue'";
        $operator1=" ".$operator." ";
        $applicationDetails = Application::findBySql("SELECT $tableName.$tableColumn AS 'criteraValue' FROM application INNER JOIN $tableName ON $tableName.application_id=application.application_id WHERE $tableName.$tableColumn$operator1$tableColumnValue2 AND application.application_id='$applicationID' AND $tableName.level='$level'")->one();
        if(count($applicationDetails)>0){
         return $applicationDetails->criteraValue;   
        }else{
         return '';   
        }
    }
    public static function getCustomerCriteria2Found($tableName,$tableColumn,$tableColumnValue,$operator,$applicantID,$applicationID){ 
        $tableColumnValue2="'$tableColumnValue'";
        $operator1=" ".$operator." ";
        $applicationDetails = Application::findBySql("SELECT $tableName.$tableColumn AS 'criteraValue' FROM application INNER JOIN $tableName ON $tableName.applicant_id=application.applicant_id WHERE application.application_id='$applicationID' AND application.applicant_id='$applicantID'")->one();
        if(count($applicationDetails)>0){
         return $applicationDetails->criteraValue;   
        }else{
         return '';   
        }
    }
    public function validateCustomerCriteriaItems($attribute) {
        if ($attribute && $this->verification_framework_id && $this->applicant_source_table && $this->applicant_souce_column) {
            if (self::find()->where('verification_framework_id=:verification_framework_id AND applicant_source_table=:applicant_source_table AND applicant_souce_column=:applicant_souce_column AND is_active=:is_active', [':verification_framework_id' => $this->verification_framework_id,':applicant_source_table'=>$this->applicant_source_table,':applicant_souce_column'=>$this->applicant_souce_column,':is_active'=>1])
                            ->exists()) {
                $this->addError($attribute,' Verification item already exists');
                return FALSE;
            }
        }
        return true;
    }
    public function validateCustomerCriteriaItemsLevel($attribute) {
        if ($attribute && $this->verification_framework_id && $this->applicant_source_table && $this->applicant_souce_column  && $this->level) {
            if (self::find()->where('verification_framework_id=:verification_framework_id AND applicant_source_table=:applicant_source_table AND applicant_souce_column=:applicant_souce_column AND level=:level AND is_active=:is_active', [':verification_framework_id' => $this->verification_framework_id,':applicant_source_table'=>$this->applicant_source_table,':applicant_souce_column'=>$this->applicant_souce_column,':level'=>$this->level,':is_active'=>1])
                            ->exists()) {
                $this->addError($attribute,' Verification item already exists');
                return FALSE;
            }
        }
        return true;
    }
    public static function getFramework($verificationFramework,$applicantCategory){
        if($verificationFramework==''){
        $verificationF=\backend\modules\application\models\VerificationFramework::getActiveFramework($applicantCategory);
        $verificationFrameworkID1=$verificationF->verification_framework_id;  
      }else{
        $verificationFrameworkID1=$verificationFramework;  
      }
        $results= VerificationFramework::find()->where(['verification_framework_id'=>$verificationFrameworkID1])->one();
        return $results;
    }
}
