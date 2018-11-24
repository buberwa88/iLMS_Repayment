<?php

namespace backend\modules\disbursement\models;

use Yii;
use \backend\modules\disbursement\models\base\DisbursementSchedule as BaseDisbursementSchedule;

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
            [['operator_name', 'from_amount'], 'required'],
            [['from_amount', 'to_amount'], 'number'],
            [['created_at', 'updated_at','created_at', 'created_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['operator_name'], 'string', 'max' => 20],
             ['to_amount', 'required', 'when' => function ($model) {
                    return $model->operator_name == "Between";
                },
                'whenClient' => "function (attribute, value) { "
                . " return $('#disbursementschedule-to_amount').val() == 'Between'; }"],
            
        ]);
    }
	
}
