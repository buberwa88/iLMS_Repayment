<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationFeeFactor as BaseAllocationFeeFactor;

/**
 * This is the model class for table "allocation_fee_factor".
 */
class AllocationFeeFactor extends BaseAllocationFeeFactor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['academic_year_id', 'factor_value'], 'required'],
            [['academic_year_id', 'created_by', 'updated_by'], 'integer'],
            [['min_amount', 'max_amount', 'factor_value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['operator_name'], 'string', 'max' => 255]
        ]);
    }
	
}
