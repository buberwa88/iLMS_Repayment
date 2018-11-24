<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\LoanItemPriority as BaseLoanItemPriority;

/**
 * This is the model class for table "loan_item_priority".
 */
class LoanItemPriority extends BaseLoanItemPriority {

    public $destination_academic_year;
    public $source_academic_year;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['academic_year_id', 'loan_item_id', 'priority_order', 'loan_item_category', 'study_level'], 'required', 'on' => 'create_update'],
            [['loan_item_id'], 'validateItem'],
            [['academic_year_id', 'loan_item_id', 'priority_order', 'created_by', 'updated_by', 'loan_award_percentage'], 'integer', 'on' => 'create_update'],
            [['destination_academic_year', 'source_academic_year'], 'required', 'on' => 'clone_items_priority'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }

    static function getLoanItemsPriorityAcademicYearID($academic_year_id) {
        return self::find()->where(['academic_year_id' => $academic_year_id])->all();
    }

    function validateItem($attribute) {
        if ($attribute) {
            $exist = self::find()
                    ->where(
                            ['academic_year_id' => $this->academic_year_id, 'loan_item_id' => $this->loan_item_id,
                                'loan_item_category' => $this->loan_item_category, 'study_level' => $this->study_level
                            ]
                    )
                    ->exists();
            if ($exist) {
                $this->addError($attribute, 'Item Already Exists');
                return FALSE;
            } else {
                return TRUE;
            }
        }
        return FALSE;
    }

}
