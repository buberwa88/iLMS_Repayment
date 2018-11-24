<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationSetting as BaseAllocationSetting;

/**
 * This is the model class for table "allocation_setting".
 */
class AllocationSetting extends BaseAllocationSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['academic_year_id', 'loan_item_id', 'priority_order'], 'required'],
            [['academic_year_id', 'loan_item_id', 'priority_order', 'created_by'], 'integer'],
            [['created_at'], 'safe']
        ]);
    }
	
}
