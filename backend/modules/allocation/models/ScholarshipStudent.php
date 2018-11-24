<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "scholarship_student".
 *
 * @property integer $scholarship_student_id
 * @property integer $scholarship_id
 * @property string $student_f4indexno
 * @property string $student_firstname
 * @property string $student_lastname
 * @property string $student_middlenames
 * @property string $student_f6indexno
 * @property string $student_admission_no
 * @property integer $academic_year_id
 *
 * @property AcademicYear $academicYear
 * @property ScholarshipDefinition $scholarship
 */
class ScholarshipStudent extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'scholarship_student';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['scholarship_id', 'student_f4indexno', 'student_firstname', 'student_lastname', 'academic_year_id', 'student_admission_no', 'programme_id'], 'required'],
            [['scholarship_id', 'academic_year_id'], 'integer'],
            [['student_f4indexno', 'student_f6indexno'], 'string', 'max' => 15],
            [['student_firstname', 'student_lastname', 'student_middlenames'], 'string', 'max' => 100],
            [['student_admission_no'], 'string', 'max' => 50],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['scholarship_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScholarshipDefinition::className(), 'targetAttribute' => ['scholarship_id' => 'scholarship_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'scholarship_student_id' => 'Student ID',
            'scholarship_id' => 'Scholarship ID',
            'student_f4indexno' => 'Form 4 index No',
            'student_firstname' => 'First Name',
            'student_lastname' => 'Last Name',
            'student_middlenames' => 'Other Names',
            'student_f6indexno' => 'Form 6 Index No',
            'student_admission_no' => 'Admission No',
            'academic_year_id' => 'Academic Year',
            'programme_id' => 'Programme',
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
    public function getScholarship() {
        return $this->hasOne(ScholarshipDefinition::className(), ['scholarship_id' => 'scholarship_id']);
    }

    static function getStudentsById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\ScholarshipStudent::find()->where(['scholarship_id' => $id]),
        ]);
    }

}
