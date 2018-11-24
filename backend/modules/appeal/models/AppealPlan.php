<?php

namespace backend\modules\appeal\models;

use Yii;
use \backend\modules\appeal\models\base\AppealPlan as BaseAppealPlan;

/**
 * This is the model class for table "appeal_plan".
 */
class AppealPlan extends BaseAppealPlan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
	        [['academic_year_id','appeal_plan_desc','appeal_plan_title','status'], 'required'],
            [['academic_year_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['appeal_plan_title'], 'string', 'max' => 100],
            [['appeal_plan_desc'], 'string', 'max' => 300]
        ]);
    }
	
}
