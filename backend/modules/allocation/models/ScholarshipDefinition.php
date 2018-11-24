<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "scholarship_definition".
 *
 * @property integer $scholarship_id
 * @property string $scholarship_name
 * @property string $scholarship_desc
 * @property string $sponsor
 * @property string $country_of_study
 * @property string $start_year
 * @property string $end_year
 * @property integer $is_active
 * @property string $closed_date
 * @property integer $is_full_scholarship
 *
 * @property ScholarshipLearningInstitution[] $scholarshipLearningInstitutions
 * @property LearningInstitution[] $learningInstitutions
 * @property ScholarshipLoanItem[] $scholarshipLoanItems
 * @property LoanItem[] $loanItems
 * @property ScholarshipProgramme[] $scholarshipProgrammes
 * @property Programme[] $programmes
 * @property ScholarshipStudent[] $scholarshipStudents
 * @property ScholarshipStudyLevel[] $scholarshipStudyLevels
 * @property ApplicantCategory[] $applicantCategories
 */
class ScholarshipDefinition extends \yii\db\ActiveRecord {
    /*
     * constants for Grant types
     */

    const GRANT_TYPE_PARTIAL = 0;
    const GRANT_TYPE_FULL = 1;
    ///grant status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'scholarship_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['scholarship_name', 'scholarship_desc', 'sponsor', 'country_of_study', 'start_year', 'is_full_scholarship', 'is_active'], 'required'],
            [['start_year', 'end_year', 'closed_date'], 'safe'],
            [['is_active', 'is_full_scholarship'], 'integer'],
            [['scholarship_name'], 'string', 'max' => 255],
            [['scholarship_desc'], 'string', 'max' => 300],
            [['sponsor'], 'string', 'max' => 100],
            [['country_of_study'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'scholarship_id' => 'Scholarship ID',
            'scholarship_name' => 'Grant / Scholarship Name',
            'scholarship_desc' => 'Grant / Scholarship Desc',
            'sponsor' => 'Sponsor',
            'country_of_study' => 'Country Of Study',
            'start_year' => 'Start Year',
            'end_year' => 'End Year',
            'is_active' => 'Status',
            'closed_date' => 'Date Closed',
            'is_full_scholarship' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipLearningInstitutions() {
        return $this->hasMany(ScholarshipLearningInstitution::className(), ['scholarship_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutions() {
        return $this->hasMany(LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id'])->viaTable('scholarship_learning_institution', ['scholarship_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(\common\models\Country::className(), ['country_code' => 'country_of_study']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipLoanItems() {
        return $this->hasMany(ScholarshipLoanItem::className(), ['scholarship_definition_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItems() {
        return $this->hasMany(LoanItem::className(), ['loan_item_id' => 'loan_item_id'])->viaTable('scholarship_loan_item', ['scholarship_definition_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipProgrammes() {
        return $this->hasMany(ScholarshipProgramme::className(), ['scholarship_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammes() {
        return $this->hasMany(Programme::className(), ['programme_id' => 'programme_id'])->viaTable('scholarship_programme', ['scholarship_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipStudents() {
        return $this->hasMany(ScholarshipStudent::className(), ['scholarship_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipStudyLevels() {
        return $this->hasMany(ScholarshipStudyLevel::className(), ['scholarship_definition_id' => 'scholarship_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategories() {
        return $this->hasMany(ApplicantCategory::className(), ['applicant_category_id' => 'applicant_category_id'])->viaTable('scholarship_study_level', ['scholarship_definition_id' => 'scholarship_id']);
    }

    static function getGrantTypes() {
        return [
            self::GRANT_TYPE_FULL => 'Full Grant/Scholarship',
            self::GRANT_TYPE_PARTIAL => 'Partial Grant/Scholarship'
        ];
    }

    static function getStatusTypes() {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active'
        ];
    }

    public function getScholarshipTypeName() {
        $types = self::getGrantTypes();

        if (isset($types[$this->is_full_scholarship])) {
            return $types[$this->is_full_scholarship];
        }
        return $this->is_full_scholarship;
    }

    public function getScholarshipStatusName() {
        $types = self::getStatusTypes();
        if (isset($types[$this->is_active])) {
            return $types[$this->is_active];
        }
        return $this->is_active;
    }

}
