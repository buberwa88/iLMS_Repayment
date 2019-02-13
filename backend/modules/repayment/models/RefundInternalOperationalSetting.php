<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundInternalOperationalSetting as BaseRefundInternalOperationalSetting;

/**
 * This is the model class for table "refund_internal_operational_setting".
 */
class RefundInternalOperationalSetting extends BaseRefundInternalOperationalSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['flow_order_list', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'access_role_master', 'access_role_child'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 50]
        ]);
    }
	
}
