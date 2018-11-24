<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_framework_scenario".
 *
 * @property integer $allocation_framework_scenario_id
 * @property integer $allocation_framework_id
 * @property integer $allocation_scenario
 * @property integer $priority_order
 *
 * @property AllocationFramework $allocationFramework
 */
class AllocationPlanScenario extends \yii\db\ActiveRecord {

    const ALLOCATION_SCENARIO_SPECIAL_GROUP = 1; /// when checking against special groups
    //const ALLOCATION_SCENARIO_NEEDINESS = 2; ///scenario ised when checking against neediness
    const ALLOCATION_SCENARIO_STD_DISTRIBUTION = 2; // when checking again student distribution

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return 'allocation_plan_scenario';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'allocation_scenario', 'priority_order'], 'required'],
            [['allocation_scenario'], 'validateScenario'],
            [['priority_order'], 'validatePriority'],
            [['allocation_plan_id', 'allocation_scenario', 'priority_order'], 'integer'],
            [['allocation_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlan::className(), 'targetAttribute' => ['allocation_plan_id' => 'allocation_plan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_plan_scenario_id' => 'Criteria/Scenario ID',
            'allocation_plan_id' => 'Allocation Plan ID',
            'allocation_scenario' => 'Criteria/Scenario',
            'priority_order' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationFramework() {
        return $this->hasOne(AllocationPlan::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    static function getAllocationScenarionsByFrameworkId($allocation_plan_framework_id) {
        return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where(['allocation_plan_id' => $allocation_plan_framework_id]),
        ]);
    }

    static function getAllocationPlanScenarios() {
        return[
            self::ALLOCATION_SCENARIO_SPECIAL_GROUP => 'Special Groups',
            //self::ALLOCATION_SCENARIO_NEEDINESS => 'Neediness',
            self::ALLOCATION_SCENARIO_STD_DISTRIBUTION => 'Student Distribution'
        ];
    }

    /*
     * returns the name of the scenario by its value
     */

    function getName() {
        $data = self::getAllocationPlanScenarios();
        if ($this->allocation_scenario && isset($data[$this->allocation_scenario])) {

            return $data[$this->allocation_scenario];
        }
        return NULL;
    }

    /*
     * alidates that the scenarios should not exist in the particular allocation framework
     * returns TRUE if not existing, FLASE if exists
     */

    function validateScenario($attribute) {
        if ($attribute && $this->allocation_plan_id) {
            if (self::find()->where(['allocation_plan_id' => $this->allocation_plan_id, 'allocation_scenario' => $this->allocation_scenario])->exists()) {
                $this->addError('allocation_scenario', 'Criteria/Scenario already exist');
//                return FALSE;
            }
        }
//        return TRUE;
    }

    function validatePriority($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            if (self::find()->where(['allocation_plan_id' => $this->allocation_plan_id, 'priority_order' => $this->priority_order])->exists()) {
                $this->addError($attribute, 'Selected Scenario Priority already in use');
//                return FALSE;
            }
        }
//        return TRUE;
    }

    static function getFrameworkExecutionOrderByFrameworkId($id) {
        return self::find()->where(['allocation_plan_id' => $id])->orderBy('priority_order ASC')->all();
    }

}
