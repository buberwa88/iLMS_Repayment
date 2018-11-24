<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "qpossible_response".
 *
 * @property integer $qpossible_response_id
 * @property integer $question_id
 * @property integer $qresponse_list_id
 * @property integer $attachment_definition_id
 *
 * @property AttachmentDefinition $attachmentDefinition
 * @property QresponseList $qresponseList
 * @property Question $question
 */
class QpossibleResponse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qpossible_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id','qresponse_list_id'], 'required'],
            [['question_id', 'qresponse_list_id'], 'integer'],
            //[['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
            [['qresponse_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => QresponseList::className(), 'targetAttribute' => ['qresponse_list_id' => 'qresponse_list_id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'question_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qpossible_response_id' => 'Qpossible Response ID',
            'question_id' => 'Question',
            'qresponse_list_id' => 'Response',
           
        ];
    }
 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQresponseList()
    {
        return $this->hasOne(QresponseList::className(), ['qresponse_list_id' => 'qresponse_list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['question_id' => 'question_id']);
    }
}
