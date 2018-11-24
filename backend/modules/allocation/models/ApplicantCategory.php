<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "applicant_category".
 *
 * @property integer $applicant_category_id
 * @property string $applicant_category
 *
 * @property ApplicantCategoryAttachment[] $applicantCategoryAttachments
 * @property ApplicantCategorySection[] $applicantCategorySections
 * @property Application[] $applications
 * @property CriteriaField[] $criteriaFields
 */
class ApplicantCategory extends \backend\modules\application\models\Applicant {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'applicant_category';
    }

    static function getNameByID($ID) {
        $data = self::findOne($ID);
        if ($data) {
            return $data->applicant_category;
        }
        return NULL;
    }

}
