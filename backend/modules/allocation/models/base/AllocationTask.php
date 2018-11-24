<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "allocation_task_definition".
 *
 * @property integer $allocation_task_id
 * @property string $task_name
 * @property string $accept_code
 * @property string $reject_code
 * @property integer $status
 */
class AllocationTask extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;
 

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_name', 'accept_code', 'status'], 'required'],
            [['status'], 'integer'],
            [['task_name'], 'string', 'max' => 300],
            [['accept_code', 'reject_code'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_task_definition';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_task_id' => 'Allocation Task ID',
            'task_name' => 'Task Name',
            'accept_code' => 'Accept Code',
            'reject_code' => 'Reject Code',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
  
}
