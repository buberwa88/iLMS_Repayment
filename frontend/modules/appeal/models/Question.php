<?php

namespace frontend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $question_id
 * @property string $question
 * @property string $response_control
 * @property integer $attachment_definition_id
 * @property string $response_data_type
 * @property string $hint
 * @property integer $require_verification
 * @property string $verification_prompt
 * @property integer $qresponse_source_id
 * @property integer $is_active
 * @property integer $response_data_length
 *
 * @property AppealQuestion[] $appealQuestions
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
            [['question', 'response_control', 'response_data_type'], 'required'],
            [['response_control', 'response_data_type'], 'string'],
            [['attachment_definition_id', 'require_verification', 'qresponse_source_id', 'is_active', 'response_data_length'], 'integer'],
            [['question', 'hint', 'verification_prompt'], 'string', 'max' => 500],
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
            'response_control' => 'Response Control',
            'attachment_definition_id' => 'Attachment Definition ID',
            'response_data_type' => 'Response Data Type',
            'hint' => 'Hint',
            'require_verification' => 'Require Verification',
            'verification_prompt' => 'Verification Prompt',
            'qresponse_source_id' => 'Qresponse Source ID',
            'is_active' => 'Is Active',
            'response_data_length' => 'Response Data Length',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppealQuestions()
    {
        return $this->hasMany(AppealQuestion::className(), ['question_id' => 'question_id']);
    }
}
