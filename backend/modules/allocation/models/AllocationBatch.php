<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationBatch as BaseAllocationBatch;

/**
 * This is the model class for table "allocation_batch".
 */
class AllocationBatch extends BaseAllocationBatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['contained_student','batch_desc'], 'required'],
            [['batch_number', 'academic_year_id','is_reviewed','review_by','is_approved', 'created_by', 'updated_by', 'is_canceled', 'disburse_status'], 'integer'],
            [['available_budget'], 'number'],
            [['approval_comment', 'cancel_comment'], 'string'],
            [['created_at', 'updated_at','batch_number', 'academic_year_id','review_at', 'available_budget'], 'safe'],
            [['batch_desc'], 'string', 'max' => 45],
            [['disburse_comment'], 'string', 'max' => 300]
        ]);
    }
  public function putAllocationStudentHistoryBatch($allocation_history_id,$academic_year_id){
      $sql="SELECT `loan_item_id`,  `total_amount_awarded`,`application_id` FROM `allocation_plan_student` aps join allocation_plan_student_loan_item asl  on aps.`allocation_plan_student_id`=asl.`allocation_plan_student_id` WHERE `allocation_history_id` IN($allocation_history_id) AND `academic_year_id`='{$academic_year_id}'";
     return  Yii::$app->db->createCommand($sql)->queryAll();  
  }
 public function countAllocationStudentHistory($allocation_history_id,$academic_year_id){
      $sql="SELECT count(*) FROM `allocation_plan_student` aps join allocation_plan_student_loan_item asl  on aps.`allocation_plan_student_id`=asl.`allocation_plan_student_id` WHERE `allocation_history_id` IN($allocation_history_id) AND `academic_year_id`='{$academic_year_id}'";
   return  Yii::$app->db->createCommand($sql)->queryScalar(); 
      
 }	
}
