<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "qresponse_list".
 *
 * @property integer $qresponse_list_id
 * @property string $response
 * @property integer $is_active
 *
 * @property QpossibleResponse[] $qpossibleResponses
 * @property QuestionTrigger[] $questionTriggers
 */
class QresponseList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qresponse_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['response'], 'required'],
            [['is_active'], 'integer'],
            [['response'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'qresponse_list_id' => 'Qresponse List ID',
            'response' => 'Response',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQpossibleResponses()
    {
        return $this->hasMany(QpossibleResponse::className(), ['qresponse_list_id' => 'qresponse_list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionTriggers()
    {
        return $this->hasMany(QuestionTrigger::className(), ['trigger_qresponse_list_id' => 'qresponse_list_id']);
    }
}
