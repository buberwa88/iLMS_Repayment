<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\StudentExamResult as BaseStudentExamResult;

/**
 * This is the model class for table "student_exam_result".
 */
class StudentExamResult extends BaseStudentExamResult {

    const STATUS_CONFIRMED = 2;
    const STATUS_VERIFIED = 1;
    const STATUS_DRAFT = 0;
    const IS_BENEFICIARY_YES = 1;
    const IS_BENEFICIARY_NO = 0;

    /**
     * @inheritdoc
     */
    public $file;

    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['programme_id', 'registration_number', 'academic_year_id', 'learning_institution_id', 'study_year', 'exam_status_id', 'semester', 'status', 'is_last_semester'], 'required'],
//            [['f4indexno'], 'required', 'on' => 'add_students_examination_results'],
            [['academic_year_id', 'programme_id', 'exam_status_id', 'semester', 'status', 'created_by'], 'integer'],
            [['students_exam_results_file'], 'file', 'extensions' => 'xlsx, xls', 'skipOnEmpty' => true, 'on' => 'students_exam_results_upload'],
            [['students_exam_results_file', 'academic_year_id', 'semester', 'is_last_semester'], 'required', 'on' => 'students_exam_results_upload'],
            [['academic_year_id', 'semester', 'is_last_semester'], 'required', 'on' => 'students_exam_results_upload2'],
//            [['registration_number'], 'validStudent'],
            [['created_at', 'f4indexno', 'approved_by', 'approved_at', 'verified_at', 'verified_by'], 'safe'],
            [['registration_number'], 'string', 'max' => 20],
            [['f4indexno'], 'string', 'max' => 45]
        ]);
    }

    public static function findProgramme($programme_code, $registration_number, $yos) {
        $model = Yii::$app->db->createCommand("SELECT pr.`programme_id` programme_id FROM `application` ap  join  programme pr   on ap.`programme_id`=pr.`programme_id`  where `programme_code`='{$programme_code}' AND `registration_number`='{$registration_number}' AND `current_study_year`='{$yos}'
                      ")->queryone();
        if (count($model) > 0) {
            return $model["programme_id"];
        }
        return -1;
    }

    public function validStudent() {
        if ($this->study_year && $this->programme_id && $this->academic_year_id && ($this->registration_number OR $this->f4indexno)) {
            $exist = AdmissionStudent::find()
                    ->where([
                        'programme_id' => $this->programme_id,
                        'study_year' => $this->study_year,
                        'academic_year_id' => $this->academic_year_id,
                        'admission_status' => AdmissionStudent::STATUS_CONFIRMED,
                        'has_reported' => AdmissionStudent::HAS_REPORTED_YES
                    ])->andWhere('admission_no=:registration_number OR f4indexno=:f4indexno', [':f4indexno' => $this->f4indexno, ':registration_number' => $this->registration_number])
                    ->exists();
            if (!$exist) {
                $this->addError('registration_number', 'No Student Admission data for the Selected Academic Year');
                return FALSE;
            }
        }
        return TRUE;
    }

}
