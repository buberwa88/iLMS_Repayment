<?php

namespace backend\modules\disbursement\models;

use Yii;
use \backend\modules\disbursement\models\base\DisbursementUserStructure as BaseDisbursementUserStructure;

/**
 * This is the model class for table "disbursement_user_structure".
 */
class DisbursementUserStructure extends BaseDisbursementUserStructure
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['disbursement_structure_id', 'user_id', 'created_at', 'created_by'], 'required'],
            [['disbursement_structure_id', 'user_id', 'created_by', 'updated_by',  'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }
	
}
