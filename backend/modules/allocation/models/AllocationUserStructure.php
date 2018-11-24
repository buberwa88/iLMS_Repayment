<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationUserStructure as BaseAllocationUserStructure;

/**
 * This is the model class for table "allocation_user_structure".
 */
class AllocationUserStructure extends BaseAllocationUserStructure
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['allocation_structure_id', 'user_id'], 'required'],
            [['allocation_structure_id', 'user_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }
	
}
