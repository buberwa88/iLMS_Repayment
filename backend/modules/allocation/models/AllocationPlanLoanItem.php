<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_plan_loan_item".
 *
 * @property integer $allocation_plan_id
 * @property integer $loan_item_id
 * @property integer $priority_order
 * @property integer $rate_type
 * @property double $unit_amount
 * @property integer $duration
 * @property double $loan_award_percentage
 * @property string $created_at
 *
 * @property AllocationPlan $allocationPlan
 * @property LoanItem $loanItem
 * @property AllocationPlanStudentLoanItem[] $allocationPlanStudentLoanItems
 * @property AllocationPlanStudent[] $allocationPlans
 */
class AllocationPlanLoanItem extends \yii\db\ActiveRecord {

    public $item_code; ///variable to carry the item code from the master loan item list

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return 'allocation_plan_loan_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'loan_item_id', 'priority_order'], 'required'],
            [['loan_item_id'], 'validateLoanItem'],
            [['priority_order'], 'validateItemProrityOrder'],
            [['allocation_plan_id', 'loan_item_id', 'priority_order', 'rate_type', 'duration'], 'integer'],
            [['unit_amount', 'loan_award_percentage'], 'number'],
            [['unit_amount'], 'number', 'min' => 1],
            [['loan_award_percentage'], 'number', 'min' => 0, 'max' => 100, 'message' => 'The {attribute} should be between 0 and 100 inclusive'],
            [['created_at', 'item_code','rate_type','loan_award_percentage'], 'safe'],
            [['allocation_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlan::className(), 'targetAttribute' => ['allocation_plan_id' => 'allocation_plan_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_plan_id' => 'Allocation Plan ID',
            'loan_item_id' => 'Loan Item',
            'priority_order' => 'Priority Order',
            'rate_type' => 'Item Rate Type',
            'unit_amount' => 'Unit Amount',
            'duration' => 'Duration(Year/days)',
            'loan_award_percentage' => 'Loan Awarding %',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlan() {
        return $this->hasOne(AllocationPlan::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem() {
        return $this->hasOne(LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanStudentLoanItems() {
        return $this->hasMany(AllocationPlanStudentLoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlans() {
        return $this->hasMany(AllocationPlanStudent::className(), ['allocation_plan_id' => 'allocation_plan_id', 'application_id' => 'application_id'])->viaTable('allocation_plan_student_loan_item', ['loan_item_id' => 'loan_item_id']);
    }

    public function afterFind() {
        parent::afterFind();
        $this->item_code = $this->loanItem->item_code;
    }

    static function getLoanItemsById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where(['allocation_plan_id' => $id]),
        ]);
    }

    public function validateLoanItem($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            if (self::find()->where(['allocation_plan_id' => $this->allocation_plan_id, 'loan_item_id' => $this->loan_item_id])->exists()) {
                $this->addError($attribute, 'Selected "Loan Item" exist in this allocation plan');
                return FALSE;
            }
        }
        return TRUE;
    }

    public function validateItemProrityOrder($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            if (self::find()->where(['allocation_plan_id' => $this->allocation_plan_id, 'priority_order' => $this->priority_order])->exists()) {
                $this->addError($attribute, 'Selected "Priority order" already in use by other Item in this allocation plan');
                return FALSE;
            }
        }
        return TRUE;
    }

    static function getLoanItemsByAllocationFrameworkid($id) {
        return self::find()->Select('loan_item_id,priority_order,rate_type,unit_amount,duration,loan_award_percentage')->where(['allocation_plan_id' => $id])->orderBy('priority_order ASC')->all();
    }

}
