<?php

namespace frontend\modules\application\models;

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
class Programme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'programme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['learning_institution_id', 'years_of_study'], 'integer'],
            [['programme_code'], 'string', 'max' => 10],
            [['programme_name'], 'string', 'max' => 100],
            [['programme_code'], 'unique'],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'programme_id' => 'Programme ID',
            'learning_institution_id' => 'Learning Institution ID',
            'programme_code' => 'Programme Code',
            'programme_name' => 'Programme Name',
            'years_of_study' => 'Years Of Study',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmittedStudents()
    {
        return $this->hasMany(AdmittedStudent::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantProgrammeHistories()
    {
        return $this->hasMany(ApplicantProgrammeHistory::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursements()
    {
        return $this->hasMany(Disbursement::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution()
    {
        return $this->hasOne(LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammeFees()
    {
        return $this->hasMany(ProgrammeFee::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectorProgrammes()
    {
        return $this->hasMany(SectorProgramme::className(), ['programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentExamResults()
    {
        return $this->hasMany(StudentExamResult::className(), ['programme_id' => 'programme_id']);
    }
}
