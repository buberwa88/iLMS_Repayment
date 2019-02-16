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
    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;
    const STATUS_NEED_FURTHER_VERIFICATION = 3;
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
    public static function getSettingDetails()
    {
        $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  flow_order_list='2' AND is_active='1' AND is_active='1'")->one();
        return $refundInterOperSetting;
    }
    static function getVerificationStatus() {
        return array(
            self::STATUS_VALID => 'Valid',
            self::STATUS_INVALID => 'Invalid',
            self::STATUS_NEED_FURTHER_VERIFICATION => 'Need Further Verification',
        );
    }
}
