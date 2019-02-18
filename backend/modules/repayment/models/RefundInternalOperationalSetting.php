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
    const VERIFICATION_STATUS_NEED_INVESTIGATION = 4;

    const VERIFICATION_RESPONSE_TEMP_STOP_DEDUCT = 1;
    const VERIFICATION_RESPONSE_PERMANENT_STOP_DEDUCT = 2;
    const VERIFICATION_RESPONSE_INVEST_TEMP_STOP_DEDUCT = 3;
    const VERIFICATION_RESPONSE_INVEST_NO_STOP_DEDUCT = 4;
    const VERIFICATION_RESPONSE_NEED_FURTHER_VERFICATION = 5;
    const VERIFICATION_RESPONSE_CONCLUDED_VALID = 6;
    const VERIFICATION_RESPONSE_NEED_DENIAL_LETTER = 7;

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
    public static function getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition){
        if($statusResponse=='REFUND_DATA_SECTION') {
            $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  access_role_master='loan_recovery_data_section' AND is_active='1'")->one();
        }else if($statusResponse=='AUDIT_INVEST_SECTION') {
            $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  access_role_master='audit_investigation_department' AND is_active='1'")->one();
        } else{
            $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  refund_internal_operational_id $condition $currentFlow_id AND  is_active='1' ORDER BY refund_internal_operational_id $orderList_ASC_DESC")->one();
        }
        return $refundInterOperSetting;
    }
    static function getVerificationStatusResponse() {
        return array(
            self::VERIFICATION_RESPONSE_TEMP_STOP_DEDUCT => 'Issue temporary stop deduction',
            self::VERIFICATION_RESPONSE_PERMANENT_STOP_DEDUCT => 'Issue permanent stop deduction',
            self::VERIFICATION_RESPONSE_INVEST_TEMP_STOP_DEDUCT => 'Need Invest. with temporary stop deduction',
            self::VERIFICATION_RESPONSE_INVEST_NO_STOP_DEDUCT => 'Need invest. with no stop deduction',
            self::VERIFICATION_RESPONSE_NEED_FURTHER_VERFICATION => 'Need Further Verification',
            self::VERIFICATION_RESPONSE_CONCLUDED_VALID => 'Concluded Valid',
            self::VERIFICATION_RESPONSE_NEED_DENIAL_LETTER => 'Need Denial Letter',
        );
    }
    static function getVerificationStatusAuditSection() {
        return array(
            self::STATUS_VALID => 'Valid',
            self::STATUS_INVALID => 'Invalid',
            self::VERIFICATION_STATUS_NEED_INVESTIGATION => 'Need Investigation',

        );
    }
}
