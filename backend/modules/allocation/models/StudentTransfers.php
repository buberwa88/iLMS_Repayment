<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "student_transfers".
 *
 * @property integer $student_transfer_id
 * @property integer $application_id
 * @property integer $programme_from
 * @property integer $programme_to
 * @property string $date_initiated
 * @property string $date_completed
 * @property integer $effetive_study_year
 * @property integer $admitted_student_id
 *
 * @property Application $application
 * @property Programme $programmeTo
 */
class StudentTransfers extends \yii\db\ActiveRecord {

    public $institution; ///for carrying aout the institution value

    const STATUS_INITIATES = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELLED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'student_transfers';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['student_f4indexno', 'student_reg_no', 'programme_from', 'programme_to', 'date_initiated', 'admitted_student_id', 'academic_year_id', 'status'], 'required'],
            [['programme_from', 'programme_to', 'effective_study_year', 'admitted_student_id'], 'integer'],
            [['date_initiated', 'date_completed', 'institution'], 'safe'],
            [['programme_to'], 'exist', 'skipOnError' => true, 'targetClass' => Programme::className(), 'targetAttribute' => ['programme_to' => 'programme_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'student_transfer_id' => 'Student Transfer ID',
            'programme_from' => 'Current Programme',
            'programme_to' => 'New Programme',
            'date_initiated' => 'Date Initiated',
            'date_completed' => 'Date Completed',
            'effective_study_year' => 'Effective Study Year',
            'admitted_student_id' => 'Admitted Student ID',
            'academic_year_id' => 'Academic Year',
            'status' => 'Status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication() {
        return $this->hasOne(Application::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeTo() {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_to']);
    }

    public function getProgrammeFrom() {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_from']);
    }

    public function getAcademicYear() {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    static function getStatuslist() {
        return [
            self::STATUS_INITIATES => 'Initiated',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled'
        ];
    }

    function getStatusName() {
        $data = self::getStatuslist();
        if ($data[$this->status]) {
            return $data[$this->status];
        }
    }

}
