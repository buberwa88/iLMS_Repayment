<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationStructure as BaseAllocationStructure;

/**
 * This is the model class for table "allocation_structure".
 */
class AllocationStructure extends BaseAllocationStructure
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['structure_name', 'order_level'], 'required'],
            [['parent_id', 'order_level', 'status'], 'integer'],
            [['structure_name'], 'string', 'max' => 300]
        ]);
    }
	
}
