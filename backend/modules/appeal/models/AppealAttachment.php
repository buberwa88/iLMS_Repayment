<?php

namespace backend\modules\appeal\models;

use Yii;
use \backend\modules\appeal\models\base\AppealAttachment as BaseAppealAttachment;

/**
 * This is the model class for table "appeal_attachment".
 */
class AppealAttachment extends BaseAppealAttachment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['appeal_id', 'attachment_path', 'created_by', 'updated_by'], 'required'],
            [['appeal_id', 'appeal_question_id', 'verification_status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['attachment_path'], 'string', 'max' => 100]
        ]);
    }
	
}
