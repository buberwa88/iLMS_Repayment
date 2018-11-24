<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\AllocationHistory as BaseAllocationHistory;

/**
 * This is the model class for table "allocation_history".
 */
class AllocationHistory extends BaseAllocationHistory {

    const STATUS_DRAFT = 0;
    const STATUS_REVIEWED = 1;
    const STATUS_APPROVED = 2;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['academic_year_id', 'allocation_name', 'description', 'place_of_study', 'student_type', 'study_level'], 'required'],
            [['allocation_framework_id'], 'required', 'on' => 'local-freshers'],
            [['allocation_name'], 'unique'],
            [['academic_year_id', 'study_level', 'allocation_framework_id', 'created_by', 'reviewed_by', 'approved_by', 'status','loan_allocation_history_id'], 'integer'],
            [['created_at', 'reviewed_at', 'approved_at'], 'safe']
        ]);
    }

    function getStudyLevelName() {
        if ($this->study_level) {
            $data = ApplicantCategory::find()
                    ->where(['applicant_category_id' => $this->study_level])
                    ->one();
            if ($data) {
                return $data->applicant_category;
            }
        }
        return NULL;
    }

    static function getStatusList() {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_REVIEWED => 'Reviewed',
            self::STATUS_APPROVED => 'Approved'
        ];
    }

    function getStatusName() {
        if ($this->status >= 0) {
            $data = self::getStatusList();
            if ($data) {
                return $data[$this->status];
            }
        }
        return NULL;
    }
  function getTotalAllocatedAmount() {
      
            $data =Yii::$app->db->createCommand("SELECT sum(`total_amount_awarded`) as amount FROM `allocation_plan_student_loan_item` api join allocation_plan_student aps on aps.`allocation_plan_student_id`=api.`allocation_plan_student_id` WHERE allocation_history_id='{$this->loan_allocation_history_id}'")->queryAll();
            if ($data) {
                foreach ($data as $datas);
                return number_format($datas["amount"]);
            }
     
        return null;
    }
    
   
}
