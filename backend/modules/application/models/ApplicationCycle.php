<?php

namespace backend\modules\application\models;
use common\models\AcademicYear;

use Yii;

/**
 * This is the model class for table "application_cycle".
 *
 * @property integer $application_cycle_id
 * @property integer $application_cycle_status_id
 * @property integer $academic_year_id
 * @property integer $applicant_category
 * @property string $application_status_remark
 *
 * @property AcademicYear $academicYear
 * @property ApplicantCategory $applicantCategory
 * @property ApplicationCycleStatus $applicationCycleStatus
 */
class ApplicationCycle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_cycle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id','application_cycle_status_id',], 'required'],
            [['application_cycle_status_id', 'academic_year_id', 'applicant_category'], 'integer'],
            [['application_status_remark'], 'string', 'max' => 255],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['applicant_category'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['applicant_category' => 'applicant_category_id']],
            [['application_cycle_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationCycleStatus::className(), 'targetAttribute' => ['application_cycle_status_id' => 'application_cycle_status_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'application_cycle_id' => 'Application Cycle ID',
            'application_cycle_status_id' => 'Application Cycle Status',
            'academic_year_id' => 'Academic Year',
            'applicant_category' => 'Applicant Category',
            'application_status_remark' => 'Application Status Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategory()
    {
        return $this->hasOne(ApplicantCategory::className(), ['applicant_category_id' => 'applicant_category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationCycleStatus()
    {
        return $this->hasOne(ApplicationCycleStatus::className(), ['application_cycle_status_id' => 'application_cycle_status_id']);
    }
}

