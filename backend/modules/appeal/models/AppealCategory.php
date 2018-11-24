<?php

namespace backend\modules\appeal\models;

use Yii;
use \backend\modules\appeal\models\base\AppealCategory as BaseAppealCategory;

/**
 * This is the model class for table "appeal_category".
 */
class AppealCategory extends BaseAppealCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['description'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ]);
    }
	
}
