<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "qresponse_source".
 *
 * @property integer $qresponse_source_id
 * @property string $source_table
 * @property string $source_table_value_field
 * @property string $source_table_text_field
 *
 * @property ApplicantQnResponse[] $applicantQnResponses
 * @property CriteriaQuestionAnswer[] $criteriaQuestionAnswers
 * @property Question[] $questions
 */
class QresponseSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qresponse_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_table', 'source_table_value_field', 'source_table_text_field'], 'required'],
            [['source_table', 'source_table_value_field', 'source_table_text_field'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qresponse_source_id' => 'Qresponse Source ID',
            'source_table' => 'Source Table',
            'source_table_value_field' => 'Source Table Value Field',
            'source_table_text_field' => 'Source Table Text Field',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantQnResponses()
    {
        return $this->hasMany(ApplicantQnResponse::className(), ['qresponse_source_id' => 'qresponse_source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaQuestionAnswers()
    {
        return $this->hasMany(CriteriaQuestionAnswer::className(), ['qresponse_source_id' => 'qresponse_source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['qresponse_source_id' => 'qresponse_source_id']);
    }
}
