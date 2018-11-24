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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_framework_id', 'criteria_name', 'applicant_source_table', 'applicant_souce_column', 'applicant_source_value', 'created_by', 'created_at'], 'required'],
            [['verification_framework_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
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
            'query' => self::find()->where('verification_framework_id=:id',[':id' => $id]),
        ]);
    }
}
