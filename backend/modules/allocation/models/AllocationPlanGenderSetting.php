<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_plan_gender_setting".
 *
 * @property integer $allocation_plan_gender_setting_id
 * @property integer $allocation_plan_id
 * @property double $female_percentage
 * @property double $male_percentage
 *
 * @property AllocationPlan $allocationPlan
 */
class AllocationPlanGenderSetting extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_plan_gender_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'female_percentage'], 'required'],
            [['allocation_plan_id'], 'integer'],
            [['female_percentage', 'male_percentage'], 'number'],
            [['female_percentage'], 'validateFemMalePercent'],
            //[['allocation_plan_id'],'validateAllocationPlan','on'=>'add_allocation_gender_plan'],
            [['allocation_plan_id'], 'unique', 'message' => 'Allocation plan exists'],
            [['male_percentage'], 'safe'],
            [['allocation_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => AllocationPlan::className(), 'targetAttribute' => ['allocation_plan_id' => 'allocation_plan_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_plan_gender_setting_id' => 'Allocation Plan Gender Setting ID',
            'allocation_plan_id' => 'Allocation Plan',
            'female_percentage' => 'Female Percentage',
            'male_percentage' => 'Male Percentage',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlan() {
        return $this->hasOne(AllocationPlan::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    public function validateFemMalePercent($attribute) {
        if ($attribute && $this->female_percentage) {
            if ($this->female_percentage >= '100') {
                $this->addError($attribute, 'Incorrect percentage distribution of male and female');
                return FALSE;
            }
        }
        return true;
    }

    public function validateAllocationPlan($attribute) {
        if ($attribute && $this->allocation_plan_id) {
            if (self::find()->where('allocation_plan_id=:allocation_plan_id', [':allocation_plan_id' => $this->allocation_plan_id])
                            ->exists()) {
                $this->addError($attribute, ' Allocation plan already exists');
                return FALSE;
            }
        }
        return true;
    }

    public static function updateMalePercent($male_percentage, $allocation_plan_gender_setting_id) {
        self::updateAll(['male_percentage' => $male_percentage], 'allocation_plan_gender_setting_id="' . $allocation_plan_gender_setting_id . '"');
    }

    static function getGenderSettingsById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where('allocation_plan_id=:id', [':id' => $id]),
        ]);
    }

    public static function getAllocationGenderPlanID($allocation_plan_id) {
        $condition = ["allocation_plan_id" => $allocation_plan_id];
        return self::find()
                        ->select("allocation_plan_id")
                        ->where($condition)
                        ->one();
    }

    static function getGenderSettingsByAllocationPlanId($id) {
        return self::find()->where('allocation_plan_id=:id', [':id' => $id])->one();
    }

}
