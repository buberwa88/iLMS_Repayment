<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "criteria_field".
 *
 * @property integer $criteria_field_id
 * @property integer $criteria_id
 * @property integer $applicant_category_id
 * @property string $source_table
 * @property string $source_table_field
 * @property string $operator
 * @property string $value
 * @property integer $parent_id
 * @property string $join_operator
 * @property integer $academic_year_id
 * @property integer $type
 * @property double $weight_points
 * @property double $priority_points
 *
 * @property AcademicYear $academicYear
 * @property ApplicantCategory $applicantCategory
 * @property Criteria $criteria
 * @property CriteriaField $parent
 * @property CriteriaField[] $criteriaFields
 */
class CriteriaField extends \yii\db\ActiveRecord {

    const CRITERIA_FIELD_TYPE_ELIGIBILITY = 1;
    const CRITERIA_FIELD_TYPE_NEEDNESS = 2;
    const CRITERIA_FIELD_TYPE_RESOURCE = 3;
    const CRITERIA_FIELD_TYPE_ALLOCATION = 4;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'criteria_field';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['criteria_id', 'applicant_category_id', 'source_table', 'source_table_field', 'operator', 'value'], 'required'],
            [['criteria_id', 'applicant_category_id', 'parent_id', 'academic_year_id', 'type'], 'integer'],
            [['operator', 'join_operator'], 'string'],
            [['weight_points', 'priority_points'], 'number'],
            [['source_table', 'source_table_field'], 'string', 'max' => 30],
            [['value'], 'string', 'max' => 20],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['applicant_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\ApplicantCategory::className(), 'targetAttribute' => ['applicant_category_id' => 'applicant_category_id']],
            [['criteria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Criteria::className(), 'targetAttribute' => ['criteria_id' => 'criteria_id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => CriteriaField::className(), 'targetAttribute' => ['parent_id' => 'criteria_field_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'criteria_field_id' => 'Criteria Field ID',
            'criteria_id' => 'Criteria ID',
            'applicant_category_id' => 'Applicant Category',
            'source_table' => 'Source Table',
            'source_table_field' => 'Source Table Field',
            'operator' => 'Operator',
            'value' => 'Value',
            'parent_id' => 'Parent ',
            'join_operator' => 'Join Operator',
            'academic_year_id' => 'Academic Year',
            'type' => 'Context/Type',
            'weight_points' => 'Weight',
            'priority_points' => 'Priority',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategory() {
        return $this->hasOne(\backend\modules\application\models\ApplicantCategory::className(), ['applicant_category_id' => 'applicant_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteria() {
        return $this->hasOne(Criteria::className(), ['criteria_id' => 'criteria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(CriteriaField::className(), ['criteria_field_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaFields() {
        return $this->hasMany(CriteriaField::className(), ['parent_id' => 'criteria_field_id']);
    }

    public function getTypeName() {
        if ($this->type == 1) {
            $status = "Eligibility";
        } else if ($this->type == 2) {
            $status = "Needness";
        } else if ($this->type == 3) {
            $status = "Source";
        }
        return $status;
    }

    static function getCriteriaFieldTypes() {
        return [
            self::CRITERIA_FIELD_TYPE_ELIGIBILITY => 'Eligibility',
            self::CRITERIA_FIELD_TYPE_NEEDNESS => 'Needness',
            self::CRITERIA_FIELD_TYPE_RESOURCE => 'Resource',
            self::CRITERIA_FIELD_TYPE_ALLOCATION => 'Allocation'
        ];
    }

    static function getCriteriaFieldTypeNameByValue($value) {
        if ($value) {
            $data = self::getCriteriaFieldTypes();
            if (isset($data[$value])) {
                return $data[$value];
            }
        }
        return NULL;
    }

    function getCriteriaFieldSourceTables() {
        return [
            'admission_student' => 'admission_student',
            'applicant' => 'applicant',
            'applicant_associate' => 'applicant_associate',
            'applicant_attachment' => 'applicant_attachment',
            'applicant_category' => 'applicant_category',
            'applicant_category_attachment' => 'applicant_category_attachment',
            'applicant_criteria_score' => 'applicant_criteria_score',
            'applicant_programme_history' => 'applicant_programme_history',
            'applicant_qn_response' => 'applicant_qn_response',
            'application' => 'application',
            'occupation' => 'occupation',
            'nature_of_work' => 'nature_of_work',
            'programme_group' => 'programme_group',
            'programme_category' => 'programme_category',
            'programme' => 'programme',
            'student_exam_result' => 'student_exam_result',
            'student_transfers' => 'student_transfers',
            'education' => 'education',
        ];
    }

}
