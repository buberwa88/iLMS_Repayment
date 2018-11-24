<?php

namespace backend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $question_id
 * @property string $question
 * @property string $response_type
 * @property string $data_type
 * @property string $hint
 * @property integer $require_verification
 * @property string $verification_prompt
 * @property integer $qresponse_source_id
 * @property integer $is_active
 *
 * @property AppealQuestion[] $appealQuestions
 * @property ApplicantQuestion[] $applicantQuestions
 * @property CriteriaQuestion[] $criteriaQuestions
 * @property QpossibleResponse[] $qpossibleResponses
 * @property QresponseSource $qresponseSource
 * @property QuestionTrigger[] $questionTriggers
 * @property QuestionTrigger[] $questionTriggers0
 * @property SectionQuestion[] $sectionQuestions
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'response_type', 'data_type'], 'required'],
            [['response_type', 'data_type'], 'string'],
            [['require_verification', 'qresponse_source_id', 'is_active'], 'integer'],
            [['question', 'hint', 'verification_prompt'], 'string', 'max' => 500],
            [['qresponse_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => QresponseSource::className(), 'targetAttribute' => ['qresponse_source_id' => 'qresponse_source_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'question_id' => 'Question ID',
            'question' => 'Question',
            'response_type' => 'Response Type',
            'data_type' => 'Data Type',
            'hint' => 'Hint',
            'require_verification' => 'Require Verification',
            'verification_prompt' => 'Verification Prompt',
            'qresponse_source_id' => 'Qresponse Source ID',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppealQuestions()
    {
        return $this->hasMany(AppealQuestion::className(), ['question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantQuestions()
    {
        return $this->hasMany(ApplicantQuestion::className(), ['question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaQuestions()
    {
        return $this->hasMany(CriteriaQuestion::className(), ['question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQpossibleResponses()
    {
        return $this->hasMany(QpossibleResponse::className(), ['question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQresponseSource()
    {
        return $this->hasOne(QresponseSource::className(), ['qresponse_source_id' => 'qresponse_source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionTriggers()
    {
        return $this->hasMany(QuestionTrigger::className(), ['question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionTriggers0()
    {
        return $this->hasMany(QuestionTrigger::className(), ['trigger_question_id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionQuestions()
    {
        return $this->hasMany(SectionQuestion::className(), ['question_id' => 'question_id']);
    }
}
