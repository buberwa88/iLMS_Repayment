<?php

namespace backend\modules\allocation\models;

use yii\base\Model;

/**
 * Signup form
 */
class AllocateLoan extends Model {

    public $academic_year;
    public $allocation_framework;
    public $study_level;
    public $student_type;
    public $place_of_study;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year', 'allocation_framework', 'study_level','student_type','place_of_study'], 'required', 'on' => 'allocate_freshesher_loan'],
            [['allocation_framework'], 'validateFramework'],
            [['academic_year', 'allocation_framework'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'academic_year' => 'Academic Year',
            'study_level' => 'Level of Study',
            'allocation_framework' => 'Allocation Framework',
            'student_type'=>'Student Type',
            'place_of_study'=>'Place Of Study'
        ];
    }

    function validateFramework($attribute) {
        if ($attribute && $this->academic_year && $this->allocation_framework) {
            if (!\backend\modules\allocation\models\AllocationPlan::find()->where(
                            ['academic_year_id' => $this->academic_year, 'allocation_plan_id' => $this->allocation_framework]
                    )->exists()) {
                $this->addError($attribute, 'Allocation Framework Doesnot Exist in the current Academic year');
                return FALSE;
            }
        }
        return TRUE;
    }

}
