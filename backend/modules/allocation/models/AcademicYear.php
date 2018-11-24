<?php

namespace backend\modules\allocation\models;

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
 * @property Application[] $applications
 * @property ClusterProgramme[] $clusterProgrammes
 * @property DisbursementBatch[] $disbursementBatches
 * @property DisbursementSetting[] $disbursementSettings
 * @property SectorProgramme[] $sectorProgrammes
 * @property StudentExamResult[] $studentExamResults
 */
class AcademicYear extends \yii\db\ActiveRecord {

    const IS_CURRENT_YEAR = 1;
    const IS_NOT_CURRENT_YEAR = 0;
    const IS_CLOSED_YEAR = 2;

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
            [['academic_year'], 'required'],
            [['is_current'], 'integer'],
            [['academic_year'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'academic_year_id' => Yii::t('app', 'Academic Year ID'),
            'academic_year' => Yii::t('app', 'Academic Year'),
            'is_current' => Yii::t('app', 'Is Current'),
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
    public function getSectorProgrammes() {
        return $this->hasMany(SectorProgramme::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults() {
        return $this->hasMany(StudentExamResult::className(), ['academic_year_id' => 'academic_year_id']);
    }

    static function getCurrentYearID() {
        $data = self::find()->select('academic_year_id')->where(['is_current' => AcademicYear::IS_CURRENT_YEAR])->one();
        if ($data) {
            return $data->academic_year_id;
        }
        return NULL;
    }

    static function getCurrentYearDetails() {
        return self::find()->where(['is_current' => AcademicYear::IS_CURRENT_YEAR])->one();
    }

    static function getPreviousAcademicYears() {
        return self::find()
                        ->where('is_current !=:is_current AND academic_year < (SELECT academic_year FROM academic_year WHERE is_current=:is_current LIMIT 1)', [':is_current' => AcademicYear::IS_CURRENT_YEAR])
                        ->orderBy('academic_year DESC')
                        ->all();
    }

    static function getCurrentAndPreviousAcademicYears() {
        return self::find()
                        ->where('academic_year <= (SELECT academic_year FROM academic_year WHERE is_current=:is_current LIMIT 1)', [':is_current' => AcademicYear::IS_CURRENT_YEAR])
                        ->orderBy('academic_year DESC')
                        ->all();
    }

    static function getNextCommingAcademicYears() {
        return self::find()
                        ->where('is_current !=:is_current AND academic_year > (SELECT academic_year FROM academic_year WHERE is_current=:is_current LIMIT 1)', [':is_current' => AcademicYear::IS_CURRENT_YEAR])
                        ->orderBy('academic_year DESC')
                        ->all();
    }

    static function getCurrentYearName() {
        $currentYear = self::getCurrentYearDetails();
        return $currentYear->academic_year;
    }

}
