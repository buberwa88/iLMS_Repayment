<?php

namespace backend\modules\disbursement\models;

use Yii;
use \backend\modules\disbursement\models\base\DisbursementUserTask as BaseDisbursementUserTask;

/**
 * This is the model class for table "disbursement_user_task".
 */
class DisbursementUserTask extends BaseDisbursementUserTask
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['disbursement_structure_id', 'user_id'], 'required'],
            [['disbursement_structure_id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'created_at', 'created_by'], 'safe']
        ]);
    }
	
}
