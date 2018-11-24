<?php

namespace app\models;

use Yii;
use \app\models\base\DisbursementSchedule as BaseDisbursementSchedule;

/**
 * This is the model class for table "disbursement_schedule".
 */
class DisbursementSchedule extends BaseDisbursementSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['operator_name', 'from_amount', 'to_amount', 'created_at', 'created_by'], 'required'],
            [['from_amount', 'to_amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['operator_name'], 'string', 'max' => 10],
            [['deleted_by'], 'unique']
        ]);
    }
	
}
