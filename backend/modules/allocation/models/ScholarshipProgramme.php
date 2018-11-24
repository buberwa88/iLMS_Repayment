<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "scholarship_programme".
 *
 * @property integer $scholarship_id
 * @property integer $programme_id
 * @property string $created_at
 * @property integer $is_active
 * @property integer $academic_year_id
 *
 * @property AcademicYear $academicYear
 * @property Programme $programme
 * @property ScholarshipDefinition $scholarship
 * @property ScholarshipProgrammeLoanItem[] $scholarshipProgrammeLoanItems
 * @property LoanItem[] $loanItems
 */
class ScholarshipProgramme extends \yii\db\ActiveRecord {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'scholarship_programme';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['scholarship_id', 'programme_id', 'academic_year_id'], 'required'],
            [['scholarship_id', 'programme_id', 'is_active', 'academic_year_id'], 'integer'],
            [['created_at'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['programme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programme::className(), 'targetAttribute' => ['programme_id' => 'programme_id']],
            [['scholarship_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScholarshipDefinition::className(), 'targetAttribute' => ['scholarship_id' => 'scholarship_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'scholarship_id' => 'Scholarship',
            'programme_id' => 'Programme Name',
            'created_at' => 'Created At',
            'is_active' => 'Status',
            'academic_year_id' => 'Academic Year',
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
    public function getProgramme() {
        return $this->hasOne(Programme::className(), ['programme_id' => 'programme_id']);
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
    public function getScholarshipProgrammeLoanItems() {
        return $this->hasMany(ScholarshipProgrammeLoanItem::className(), ['scholarships_id' => 'scholarship_id', 'programme_id' => 'programme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItems() {
        return $this->hasMany(LoanItem::className(), ['loan_item_id' => 'loan_item_id'])->viaTable('scholarship_programme_loan_item', ['scholarships_id' => 'scholarship_id', 'programme_id' => 'programme_id']);
    }

    static function getProgrammesById($id) {
        return new \yii\data\ActiveDataProvider([
            'query' => \backend\modules\allocation\models\ScholarshipProgramme::find()->where(['scholarship_id' => $id]),
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
