<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationTask as BaseAllocationTask;

/**
 * This is the model class for table "allocation_task_definition".
 */
class AllocationTask extends BaseAllocationTask
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_PENDING = 2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['task_name', 'accept_code', 'status'], 'required'],
            [['status'], 'integer'],
            [['task_name'], 'string', 'max' => 300],
            [['accept_code', 'reject_code'], 'string', 'max' => 100]
        ]);
    }
    static function getStatusValue() {
        return [
            self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive'
        ];
    }
}
