<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "scholarship_learning_institution".
 *
 * @property integer $scholarship_id
 * @property integer $learning_institution_id
 * @property string $created_at
 * @property integer $is_active
 * @property integer $academic_year_id
 *
 * @property LearningInstitution $learningInstitution
 * @property ScholarshipDefinition $scholarship
 * @property AcademicYear $academicYear
 */
class ScholarshipLearningInstitution extends \yii\db\ActiveRecord {

///institution status constant value
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'scholarship_learning_institution';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['scholarship_id', 'learning_institution_id', 'academic_year_id'], 'required'],
            [['scholarship_id', 'learning_institution_id', 'is_active', 'academic_year_id'], 'integer'],
            [['created_at'], 'safe'],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
            [['scholarship_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScholarshipDefinition::className(), 'targetAttribute' => ['scholarship_id' => 'scholarship_id']],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'scholarship_id' => 'Scholarship',
            'learning_institution_id' => 'Institution',
            'created_at' => 'Created At',
            'is_active' => 'Status',
            'academic_year_id' => 'Academic Year',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution() {
        return $this->hasOne(LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarship() {
        return $this->hasOne(ScholarshipDefinition::className(), ['scholarship_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    static function getInstitutionsById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\ScholarshipLearningInstitution::find()->where(['scholarship_id' => $id]),
        ]);
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

}
