<?php

namespace frontend\models;

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
class AcademicYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'academic_year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year'], 'required'],
            [['is_current'], 'integer'],
            [['academic_year'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'academic_year_id' => Yii::t('app', 'Academic Year ID'),
            'academic_year' => Yii::t('app', 'Academic Year'),
            'is_current' => Yii::t('app', 'Is Current'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionBatches()
    {
        return $this->hasMany(AdmissionBatch::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationBatches()
    {
        return $this->hasMany(AllocationBatch::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusterProgrammes()
    {
        return $this->hasMany(ClusterProgramme::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches()
    {
        return $this->hasMany(DisbursementBatch::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSettings()
    {
        return $this->hasMany(DisbursementSetting::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorProgrammes()
    {
        return $this->hasMany(SectorProgramme::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults()
    {
        return $this->hasMany(StudentExamResult::className(), ['academic_year_id' => 'academic_year_id']);
    }
}
