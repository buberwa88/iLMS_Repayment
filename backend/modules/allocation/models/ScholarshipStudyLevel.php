<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "scholarship_study_level".
 *
 * @property integer $scholarship_definition_id
 * @property integer $applicant_category_id
 * @property integer $academic_year_id
 *
 * @property ApplicantCategory $applicantCategory
 * @property ScholarshipDefinition $scholarshipDefinition
 * @property AcademicYear $academicYear
 */
class ScholarshipStudyLevel extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'scholarship_study_level';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['scholarship_definition_id', 'applicant_category_id', 'academic_year_id'], 'required'],
            [['scholarship_definition_id', 'applicant_category_id', 'academic_year_id'], 'integer'],
            [['applicant_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['applicant_category_id' => 'applicant_category_id']],
            [['scholarship_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScholarshipDefinition::className(), 'targetAttribute' => ['scholarship_definition_id' => 'scholarship_id']],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'scholarship_definition_id' => 'Scholarship Definition ID',
            'applicant_category_id' => 'Applicant Category ID',
            'academic_year_id' => 'Academic Year ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategory() {
        return $this->hasOne(ApplicantCategory::className(), ['applicant_category_id' => 'applicant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipDefinition() {
        return $this->hasOne(ScholarshipDefinition::className(), ['scholarship_id' => 'scholarship_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    static function getStudylevelsByGrantId($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\ScholarshipStudyLevel::find()->where(['scholarship_definition_id' => $id]),
        ]);
    }

}
