<?php

namespace frontend\modules\appeal\models;

use Yii;
use \app\modules\appeal\models\base\AppealQuestion as BaseAppealQuestion;

/**
 * This is the model class for table "appeal_question".
 */
class AppealQuestion extends BaseAppealQuestion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['question_id', 'attachment_definition_id', 'created_by', 'created_at', 'updated_at', 'updated_by'], 'required'],
            [['question_id', 'attachment_definition_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(\frontend\modules\appeal\models\Question::className(), ['question_id' => 'question_id']);
    }

    public function getQuestionString()
    {
        $res =  $this->question->question;

        return $res;
    }
       
}
