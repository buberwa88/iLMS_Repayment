<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "education".
 *
 * @property integer $education_id
 * @property integer $application_id
 * @property string $level
 * @property integer $learning_institution_id
 * @property string $registration_number
 * @property string $programme_name
 * @property string $programme_code
 * @property integer $entry_year
 * @property integer $completion_year
 * @property integer $division
 * @property double $points
 * @property integer $is_necta
 * @property string $class_or_grade
 * @property double $gpa_or_average
 * @property string $avn_number
 * @property integer $under_sponsorship
 * @property string $sponsor_proof_document
 *
 * @property Application $application
 * @property LearningInstitution $learningInstitution
 */
class Education extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'level', 'registration_number', 'entry_year', 'completion_year', 'avn_number'], 'required'],
            [['application_id', 'learning_institution_id', 'entry_year', 'completion_year', 'division', 'is_necta', 'under_sponsorship'], 'integer'],
            [['level'], 'string'],
            [['points', 'gpa_or_average'], 'number'],
            [['registration_number', 'avn_number'], 'string', 'max' => 40],
            [['programme_name'], 'string', 'max' => 70],
            [['programme_code', 'class_or_grade'], 'string', 'max' => 20],
            [['sponsor_proof_document'], 'string', 'max' => 200],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'education_id' => 'Education ID',
            'application_id' => 'Application ID',
            'level' => 'Level',
            'learning_institution_id' => 'Learning Institution ID',
            'registration_number' => 'Registration Number',
            'programme_name' => 'Programme Name',
            'programme_code' => 'Programme Code',
            'entry_year' => 'Entry Year',
            'completion_year' => 'Completion Year',
            'division' => 'Division',
            'points' => 'Points',
            'is_necta' => 'Is Necta',
            'class_or_grade' => 'Class Or Grade',
            'gpa_or_average' => 'Gpa Or Average',
            'avn_number' => 'Avn Number',
            'under_sponsorship' => 'Under Sponsorship',
            'sponsor_proof_document' => 'Sponsor Proof Document',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(\backend\modules\application\models\Application::className(), ['application_id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution()
    {
        return $this->hasOne(\backend\modules\allocation\models\LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }
}
