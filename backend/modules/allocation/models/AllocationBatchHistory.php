<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_batch_history".
 *
 * @property integer $allocation_batch_history_id
 * @property integer $allocation_batch_id
 * @property integer $allocation_history_id
 *
 * @property AllocationBatch $allocationBatch
 * @property AllocationHistory $allocationHistory
 */
class AllocationBatchHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'allocation_batch_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_batch_id', 'allocation_history_id'], 'required'],
            [['allocation_batch_id', 'allocation_history_id'], 'integer'],
            [['allocation_batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationBatch::className(), 'targetAttribute' => ['allocation_batch_id' => 'allocation_batch_id']],
            [['allocation_history_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationHistory::className(), 'targetAttribute' => ['allocation_history_id' => 'loan_allocation_history_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allocation_batch_history_id' => 'Allocation Batch History',
            'allocation_batch_id' => 'Allocation Batch',
            'allocation_history_id' => 'Allocation History',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationBatch()
    {
        return $this->hasOne(AllocationBatch::className(), ['allocation_batch_id' => 'allocation_batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationHistory()
    {
        return $this->hasOne(AllocationHistory::className(), ['loan_allocation_history_id' => 'allocation_history_id']);
    }
   public function getAllocationHist($student_type)
    {
      //("SELECT `loan_allocation_history_id`, `academic_year_id`, `allocation_name`, `description` FROM `allocation_history`  alh  WHERE `loan_allocation_history_id` NOT IN(SELECT `allocation_history_id` FROM allocation_batch_history ah join allocation_batch ab on ab.`allocation_batch_id`=ah.`allocation_batch_id` AND ah.`academic_year_id`='{$model->academic_year}') AND `student_type`='{$student_type}' AND alh.`academic_year_id`='{$model->academic_year}'"
    $model=  AcademicYear::findone(["is_current"=>1]);
  return  Yii::$app->db->createCommand("SELECT `loan_allocation_history_id`, `academic_year_id`, `allocation_name`, `description` FROM `allocation_history`  alh  WHERE `loan_allocation_history_id` NOT IN(SELECT `allocation_history_id` FROM allocation_batch_history ah join allocation_batch ab on ab.`allocation_batch_id`=ah.`allocation_batch_id` AND ab.`academic_year_id`='{$model->academic_year_id}')  AND alh.`academic_year_id`='{$model->academic_year_id}'")->queryAll(); 
    }
}
