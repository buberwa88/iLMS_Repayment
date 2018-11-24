<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "disbursement_task_definition".
 *
 * @property integer $disbursement_task_id
 * @property string $task_name
 * @property integer $status
 *
 * @property DisbursementTaskAssignment[] $disbursementTaskAssignments
 */
class DisbursementTaskDefinition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disbursement_task_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_name', 'status'], 'required'],
            [['status'], 'integer'],
            [['task_name'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'disbursement_task_id' => 'Disbursement Task ID',
            'task_name' => 'Task Name',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementTaskAssignments()
    {
        return $this->hasMany(DisbursementTaskAssignment::className(), ['disbursement_task_id' => 'disbursement_task_id']);
    }
}
