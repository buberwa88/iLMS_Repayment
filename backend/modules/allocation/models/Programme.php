<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "programme".
 *
 * @property integer $programme_id
 * @property integer $learning_institution_id
 * @property string $programme_code
 * @property string $programme_name
 * @property integer $years_of_study
 *
 * @property AdmittedStudent[] $admittedStudents
 * @property ApplicantProgrammeHistory[] $applicantProgrammeHistories
 * @property Application[] $applications
 * @property Disbursement[] $disbursements
 * @property LearningInstitution $learningInstitution
 * @property ProgrammeFee[] $programmeFees
 * @property SectorProgramme[] $sectorProgrammes
 * @property StudentExamResult[] $studentExamResults
 */
class Programme extends \yii\db\ActiveRecord {

    /// status constant value
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_PENDING = 2;

    //constant for file upload
    //constant for file upload
    public $programe_file;
    public $programmeGcode;
    public $total_programme_cost;
    public $academic_year;
    public $year_of_study;
    ///fied to be used whilecloning
    public $source_academic_year;
    public $destination_academic_year;
    public $loan_items;
    public $source_study_year;
    public $destination_study_year;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'programme';
    }

    /**
     * @inheritdoc 
     */
    public $institution_code;
    public function rules() {
        return [
            [['learning_institution_id', 'programme_name', 'years_of_study'], 'required'],
            [['programe_file'], 'file', 'extensions' => 'xlsx, xls', 'skipOnEmpty' => true, 'on' => 'programme_bulk_upload'],
            [['programe_file'], 'required', 'on' => 'programme_bulk_upload'],
            [['programme_name'], 'validateProgrammes'],
            [['programme_code'], 'validateProgrammeCode'],
            [['years_of_study'], 'integer'],
            [['learning_institution_id'], 'required', 'on' => 'programme_bulk_upload3'],
            [['programme_code'], 'string', 'max' => 10],
            [['programme_name'], 'string', 'max' => 150],
            //[['programme_code'], 'unique'],
            [['programme_group_id', 'is_active', 'programmeGcode', 'institution_code', 'academic_year', 'total_programme_cost','year_of_study'], 'safe'],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'programme_id' => 'Programme ',
            'learning_institution_id' => 'Learning Institution',
            'programme_code' => 'Programme Code',
            'programme_name' => 'Programme Name',
            'is_active' => 'Status',
            'years_of_study' => 'Years of Study',
            'programme_group_id' => 'Programme Group',
            'programmeGcode' => 'programmeGcode',
            'programe_file' => 'Upload File',
            'institution_code' => 'Institution Code',
            'source_academic_year' => 'Source Academic Year',
            'destination_academic_year' => 'Destination Academic Year',
            'loan_items' => 'Loan Items',
            'source_study_year' => 'Source Study Year',
            'destination_study_year' => 'Destination Study Year',
            'total_programme_cost' => 'Total Programme Cost',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmittedStudents() {
        return $this->hasMany(AdmittedStudent::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantProgrammeHistories() {
        return $this->hasMany(ApplicantProgrammeHistory::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications() {
        return $this->hasMany(Application::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursements() {
        return $this->hasMany(Disbursement::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution() {
        return $this->hasOne(\backend\modules\application\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeFees() {
        return $this->hasMany(ProgrammeCost::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeGroup() {
        return $this->hasOne(ProgrammeGroup::className(), ['programme_group_id' => 'programme_id']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstituition() {
        return $this->hasOne(LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorProgrammes() {
        return $this->hasMany(SectorProgramme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults() {
        return $this->hasMany(StudentExamResult::className(), ['programme_id' => 'programme_id']);
    }

    public static function getProgrammeName($programme_category_id, $academic_year) {
        //get all programme in the academic year
        $modelprogram = Yii::$app->db->createCommand("SELECT group_concat(`programme_id`) as programmeId FROM `cluster_programme` WHERE `academic_year_id`='{$academic_year}'")->queryAll();
        $arraydata = "";
        $condition = "";
        if (count($modelprogram) > 0) {
            foreach ($modelprogram as $rows)
                ;
            $arraydata = $rows["programmeId"];
            $condition = " AND programme_id NOT IN($arraydata)";
        }
        ///
        //
      //print_r($rows);
        // exit();
        //end 
        $sql = Programme::find()->where("programme_category_id IN($programme_category_id) $condition")->asArray()->all();
        foreach ($sql as $rows) {
            $programme_id = $rows["programme_id"];
            $programme_name = $rows["programme_name"];
            $data2[] = array('id' => $programme_id, 'name' => $programme_name);
        }
        //print_r($tablecolumn);
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;
    }

    static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    public function getStatusNameByValue() {
        if ($this->is_active >= 0) {
            $statuses = self::getStatusList();
            if (isset($statuses[$this->is_active])) {
                return $statuses[$this->is_active];
            }
        }
        return NULL;
    }

    /*
     * returns the list(programme_id,programme_name) of thr Programmed per given Learning institution
     */

    public static function getProgrammesByLearningInstitutionId($learningId, $isActive = NULL) {
        $condition = ["learning_institution_id" => $learningId];
        if ($isActive) {
            $condition['is_active'] = $isActive;
        }
        return self::find()
                        ->where($condition)
                        ->asArray()->all();
    }

    public static function getProgrammesByProgrammeGroupId($Programme_group_id, $isActive = NULL) {
        $condition = ["programme_group_id" => $Programme_group_id];
        if ($isActive) {
            $condition['is_active'] = $isActive;
        }
        return self::find()
                        ->where($condition)
                        ->all();
    }

    public static function getProgrammesByProgrammeGroupId2($Programme_group_id) {
        $programmeDetails = Programme::findBySql("SELECT * FROM programme WHERE programme_group_id='" . $Programme_group_id . "' AND is_active='1' ORDER BY programme_id ASC")->all();
        return $programmeDetails;
    }

    public static function insertProgrammes($Programme_group_id, $programme_id, $created_at, $created_by, $cluster_definition_id, $academic_year_id, $programme_category_id, $programme_priority) {
        Yii::$app->db->createCommand()
                ->insert('cluster_programme', [
                    'programme_group_id' => $Programme_group_id,
                    'programme_id' => $programme_id,
                    'created_at' => $created_at,
                    'created_by' => $created_by,
                    'cluster_definition_id' => $cluster_definition_id,
                    'academic_year_id' => $academic_year_id,
                    'programme_category_id' => $programme_category_id,
                    'updated_at' => $created_at,
                    'updated_by' => $created_by,
                    'programme_priority' => $programme_priority,
                ])->execute();
    }

    public function upload($date_time) {
        if ($this->validate()) {
            $this->programe_file->saveAs('upload/' . $date_time . $this->programe_file->baseName . '.' . $this->programe_file->extension);
            return true;
        } else {
            $this->programe_file->saveAs('upload/' . $date_time . $this->programe_file->baseName . '.' . $this->programe_file->extension);
            return false;
        }
    }

    public static function formatRowData($rowData) {
        $formattedRowData = str_replace(",", "", str_replace("  ", " ", str_replace("'", "", trim($rowData))));
        return $formattedRowData;
    }
    
    public function validateProgrammes($attribute) {
        if ($attribute && $this->learning_institution_id && ($this->programme_name OR $this->programme_code)) {
            if (self::find()->where('learning_institution_id=:institution_id AND programme_name=:programme_name', [':institution_id' => $this->learning_institution_id, ':programme_name' => $this->programme_name]
                    )->exists()) {
                $this->addError('$attribute', $this->programme_name .' already exists');
                return FALSE;
            }
        }
        return true;
    }
    
     public function validateProgrammeCode($attribute) {
        if ($attribute && $this->learning_institution_id && ($this->programme_name OR $this->programme_code)) {
            if (self::find()->where('learning_institution_id=:institution_id AND programme_code=:programme_code', [':institution_id' => $this->learning_institution_id, ':programme_code' => $this->programme_code]
                    )->exists()) {
                $this->addError('$attribute',$this->programme_code . ' already exists');
                return FALSE;
            }
        }
        return true;
    }
    
    public static function getProgrammeByProgrammeCode($programmeCode) {
        $condition = ["programme_code" => $programmeCode];
        return self::find()
                        ->select("programme.programme_id AS programme_id,learning_institution.institution_code AS institution_code")
                        ->joinWith("learningInstituition")
                        ->where($condition)
                        ->one();
    }
    
}
