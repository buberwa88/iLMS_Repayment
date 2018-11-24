<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "applicant_criteria_score".
 *
 * @property integer $applicant_criteria_score_id
 * @property integer $application_id
 * @property integer $criteria_field_id
 * @property integer $criteria_question_id
 * @property double $weight_score
 * @property double $priority_score
 * @property string $comment
 *
 * @property Application $application
 * @property CriteriaQuestion $criteriaQuestion
 */
class ApplicantCriteriaScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant_criteria_score';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id'], 'required'],
            [['application_id', 'criteria_field_id', 'criteria_question_id'], 'integer'],
          
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['criteria_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriaQuestion::className(), 'targetAttribute' => ['criteria_question_id' => 'criteria_question_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_criteria_score_id' => 'Applicant Criteria Score',
            'application_id' => 'Application',
            'criteria_field_id' => 'Criteria Field',
            'criteria_question_id' => 'Criteria Question',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(\backend\modules\application\models\Application::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaQuestion()
    {
        return $this->hasOne(CriteriaQuestion::className(), ['criteria_question_id' => 'criteria_question_id']);
    }
}
