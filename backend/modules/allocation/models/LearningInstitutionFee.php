<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\LearningInstitutionFee as BaseLearningInstitutionFee;

/**
 * This is the model class for table "learning_institution_fee".
 */
class LearningInstitutionFee extends BaseLearningInstitutionFee {

    public $source_academic_year;
    public $destination_academic_year;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['learning_institution_id', 'academic_year_id', 'study_level', 'fee_amount'], 'required', 'on' => 'create_update'],
            [['destination_academic_year', 'source_academic_year'], 'required', 'on' => 'clone_fee'],
            [['learning_institution_id', 'academic_year_id', 'created_by', 'updated_by'], 'integer', 'on' => 'create_update'],
            [['study_level', 'fee_amount'], 'number', 'on' => 'create_update'],
            [['learning_institution_id', 'academic_year_id'], 'validateFee', 'on' => 'create_update'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }

    function validateFee($attribute) {
        if ($attribute) {
            $exist = self::find()
                            ->where([
                                'learning_institution_id' => $this->learning_institution_id,
                                'academic_year_id' => $this->academic_year_id,
                                'study_level' => $this->study_level,
                            ])->exists();
            if ($exist) {
                $this->addError($attribute, 'Fee setting already exist for this academic year please check');
                return FALSE;
            }
            return TRUE;
        }
    }

    static function getSchoolFeesByAcademicYearID($academic_year_id) {
        return self::find()
                        ->join('INNER JOIN', 'learning_institution', 'learning_institution_fee.learning_institution_id=learning_institution.learning_institution_id')
                        ->where(['academic_year_id' => $academic_year_id,'learning_institution.is_active'=>  LearningInstitution::STATUS_ACTIVE])
                        ->andWhere('learning_institution.institution_type !=:university', [':university' => LearningInstitution::INSTITUTION_TYPE_UNIVERSITY])
                        ->all();
    }

}
