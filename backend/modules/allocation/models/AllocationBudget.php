<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "allocation_budget".
 *
 * @property integer $allocation_budget_id
 * @property double $budget_amount
 * @property integer $academic_year_id
 * @property string $applicant_category
 * @property integer $study_level
 * @property string $place_of_study
 * @property string $budget_scope
 * @property integer $is_active
 *
 * @property AcademicYear $academicYear
 * @property ApplicantCategory $studyLevel
 */
class AllocationBudget extends \yii\db\ActiveRecord {
    /*
     * constans for place of study
     */

    const PLACE_OF_STUDY_TZ = 'TZ';
    const PLACE_OF_STUDY_FOREIGN_COUNRT = 'FCOUNTRY';

    /*
     * constants for llocation budget s
     */
    const BUDGET_SCOPE_FRESHERS = 0;
    const BUDGET_SCOPE_CONTINUING = 1;

    /*
     * allocation status
     */
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /*
     * applicant category
     */
    const APPLICANT_CATEGORY_NORMAL = 'normal';
    const APPLICANT_CATEGOGY_GRANT = 'scholarship';

    public $entry;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'allocation_budget';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['budget_amount', 'academic_year_id', 'applicant_category', 'study_level', 'place_of_study', 'budget_scope'], 'required'],
            [['budget_amount'], 'number'],
            [['academic_year_id', 'study_level', 'is_active'], 'integer'],
            [['applicant_category', 'place_of_study', 'budget_scope'], 'string'],
            [['place_of_study'], 'validatePlaceOfStudy'],
            [['academic_year_id', 'applicant_category', 'study_level', 'place_of_study', 'budget_scope'], 'validEntry'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['study_level'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicantCategory::className(), 'targetAttribute' => ['study_level' => 'applicant_category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'allocation_budget_id' => 'Allocation Budget ID',
            'budget_amount' => 'Budget Amount',
            'academic_year_id' => 'Academic Year ID',
            'applicant_category' => 'Applicant Category',
            'study_level' => 'Level of Study',
            'place_of_study' => 'Place Of Study',
            'budget_scope' => 'Budget Scope',
            'is_active' => 'Status',
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
    public function getStudyLevel() {
        return $this->hasOne(ApplicantCategory::className(), ['applicant_category_id' => 'study_level']);
    }

    function getPlaceOfStudies() {
        return array(
            self::PLACE_OF_STUDY_TZ => 'Local/Tanzania',
            self::PLACE_OF_STUDY_FOREIGN_COUNRT => 'Abroad/Foreign Country'
        );
    }

    function getPlaceOfStudy() {
        $data = $this->getPlaceOfStudies();
        if ($data[$this->place_of_study]) {
            return $data[$this->place_of_study];
        }
        return NULL;
    }

    function getScopeList() {
        return array(
            self::BUDGET_SCOPE_FRESHERS => 'Freshers Student Budget',
            self::BUDGET_SCOPE_CONTINUING => 'Continuting Student Budget'
        );
    }

    function getStatusList() {
        return array(
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'In-Active'
        );
    }

    function applicantCategoryList() {
        return [
            self::APPLICANT_CATEGORY_NORMAL => 'normal',
            self::APPLICANT_CATEGOGY_GRANT => 'scholarship'
        ];
    }

    function getStatusName() {
        $data = $this->getStatusList();
        if ($data && $data[$this->is_active]) {
            return $data[$this->is_active];
        }
    }

    function getScopeName() {
        $data = $this->getScopeList();
        if ($data && $data[$this->budget_scope]) {
            return $data[$this->budget_scope];
        }
    }

    function validEntry($attribute) {
        if (self::find()->where(
                        [
                            'academic_year_id' => $this->academic_year_id,
                            'applicant_category' => $this->applicant_category,
                            'study_level' => $this->study_level,
                            'place_of_study' => $this->place_of_study,
                            'budget_scope' => $this->budget_scope,
                        ]
                )->exists()) {
            $this->addError($attribute, 'Records provided already exist in the system for this academic year');
            return FALSE;
        }
    }

    function validatePlaceOfStudy($attribute) {
        if ($this->applicant_category && $this->place_of_study) {
            if ($this->applicant_category == self::APPLICANT_CATEGORY_NORMAL && $this->place_of_study == self::PLACE_OF_STUDY_FOREIGN_COUNRT)
                $this->addError($attribute, 'Wrong value selected. Selected value is not applicable for Students Studying in Foreign Country');
            return FALSE;
        }
    }

    static function getAllocationBudgetByAcademicYearApplicantCategoryStudyLevelPlaceOfStudy($academicYr, $applicantCategory, $studyLevel, $placeOfStudy) {
        return self::find()->where(
                                ['academic_year_id' => $academicYr,
                                    'applicant_category' => $applicantCategory,
                                    'study_level' => $studyLevel,
                                    'place_of_study' => $placeOfStudy,
                                    'is_active' => self::STATUS_ACTIVE
                                ]
                        )->andWhere('budget_amount>0 AND budget_amount > budget_consumed')
                        ->one();
    }

}
