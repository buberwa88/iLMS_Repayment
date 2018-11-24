<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "applicant_qn_response".
 *
 * @property integer $applicant_qn_response_id
 * @property integer $applicant_question_id
 * @property integer $qresponse_source_id
 * @property integer $response_id
 * @property string $question_answer
 *
 * @property ApplicantQuestion $applicantQuestion
 * @property QresponseSource $qresponseSource
 */
class ApplicantQnResponse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant_qn_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_question_id'], 'required'],
            [['applicant_question_id', 'qresponse_source_id', 'response_id'], 'integer'],
            [['question_answer'], 'string', 'max' => 255],
            [['applicant_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantQuestion::className(), 'targetAttribute' => ['applicant_question_id' => 'applicant_question_id']],
            [['qresponse_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => QresponseSource::className(), 'targetAttribute' => ['qresponse_source_id' => 'qresponse_source_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_qn_response_id' => 'Applicant Qn Response ID',
            'applicant_question_id' => 'Applicant Question ID',
            'qresponse_source_id' => 'Qresponse Source ID',
            'response_id' => 'Response ID',
            'question_answer' => 'Question Answer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantQuestion()
    {
        return $this->hasOne(ApplicantQuestion::className(), ['applicant_question_id' => 'applicant_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQresponseSource()
    {
        return $this->hasOne(QresponseSource::className(), ['qresponse_source_id' => 'qresponse_source_id']);
    }
}
