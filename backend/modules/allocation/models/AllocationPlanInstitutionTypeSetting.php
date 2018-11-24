<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_plan_institution_type_setting".
 *
 * @property integer $allocation_plan_id
 * @property integer $institution_type
 * @property double $student_distribution_percentage
 *
 * @property AllocationPlan $allocationPlan
 */
class AllocationPlanInstitutionTypeSetting extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_plan_institution_type_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'institution_type', 'student_distribution_percentage'], 'required'],
            [['institution_type'], 'validateInstitutionType'],
            [['student_distribution_percentage'], 'validateComposition'],
            [['allocation_plan_id', 'institution_type'], 'integer'],
            [['student_distribution_percentage'], 'number'],
            [['allocation_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlan::className(), 'targetAttribute' => ['allocation_plan_id' => 'allocation_plan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_plan_id' => 'Allocation Plan ID',
            'institution_type' => 'Institution Type',
            'student_distribution_percentage' => '% Student',
        ];
    }

    public function validateInstitutionType($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            if (self::find()->where(['allocation_plan_id' => $this->allocation_plan_id, 'institution_type' => $this->institution_type])->exists()) {
                $this->addError($attribute, 'Selected "Institution Type" exist in this allocation plan');
                return FALSE;
            }
        }
        return TRUE;
    }

    public function validateComposition($attribute) {
        if ($this->allocation_plan_id && $attribute) {
            $data = self::find()->select('SUM(student_distribution_percentage) AS student_distribution_percentage')->where(['allocation_plan_id' => $this->allocation_plan_id])->one();
            $total = $data->student_distribution_percentage + $this->student_distribution_percentage;

            if ($total > 100) {
                $this->addError($attribute, 'Enter "Student %" is greater than the allowed value, Total % Distribution should not exceed 100');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlan() {
        return $this->hasOne(AllocationPlan::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    static function getInstitutionTypeSettingsById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where(['allocation_plan_id' => $id]),
        ]);
    }

    static function getInstitutionTypeSettingsByAllocationPlanId($id) {
        return self::find()->where('allocation_plan_id=:id', [':id' => $id])->all();
    }

}
