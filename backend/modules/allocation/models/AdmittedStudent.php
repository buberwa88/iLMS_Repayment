<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "admitted_student".
 *
 * @property integer $admitted_student_id
 * @property integer $admission_batch_id
 * @property string $f4indexno
 * @property integer $programme_id
 * @property integer $has_transfered
 *
 * @property AdmissionBatch $admissionBatch
 * @property Programme $programme
 */
class AdmittedStudent extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admitted_student';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['programme_id'], 'safe'],
            [['admission_batch_id', 'f4indexno'], 'required'],
            [['admission_batch_id', 'programme_id', 'has_transfered'], 'integer'],
            [['f4indexno'], 'string', 'max' => 45],
            [['f4indexno'], 'unique'],
            [['admission_batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdmissionBatch::className(), 'targetAttribute' => ['admission_batch_id' => 'admission_batch_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'admitted_student_id' => 'Admitted Student',
            'admission_batch_id' => 'Admission Batch',
            'f4indexno' => 'F4 IndexNo',
            'programme_id' => 'Programme',
            'has_transfered' => 'Transfer Status',
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

    static function validateLastYearExamResults($f4indexno, $programme_id, $current_academic_year_id, $current_study_year) {
        $exists = self::find()
                        ->where("study_year=!=study_year AND f4indexno=:f4indexno AND status=:status AND programme_id=:programme_id
                          AND is_last_semester=:is_last_semester AND is_beneficiary=:is_beneficiary 
                          AND academic_year_id !=:academic_year_id", [
                            ':study_year' => ($current_study_year - 1),
                            ':f4indexno' => $f4indexno,
                            ':programme_id' => $programme_id,
                            ':status' => 2, ':is_last_semester' => 1, ':is_beneficiary' => 1,
                            ':academic_year_id' => $current_academic_year_id
                                ]
                        )->exists();
        if ($exists) {
            return TRUE;
        }
        return FALSE;
    }

}
