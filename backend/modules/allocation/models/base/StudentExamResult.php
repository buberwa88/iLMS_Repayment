<?php

namespace backend\modules\allocation\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "student_exam_result".
 *
 * @property integer $student_exam_result_id
 * @property string $registration_number
 * @property string $f4indexno
 * @property integer $academic_year_id
 * @property integer $programme_id
 * @property integer $study_year
 * @property integer $exam_status_id
 * @property integer $semester
 * @property integer $confirmed
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \backend\modules\allocation\models\AcademicYear $academicYear
 * @property \backend\modules\allocation\models\ExamStatus $examStatus
 * @property \backend\modules\allocation\models\Programme $programme
 * @property \backend\modules\allocation\models\User $createdBy
 */
class StudentExamResult extends \yii\db\ActiveRecord {

    use \mootensai\relation\RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public $file;
    public $students_exam_results_file;
    public $programmeCode;
    public $examStatus1;

    public function relationNames() {
        return [
            'academicYear',
            'examStatus',
            'programme',
            'createdBy'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['registration_number','file','academic_year_id', 'study_year', 'exam_status_id', 'semester','students_exam_results_file'], 'required'],
            [['registration_number', 'academic_year_id', 'study_year', 'exam_status_id', 'semester', 'f4indexno', 'programme_id', 'learning_institution_id'], 'required', 'on' => 'add_students_examination_results'],
            [['academic_year_id', 'programme_id', 'exam_status_id', 'semester', 'status', 'created_by', 'approved_by'], 'integer'],
            [['students_exam_results_file'], 'file', 'extensions' => 'xlsx, xls', 'skipOnEmpty' => true, 'on' => 'students_exam_results_upload'],
            [['students_exam_results_file', 'academic_year_id', 'semester', 'is_last_semester'], 'required', 'on' => 'students_exam_results_upload'],
            [['academic_year_id', 'semester', 'is_last_semester', 'programmeCode', 'examStatus1'], 'required', 'on' => 'students_exam_results_upload2'],
            [['created_at', 'f4indexno', 'approved_by', 'approved_at', 'verified_at', 'verified_by', 'is_last_semester'], 'safe'],
            [['registration_number'], 'string', 'max' => 20],
            [['f4indexno'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'student_exam_result';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'student_exam_result_id' => 'Student Exam Result',
            'registration_number' => 'Registration Number',
            'f4indexno' => 'F4indexno',
            'academic_year_id' => 'Academic Year',
            'programme_id' => 'Programme',
            'study_year' => 'Year of Study',
            'exam_status_id' => 'Exam Status',
            'semester' => 'Semester',
            'status' => 'Status',
            'is_last_semester' => 'Is Last Semester?',
            'students_exam_results_file' => 'Students Exam Results File',
            'programmeCode' => 'Programme',
            'examStatus1' => 'Exam Status',
            'learning_institution_id' => 'Learning Institution'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\backend\modules\allocation\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution() {
        return $this->hasOne(\backend\modules\allocation\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamStatus() {
        return $this->hasOne(\backend\modules\allocation\models\ExamStatus::className(), ['exam_status_id' => 'exam_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme() {
        return $this->hasOne(\backend\modules\allocation\models\Programme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(\backend\modules\allocation\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors() {

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'verified_at',
                'updatedAtAttribute' => 'approved_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'verified_by',
                'updatedByAttribute' => 'approved_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }

    public function upload($date_time) {
        if ($this->validate()) {
            $this->students_exam_results_file->saveAs('upload/' . $date_time . $this->students_exam_results_file->baseName . '.' . $this->students_exam_results_file->extension);
            return true;
        } else {
            $this->students_exam_results_file->saveAs('upload/' . $date_time . $this->students_exam_results_file->baseName . '.' . $this->students_exam_results_file->extension);
            return false;
        }
    }

    public static function formatRowData($rowData) {
        $formattedRowData = str_replace(",", "", str_replace("  ", " ", str_replace("'", "", trim($rowData))));
        return $formattedRowData;
    }

    /*
      public static function insertConfirmedResultsFinalSemister() {
      $condition = ["admission_status" =>1,"has_transfered" =>0];
      self::find()
      ->where($condition)
      ->all();
      foreach($condition AS $results){
      Yii::$app->db->createCommand()
      ->insert('admission_student', [
      'admission_batch_id' => $results->admission_batch_id,
      'f4indexno' => $results->admission_batch_id,
      'programme_id' => $results->admission_batch_id,
      'firstname' => $results->admission_batch_id,
      'middlename' => $results->admission_batch_id,
      'surname' => $results->admission_batch_id,
      'gender' => $results->admission_batch_id,
      'f6indexno' => $results->admission_batch_id,
      'course_code' => $results->admission_batch_id,
      'institution_code' => $results->admission_batch_id,
      'study_year' => $results->admission_batch_id,
      'admission_no' => $results->admission_batch_id,
      'academic_year_id' => $results->admission_batch_id,
      'admission_status' => 1,
      ])->execute();
      $studentsResultsDetails = self::findOne(['student_exam_result_id' => $results->student_exam_result_id]);
      $studentsResultsDetails->confirmed  =  2;
      $studentsResultsDetails->save();
      }
      }
     * 
     */
}
