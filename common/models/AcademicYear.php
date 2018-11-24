<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "academic_year".
 *
 * @property integer $academic_year_id
 * @property string $academic_year
 * @property integer $is_current
 *
 * @property AdmissionBatch[] $admissionBatches
 * @property AllocationBatch[] $allocationBatches
 * @property AllocationSetting[] $allocationSettings
 * @property Application[] $applications
 * @property ClusterProgramme[] $clusterProgrammes
 * @property CriteriaField[] $criteriaFields
 * @property CriteriaQuestion[] $criteriaQuestions
 * @property DisbursementBatch[] $disbursementBatches
 * @property DisbursementSetting[] $disbursementSettings
 * @property DisbursementSetting2[] $disbursementSetting2s
 * @property LearningInstitutionFee[] $learningInstitutionFees
 * @property LoanRepaymentBillDetail[] $loanRepaymentBillDetails
 * @property ProgrammeFee[] $programmeFees
 * @property SectorProgramme[] $sectorProgrammes
 * @property StudentExamResult[] $studentExamResults
 * @property SystemSetting[] $systemSettings
 */
class AcademicYear extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'academic_year';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year', 'is_current'], 'required'],
            [['is_current'], 'integer'],
            [['academic_year'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'academic_year_id' => 'Academic Year',
            'academic_year' => 'Academic Year',
            'is_current' => 'Is Current',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionBatches() {
        return $this->hasMany(AdmissionBatch::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationBatches() {
        return $this->hasMany(AllocationBatch::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationSettings() {
        return $this->hasMany(AllocationSetting::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications() {
        return $this->hasMany(Application::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterProgrammes() {
        return $this->hasMany(ClusterProgramme::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaFields() {
        return $this->hasMany(CriteriaField::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaQuestions() {
        return $this->hasMany(CriteriaQuestion::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches() {
        return $this->hasMany(DisbursementBatch::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSettings() {
        return $this->hasMany(DisbursementSetting::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSetting2s() {
        return $this->hasMany(DisbursementSetting2::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutionFees() {
        return $this->hasMany(LearningInstitutionFee::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBillDetails() {
        return $this->hasMany(LoanRepaymentBillDetail::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeFees() {
        return $this->hasMany(ProgrammeFee::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorProgrammes() {
        return $this->hasMany(SectorProgramme::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults() {
        return $this->hasMany(StudentExamResult::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemSettings() {
        return $this->hasMany(SystemSetting::className(), ['academic_year_id' => 'academic_year_id']);
    }

    static function getNameById($Id) {
        $data = self::find()->where(['academic_year_id' => $Id])->one();
        if ($data) {
            return $data->academic_year;
        }
        return NULL;
    }

}
