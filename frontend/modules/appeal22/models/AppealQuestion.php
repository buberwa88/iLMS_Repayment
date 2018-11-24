<?php

namespace backend\modules\appeal\models;

use Yii;
use \backend\modules\appeal\models\base\AppealQuestion as BaseAppealQuestion;

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
            [['question_id', 'attachment_definition_id'], 'required'],
            [['question_id', 'attachment_definition_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }
	
}
