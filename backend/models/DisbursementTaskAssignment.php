<?php

namespace app\models;

use Yii;
use \app\models\base\DisbursementTaskAssignment as BaseDisbursementTaskAssignment;

/**
 * This is the model class for table "disbursement_task_assignment".
 */
class DisbursementTaskAssignment extends BaseDisbursementTaskAssignment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['disbursement_schedule_id', 'disbursement_structure_id', 'disbursement_task_id', 'created_at', 'created_by'], 'required'],
            [['disbursement_schedule_id', 'disbursement_structure_id', 'disbursement_task_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe']
        ]);
    }
	
}
