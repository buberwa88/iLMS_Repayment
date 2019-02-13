<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundStatusReasonSetting as BaseRefundStatusReasonSetting;

/**
 * This is the model class for table "refund_status_reason_setting".
 */
class RefundStatusReasonSetting extends BaseRefundStatusReasonSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['status', 'category', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['reason'], 'string', 'max' => 200]
        ]);
    }
	
}
