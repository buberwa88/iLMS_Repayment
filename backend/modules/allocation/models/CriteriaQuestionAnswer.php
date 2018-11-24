<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "criteria_question_answer".
 *
 * @property integer $criteria_question_answer_id
 * @property integer $criteria_question_id
 * @property integer $qresponse_source_id
 * @property integer $response_id
 * @property string $value
 *
 * @property CriteriaQuestion $criteriaQuestion
 * @property QresponseSource $qresponseSource
 */
class CriteriaQuestionAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'criteria_question_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criteria_question_id'], 'required'],
            [['criteria_question_id', 'qresponse_source_id', 'response_id'], 'integer'],
            [['value'], 'string', 'max' => 100],
            [['criteria_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriaQuestion::className(), 'targetAttribute' => ['criteria_question_id' => 'criteria_question_id']],
            [['qresponse_source_id'], 'exist', 'skipOnError' => true, 'targetClass' => QresponseSource::className(), 'targetAttribute' => ['qresponse_source_id' => 'qresponse_source_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'criteria_question_answer_id' => 'Criteria Question Answer ID',
            'criteria_question_id' => 'Criteria Question ID',
            'qresponse_source_id' => 'Qresponse Source ID',
            'response_id' => 'Response ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaQuestion()
    {
        return $this->hasOne(CriteriaQuestion::className(), ['criteria_question_id' => 'criteria_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQresponseSource()
    {
        return $this->hasOne(QresponseSource::className(), ['qresponse_source_id' => 'qresponse_source_id']);
    }
}
