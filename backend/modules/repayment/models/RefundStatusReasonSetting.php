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
    public static function getRefundStatusReasonSett($status) {
        $data2 = \backend\modules\repayment\models\RefundStatusReasonSetting::findBySql(" SELECT refund_status_reason_setting_id AS id, reason AS name FROM refund_status_reason_setting WHERE status='$status'")->asArray()->all();
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;

    }
	
}
