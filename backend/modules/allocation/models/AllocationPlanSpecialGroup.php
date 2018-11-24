<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_framework_special_group".
 *
 * @property integer $special_group_id
 * @property integer $allocation_plan_id
 * @property string $group_name
 * @property string $applicant_source_table
 * @property string $applicant_souce_column
 * @property string $applicant_source_value
 * @property string $operator
 *
 * @property AllocationFramework $allocationFramework
 */
class AllocationPlanSpecialGroup extends \yii\db\ActiveRecord {

    const OPERATOR_EQUAL_TO = '=';
    const OPERATOR_NOT_EQUAL_TO = '!=';
    const OPERATOR_GREATER_THAN = '>';
    const OPERATOR_GREATER_THAN_OR_EQUAL = '>=';
    const OPERATOR_LESS_THAN = '<';
    const OPERATOR_LESS_THAN_OR_EQUAL = '=<';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_plan_special_group';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'allocation_group_criteria_id', 'group_description', 'priority_order'], 'required'],
            [['allocation_group_criteria_id'], 'validateGroup'],
            [['allocation_plan_id', 'allocation_group_criteria_id'], 'integer'],
            [['group_description'], 'string', 'max' => 100],
            [['allocation_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlan::className(), 'targetAttribute' => ['allocation_plan_id' => 'allocation_plan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'special_group_id' => 'Special Group ID',
            'allocation_plan_id' => 'Allocation Plan ID',
            'allocation_group_criteria_id' => 'Group Name',
            'group_description' => 'Group Description',
            'priority_order' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationFramework() {
        return $this->hasOne(AllocationPLan::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    static function getAllocationSpecialGroupsByFrameworkId($allocation_plan_id) {
        return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where(['allocation_plan_id' => $allocation_plan_id]),
        ]);
    }

    public function getCriteria() {
        return $this->hasOne(Criteria::className(), ['criteria_id' => 'allocation_group_criteria_id']);
    }

    /*
     * alidates that the scenarios should not exist in the particular allocation framework
     * returns TRUE if not existing, FLASE if exists
     */

    function validateGroup($attribute) {
        if ($this->allocation_plan_id && $this->allocation_group_criteria_id) {
            $exists = self::find()
                            ->where(
                                    [ 'allocation_plan_id' => $this->allocation_plan_id,
                                        'allocation_group_criteria_id' => $this->allocation_group_criteria_id,
                                    ]
                            )->exists();
            if ($exists) {
                $this->addError($attribute, 'Special Group Setting Already Exist in this Framework');
                return FALSE;
            }
        }
        return TRUE;
    }

    static function getOperators() {
        return [self::OPERATOR_EQUAL_TO => 'Equal To (=)',
            self::OPERATOR_NOT_EQUAL_TO => 'Not Equal To (!=)',
            self::OPERATOR_GREATER_THAN => 'Greater Than (<)',
            self::OPERATOR_GREATER_THAN_OR_EQUAL => 'Greater Than or Equal (>=)',
            self::OPERATOR_LESS_THAN => 'Less than (<)',
            self::OPERATOR_LESS_THAN_OR_EQUAL => 'Less than or Equal (<=)'
        ];
    }

    /*
     * retrieved the lis of all the special groups per given allocation planid
     */

    static function getSpecialGroupeByAllocationPlanID($id) {
        return self::find()->where(['allocation_plan_id' => $id])->orderBy('priority_order ASC')->all();
    }

    function getSpecialGroupName() {
        $data = Criteria::find($this->allocation_group_criteria_id);
        if ($data) {
            return $data->criteria_description;
        }
        return NULL;
    }

}
