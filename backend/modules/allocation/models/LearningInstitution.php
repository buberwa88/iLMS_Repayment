<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\LearningInstitution as BaseLearningInstitution;

/**
 * This is the model class for table "learning_institution".
 */
class LearningInstitution extends BaseLearningInstitution {

///institution status constant value
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
///institution ownership values
    const INSTITUTION_OWNER_GOVT = 0;
    const INSTITUTION_OWNER_PRIVATE = 1;
////constant for institution types 
    const INSTITUTION_TYPE_UNIVERSITY = 'UNIVERSITY';
    const INSTITUTION_TYPE_COLLEGE = 'COLLEGE';
    const INSTITUTION_TYPE_OLEVELSECONDARY = 'OLEVEL SECONDARY';
    const INSTITUTION_TYPE_ALEVELSECONDARY = 'ALEVEL SECONDARY';
    const INSTITUTION_TYPE_NON_UNIVERSITY = 'NON UNIVERSITY';
    const INSTITUTION_TYPE_PRIMARY = 'PRIMARY';

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['institution_name', 'institution_type'], 'required'],
            [['institution_type'], 'string'],
            [['ward_id', 'bank_id', 'entered_by_applicant', 'created_by'], 'integer'],
            [['created_at', 'institution_name', 'phone_number','email','physical_address',  'bank_branch_name', 'cp_firstname', 'cp_middlename', 'cp_surname', 'parent_id', 'is_active'], 'safe'],
            [['institution_code'], 'string', 'max' => 10],
            [['institution_name', 'bank_branch_name', 'cp_firstname', 'cp_middlename', 'cp_surname'], 'string', 'max' => 45],
            [['bank_account_number'], 'string', 'max' => 20],
            [['bank_account_name'], 'string', 'max' => 60],
            [['cp_email_address'], 'string', 'max' => 100],
            [['cp_phone_number'], 'string', 'max' => 50],
            [['institution_code'], 'unique']
        ]);
    }

    /*
     * return institution types list
     */

    static function getInstitutionTypes() {
        return [
            self::INSTITUTION_TYPE_UNIVERSITY => 'UNIVERSITY',
            self::INSTITUTION_TYPE_NON_UNIVERSITY => 'NON UNIVERSITY',
            self::INSTITUTION_TYPE_COLLEGE => 'COLLEGE',
            self::INSTITUTION_TYPE_ALEVELSECONDARY => 'ALEVEL SECONDARY',
            self::INSTITUTION_TYPE_OLEVELSECONDARY => 'OLEVEL SECONDARY',
            self::INSTITUTION_TYPE_PRIMARY => 'PRIMARY'
        ];
    }

    /*
     * returns institutions ownerships in array key=>value format
     */

    static function getOwneshipsList() {
        return [
            self::INSTITUTION_OWNER_GOVT => 'Government', self::INSTITUTION_OWNER_PRIVATE => 'Private'
        ];
    }

    /*
     * returns institutions ownerships in array key=>value format
     */

    static function getOwneshipsNameByValue($value) {
        $data = self::getOwneshipsList();
        if ($data && isset($data[$value])) {
            return $data[$value];
        }
        return NULL;
    }

    /*
     * returns institutions status in array key=>value format
     */

    static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive'
        ];
    }

    /*
     * returns institution ownership name by value
     */

    public function getOwnershipNameByValue() {
        if ($this->ownership >= 0) {
            $ownerships = self::getOwneshipsList();
            if (isset($ownerships[$this->ownership])) {
                return $ownerships[$this->ownership];
            }
        }
        return NULL;
    }

    /*
     * returns institution status name by value
     */

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
     * returns the list in array of Active higher-learning institutions excluding the non-higher learning institutions
     */

    static function getHigherLearningInstitution() {
        return self::find()
                        ->where(['is_active' => self::STATUS_ACTIVE])
                        ->andWhere(["in", "institution_type", [self::INSTITUTION_TYPE_UNIVERSITY, self::INSTITUTION_TYPE_COLLEGE]])
                        ->asArray()->all();
    }

    /*
     * returns the list in array of Active higher-learning institutions excluding the non-higher learning institutions
     */

    static function getNonHigherLearningInstitution() {
        return self::find()
                        ->where(['is_active' => self::STATUS_ACTIVE])
                        ->andWhere(["not in", "institution_type", [self::INSTITUTION_TYPE_UNIVERSITY]])
                        ->asArray()->all();
// ->andWhere(["NOT in", "institution_type", [self::INSTITUTION_TYPE_PRIMARY, self::INSTITUTION_TYPE_ALEVELSECONDARY, self::INSTITUTION_TYPE_OLEVELSECONDARY]])
    }

    static function getNameById($id) {
        $data = self::find()->select('institution_name')->where(['learning_institution_id' => $id])->one();
        if ($data) {
            return $data->institution_name;
        }
        return NULL;
    }

    static function getSecondarySchoolsStudyLevels() {
        return Yii::$app->params['seconday_school_study_level'];
    }

    static function getStudyLevelNameByValue($value) {
        $study_level = self::getSecondarySchoolsStudyLevels();
        if (isset($study_level[$value])) {
            return $study_level[$value];
        }
        return NULL;
    }

}
