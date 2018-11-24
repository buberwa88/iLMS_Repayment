<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_custom_criteria_passed".
 *
 * @property integer $verification_custom_criteria_passed_id
 * @property integer $verification_custom_criteria_id
 * @property integer $verification_framework_id
 * @property integer $application_id
 * @property string $criteria_name
 * @property string $applicant_source_table
 * @property string $applicant_souce_column
 * @property string $applicant_source_value
 * @property string $operator
 * @property integer $created_by
 * @property string $created_at
 * @property string $level
 * @property integer $is_active
 * @property string $last_updated_at
 * @property integer $last_updated_by
 *
 * @property User $createdBy
 * @property VerificationCustomCriteria $verificationCustomCriteria
 * @property VerificationFramework $verificationFramework
 * @property Application $application
 */
class VerificationCustomCriteriaPassed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_custom_criteria_passed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_custom_criteria_id', 'verification_framework_id', 'application_id', 'created_by', 'is_active', 'last_updated_by'], 'integer'],
            [['created_at', 'last_updated_at'], 'safe'],
            [['criteria_name', 'level'], 'string', 'max' => 100],
            [['applicant_source_table', 'applicant_souce_column', 'applicant_source_value'], 'string', 'max' => 50],
            [['operator'], 'string', 'max' => 2],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['verification_custom_criteria_id'], 'exist', 'skipOnError' => true, 'targetClass' => VerificationCustomCriteria::className(), 'targetAttribute' => ['verification_custom_criteria_id' => 'verification_custom_criteria_id']],
            [['verification_framework_id'], 'exist', 'skipOnError' => true, 'targetClass' => VerificationFramework::className(), 'targetAttribute' => ['verification_framework_id' => 'verification_framework_id']],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_custom_criteria_passed_id' => 'Verification Custom Criteria Passed ID',
            'verification_custom_criteria_id' => 'Verification Custom Criteria ID',
            'verification_framework_id' => 'Verification Framework ID',
            'application_id' => 'Application ID',
            'criteria_name' => 'Criteria Name',
            'applicant_source_table' => 'Applicant Source Table',
            'applicant_souce_column' => 'Applicant Souce Column',
            'applicant_source_value' => 'Applicant Source Value',
            'operator' => 'Operator',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'level' => 'Level',
            'is_active' => 'Is Active',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
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
    public function getVerificationCustomCriteria()
    {
        return $this->hasOne(VerificationCustomCriteria::className(), ['verification_custom_criteria_id' => 'verification_custom_criteria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVerificationFramework()
    {
        return $this->hasOne(VerificationFramework::className(), ['verification_framework_id' => 'verification_framework_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['application_id' => 'application_id']);
    }
    public static function insertPassedCriteria($verification_custom_criteria_id,$verification_framework_id,$application_id,$criteria_name,$applicant_source_table,$applicant_souce_column,$applicant_source_value,$operator,$created_by,$created_at,$level,$is_active,$last_updated_at,$last_updated_by){
		Yii::$app->db->createCommand()
        ->insert('verification_custom_criteria_passed', [
        'verification_custom_criteria_id' =>$verification_custom_criteria_id,
		'verification_framework_id' =>$verification_framework_id,
		'application_id' =>$application_id,
		'applicant_source_table' =>$applicant_source_table,
		'applicant_souce_column' =>$applicant_souce_column,
		'applicant_source_value' =>$applicant_source_value,
		'operator' =>$operator,
		'created_by' =>$created_by,
		'created_at' =>$created_at,
		'level' =>$level,
		'is_active' =>$is_active,
		'last_updated_at' =>$last_updated_at,
		'last_updated_by' =>$last_updated_by,		   
        ])->execute();
    }
    public static function checkExist($verification_custom_criteria_id,$application_id) {
            if (self::find()->where('verification_custom_criteria_id=:verification_custom_criteria_id AND application_id=:application_id', [':verification_custom_criteria_id' => $verification_custom_criteria_id,':application_id'=>$application_id])
                            ->exists()) {
                return 1;
            }
            return 0;
        }


public static function getVerificationCriteriaPassed($application_id,$verificationFrameworkID){  
    $verificationCriteriaPaased= self::find()->where(['verification_framework_id' =>$verificationFrameworkID,'application_id'=>$application_id])->all();
      return $verificationCriteriaPaased;
    }
}
