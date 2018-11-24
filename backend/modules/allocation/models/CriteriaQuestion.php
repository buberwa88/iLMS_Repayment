<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "criteria_question".
 *
 * @property integer $criteria_question_id
 * @property integer $criteria_id
 * @property integer $question_id
 * @property string $operator
 * @property integer $academic_year_id
 * @property integer $type
 * @property double $weight_points
 * @property double $priority_points
 *
 * @property ApplicantCriteriaScore[] $applicantCriteriaScores
 * @property AcademicYear $academicYear
 * @property Criteria $criteria
 * @property Question $question
 * @property CriteriaQuestionAnswer[] $criteriaQuestionAnswers
 */
class CriteriaQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'criteria_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criteria_id', 'question_id', 'academic_year_id','applicant_category_id','parent_id','type'], 'integer'],
            [['operator','join_operator'], 'string'],
            [['weight_points', 'priority_points'], 'number'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['criteria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Criteria::className(), 'targetAttribute' => ['criteria_id' => 'criteria_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Question::className(), 'targetAttribute' => ['question_id' => 'question_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'criteria_question_id' => 'Criteria Question',
            'criteria_id' => 'Criteria',
            'question_id' => 'Question',
            'operator' => 'Operator',
            'academic_year_id' => 'Academic Year',
            'type' => 'Type',
            'weight_points' => 'Weight',
            'priority_points' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCriteriaScores()
    {
        return $this->hasMany(ApplicantCriteriaScore::className(), ['criteria_question_id' => 'criteria_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteria()
    {
        return $this->hasOne(Criteria::className(), ['criteria_id' => 'criteria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(\backend\modules\application\models\Question::className(), ['question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaQuestionAnswers()
    {
        return $this->hasMany(CriteriaQuestionAnswer::className(), ['criteria_question_id' => 'criteria_question_id']);
    }
}
