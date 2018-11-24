<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "admission_student".
 *
 * @property integer $admission_student_id
 * @property integer $admission_batch_id
 * @property string $f4indexno
 * @property integer $programme_id
 * @property integer $has_transfered
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $gender
 * @property string $f6indexno
 * @property double $points
 * @property string $course_code
 * @property string $course_description
 * @property string $institution_code
 * @property string $course_status
 * @property string $entry
 * @property string $study_year
 * @property string $admission_no
 * @property integer $academic_year_id
 * @property integer $admission_status
 * @property string $transfer_date
 *
 * @property AdmissionBatch $admissionBatch
 * @property Programme $programme
 * @property AcademicYear $academicYear
 */
class AdmissionStudent extends \yii\db\ActiveRecord {

///adimission verification constants
    const STATUS_NOT_CONFIRMED = 0;
    const STATUS_VERIFIED = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_DECEASED = 3;
    ////
    ////stdudent report confirmation
    const HAS_REPORTED_YES = 1;
    const HAS_REPORTED_NO = 0;
    ///admission type
    const ADMISSION_TYPE_FRESHERS = 0;
    const ADMISSION_TYPE_CONTINUING = 1;
    ////stdudent transfers
    const HAS_NO_TRANSFER = 0;
    const HAS_TRANSFER_INITIATED = 1;
    const HAS_TRANSFER_COMPLETED = 2;
    ///programme Status
    const PROGRAMME_STATUS_NOT_MATCH = 0;
    const PROGRAMME_STATUS_MATCH = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admission_student';
    }

    /**
     * @inheritdoc
     */
    //public $academic_year_id;
    public $batch_number;
    public $batch_desc;
    public $learning_institution_id;
    public $students_admission_file;

    public function rules() {
        return [
            [['admission_batch_id', 'programme_id', 'has_transfered', 'academic_year_id', 'admission_status', 'learning_institution_id'], 'integer'],
            //[['f4indexno', 'firstname', 'surname', 'course_code', 'institution_code', 'study_year', 'academic_year_id','batch_number','batch_desc','students_admission_file'], 'required'],
            //[['f4indexno', 'firstname', 'surname', 'course_code', 'institution_code', 'study_year', 'academic_year_id','batch_number','batch_desc','students_admission_file'], 'required'],
            [['students_admission_file'], 'file', 'extensions' => 'xlsx, xls', 'skipOnEmpty' => true, 'on' => 'students_admission_bulk_upload'],
            [['students_admission_file', 'learning_institution_id', 'academic_year_id', 'batch_number', 'batch_desc'], 'required', 'on' => 'students_admission_bulk_upload'],
            [['admission_batch_id', 'academic_year_id', 'course_code'], 'required', 'on' => 'students_admission_bulk_upload2'],
            [['points'], 'number'],
            [['course_code'], 'validateProgrammeCodeAndInstitutions'],
            [['course_description'], 'string'],
            [['f4indexno', 'firstname', 'middlename', 'surname', 'transfer_date'], 'string', 'max' => 45],
            [['gender'], 'string', 'max' => 2],
            [['f6indexno', 'course_code', 'institution_code'], 'string', 'max' => 100],
            [['course_status', 'entry'], 'string', 'max' => 200],
            [['admission_no'], 'string', 'max' => 50],
            [['batch_number'], 'string', 'max' => 10],
            //[['f4indexno'], 'unique'],
            /// [['admission_batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdmissionBatch::className(), 'targetAttribute' => ['admission_batch_id' => 'admission_batch_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'admission_student_id' => 'Admission Student ID',
            'admission_batch_id' => 'Admission Batch ID',
            'f4indexno' => 'F4indexno',
            'programme_id' => 'Programme ID',
            'has_transfered' => 'Has Transfered',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'gender' => 'Gender',
            'f6indexno' => 'F6indexno',
            'points' => 'Points',
            'course_code' => 'Course Code',
            'course_description' => 'Course Description',
            'institution_code' => 'Institution Code',
            'course_status' => 'Course Status',
            'entry' => 'Entry',
            'study_year' => 'Study Year',
            'admission_no' => 'Admission No',
            'academic_year_id' => 'Academic Year ID',
            'admission_status' => 'Admission Status',
            'transfer_date' => 'Transfer Date',
            'students_admission_file' => 'Students Admission File',
            'academic_year_id' => 'Academic Year',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmissionBatch() {
        return $this->hasOne(AdmissionBatch::className(), ['admission_batch_id' => 'admission_batch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramme() {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    public function upload($date_time) {
        if ($this->validate()) {
            $this->students_admission_file->saveAs('upload/' . $date_time . $this->students_admission_file->baseName . '.' . $this->students_admission_file->extension);
            return true;
        } else {
            $this->students_admission_file->saveAs('upload/' . $date_time . $this->students_admission_file->baseName . '.' . $this->students_admission_file->extension);
            return false;
        }
    }

    public static function formatRowData($rowData) {
        $formattedRowData = str_replace(",", "", str_replace("  ", " ", str_replace("'", "", trim($rowData))));
        return $formattedRowData;
    }

    public function validateProgrammeCodeAndInstitutions($attribute) {
        //if ($attribute && ($this->programme_id OR  $this->institution_code)) {
        if ($this->programme_id == '' OR $this->institution_code == '') {
            $this->addError($attribute, $this->course_code . ' Programme code or Institution Code does not exit');
            return FALSE;
        }
        //}
        return true;
    }

    static function getLatestAdmissionByF4IndexNo($f4_indexno, $reg_no = NULL) {
        if ($f4_indexno && $reg_no) {
            return self::find('student_reg_no =:reg_no AND f4indexno=:f4indexno', [':reg_no' => $reg_no, ':f4indexno' => $f4_indexno])->one();
        } elseif ($f4_indexno) {
            return self::find('f4indexno=:f4indexno', [':f4indexno' => $f4_indexno])->one();
        }
        return NULL;
    }

    function validFresherStudentAdmissionByID($id) {
        return self::find()
                        ->where(['admission_student_id' => $id, 
                            'study_year' => 1,
                            'programme_status' => AdmissionStudent::PROGRAMME_STATUS_MATCH, 
                            'admission_type' => AdmissionStudent::ADMISSION_TYPE_FRESHERS])
                        ->andWhere('programme_id > 0')//endure prgramme ID exist
                        ->one();
    }

}
