<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_plan".
 *
 * @property integer $academic_year_id
 * @property integer $allocation_plan_id
 * @property string $allocation_plan_title
 * @property string $allocation_plan_desc
 * @property string $allocation_plan_number
 * @property integer $allocation_plan_stage
 * @property string $created_at
 * @property integer $allocation_framework_id
 *
 * @property AcademicYear $academicYear
 * @property AllocationFramework $allocationFramework
 * @property AllocationPlanClusterSetting[] $allocationPlanClusterSettings
 * @property AllocationPlanGenderSetting[] $allocationPlanGenderSettings
 * @property AllocationPlanInstitutionTypeSetting[] $allocationPlanInstitutionTypeSettings
 * @property AllocationPlanLoanItem[] $allocationPlanLoanItems
 * @property LoanItem[] $loanItems
 * @property AllocationPlanStudent[] $allocationPlanStudents
 * @property Application[] $applications
 */
class AllocationPlan extends \yii\db\ActiveRecord {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_CLOSED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year_id', 'allocation_plan_title', 'allocation_plan_number', 'allocation_plan_desc'], 'required'],
            [['academic_year_id', 'allocation_plan_stage'], 'integer'],
            [['allocation_plan_id'], 'validateSpecialGroup', 'on' => 'special_group'],
            [['allocation_plan_id'], 'validateSTDMatrix', 'on' => 'student_distribution'],
            [['created_at'], 'safe'],
            [['allocation_plan_title'], 'string', 'max' => 100],
            [['allocation_plan_desc'], 'string', 'max' => 300],
            [['allocation_plan_number'], 'string', 'max' => 10],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
        ];
    }

    /*
     * @inheritdoc
     */

    public function attributeLabels() {
        return [
            'academic_year_id' => 'Academic Year',
            'allocation_plan_id' => 'Allocation Framework',
            'allocation_plan_title' => 'Framework Name/Title',
            'allocation_plan_desc' => 'Description',
            'allocation_plan_number' => 'Framework Number',
            'allocation_plan_stage' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanSpecialGroup() {
        return $this->hasMany(AllocationPlanSpecialGroup::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanClusterSettings() {
        return $this->hasMany(AllocationPlanClusterSetting::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanScenarios() {
        return $this->hasMany(AllocationPlanScenario::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanGenderSettings() {
        return $this->hasMany(AllocationPlanGenderSetting::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanInstitutionTypeSettings() {
        return $this->hasMany(AllocationPlanInstitutionTypeSetting::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanLoanItems() {
        return $this->hasMany(AllocationPlanLoanItem::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItems() {
        return $this->hasMany(LoanItem::className(), ['loan_item_id' => 'loan_item_id'])->viaTable('allocation_plan_loan_item', ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationPlanStudents() {
        return $this->hasMany(AllocationPlanStudent::className(), ['allocation_plan_id' => 'allocation_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications() {
        return $this->hasMany(Application::className(), ['application_id' => 'application_id'])->viaTable('allocation_plan_student', ['allocation_plan_id' => 'allocation_plan_id']);
    }

    static function generateRandomString($length = 20) {

        if ($length > 5) {
            return trim(rand(5, $length));
        } else {
            return timr(rand(1, $length));
        }
    }

    static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive', self::STATUS_CLOSED => 'Closed'
        ];
    }

    public function getStatusNameByValue() {
        if ($this->allocation_plan_stage >= 0) {
            $statuses = self::getStatusList();
            if (isset($statuses[$this->allocation_plan_stage])) {
                return $statuses[$this->allocation_plan_stage];
            }
        }
        return NULL;
    }

    static function getSchemaTablesList() {
        $data = Yii::$app->db->schema->getTableNames();
        $data_array = [];
        if ($data) {
            foreach ($data as $data) {
                $data_array[$data] = $data;
            }
        }
        return $data_array;
    }

    /*
     * cheks of a particuar allocation plan has student
     */

    function hasStudents() {
        if (AllocationPlanStudent::find()->where(['allocation_plan_id' => $this->allocation_plan_id])->exists()) {
            return TRUE;
        }
        return FALSE;
    }

    function validateSpecialGroup($attribute) {
        if ($this->allocationPlanSpecialGroup) {
            return TRUE;
        }
        $this->addError($attribute, 'Please configure Special Groups first');
        return FALSE;
    }

    function validateSTDMatrix($attribute) {
        if ($this->allocationPlanClusterSettings OR $this->allocationPlanGenderSettings OR $this->allocationPlanInstitutionTypeSettings) {
            return TRUE;
        }
        $this->addError($attribute, 'Please configure Student Distribution first');
        return FALSE;
    }

}
