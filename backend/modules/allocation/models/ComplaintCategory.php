<?php

namespace backend\modules\allocation\models;

use Yii;
use \backend\modules\allocation\models\base\ComplaintCategory as BaseComplaintCategory;

/**
 * This is the model class for table "complaint_category".
 */
class ComplaintCategory extends BaseComplaintCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['description'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['complaint_category_name'], 'string', 'max' => 200]
        ]);
    }
	
}
