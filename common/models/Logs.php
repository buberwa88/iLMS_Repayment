<?php

namespace common\models;

use Yii;
use \common\models\base\Logs as BaseLogs;

/**
 * This is the model class for table "logs".
 */
class Logs extends BaseLogs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['primary_id_value', 'http_user_agent', 'new_data', 'remote_address', 'table_name', 'action'], 'required'],
            [['old_data', 'new_data', 'http_user_agent', 'action','created_at', 'updated_at','column_name'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
           
            //[['primary_id_value', 'remote_address'], 'string', 'max' => 200]
        ]);
    }
	
}
