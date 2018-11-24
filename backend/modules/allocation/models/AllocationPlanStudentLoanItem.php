<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_plan_student_loan_item".
 *
 * @property integer $allocation_plan_student_id
 * @property integer $loan_item_id
 * @property integer $priority_order
 * @property integer $rate_type
 * @property double $unit_amount
 * @property integer $duration
 * @property double $loan_award_percentage
 * @property double $total_amount_awarded
 *
 * @property AllocationPlanStudent $allocationPlan
 * @property AllocationPlanLoanItem $loanItem
 */
class AllocationPlanStudentLoanItem extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_plan_student_loan_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_student_id', 'loan_item_id', 'priority_order', 'rate_type', 'unit_amount', 'duration', 'loan_award_percentage', 'total_amount_awarded'], 'required'],
            [['allocation_plan_student_id', 'loan_item_id', 'priority_order', 'rate_type', 'duration'], 'integer'],
            [['unit_amount', 'loan_award_percentage', 'total_amount_awarded'], 'number'],
            [['allocation_plan_student_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlanStudent::className(), 'targetAttribute' => ['allocation_plan_student_id' => 'allocation_plan_student_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlanLoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_plan_student_id' => 'Allocation Plan Student ID',
            'loan_item_id' => 'Loan Item ID',
            'priority_order' => 'Priority Order',
            'rate_type' => 'Rate Type',
            'unit_amount' => 'Unit Amount',
            'duration' => 'Duration',
            'loan_award_percentage' => 'Loan Award Percentage',
            'total_amount_awarded' => 'Total Amount Awarded',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanStuden() {
        return $this->hasOne(AllocationPlanStudent::className(), ['allocation_plan_student_id' => 'allocation_plan_student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem() {
        return $this->hasOne(AllocationPlanLoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

}
