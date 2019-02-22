<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundStatusReasonSetting as BaseRefundStatusReasonSetting;

/**
 * This is the model class for table "refund_status_reason_setting".
 */
class RefundStatusReasonSetting extends BaseRefundStatusReasonSetting {

    const CATEGORY_REFUND_DATA_COLLECTION = 1;
    const CATEGORY_REFUND_DATA_VALIDATION = 2;
    const CATEGORY_REFUND_AUDIT_INVESTIGATION = 3;
    ////constatnts for status types

    const STATUS_INVALID = 1;
    const STATUS_INCOMPLETE = 2;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['status', 'category', 'reason'], 'required'],
            [['created_at', 'updated_at','access_role_master','access_role_child'], 'safe'],
            [['reason'], 'string', 'max' => 200]
        ]);
    }

    public static function getRefundStatusReasonSett($status) {
        $data2 = \backend\modules\repayment\models\RefundStatusReasonSetting::findBySql(" SELECT refund_status_reason_setting_id AS id, reason AS name FROM refund_status_reason_setting WHERE status='$status'")->asArray()->all();
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;
    }

    function getApplcationProcessingSections() {
        return [
            self::CATEGORY_REFUND_DATA_COLLECTION => 'Data Collection',
            self::CATEGORY_REFUND_DATA_VALIDATION => ' Data Validation',
            self::CATEGORY_REFUND_AUDIT_INVESTIGATION => 'Audit & Investigation'
        ];
    }

    function getStatusTypes() {
        return [
            self::STATUS_INVALID => 'Invalid',
            self::STATUS_INCOMPLETE => 'Incomplete',
        ];
    }

    function getStatusTypeName() {
        $status = $this->getStatusTypes();
        if (isset($status[$this->status])) {
            return $status[$this->status];
        }
        return NULL;
    }

    function getApplcationProcessingSectionName() {
        $sections = $this->getApplcationProcessingSections();
        if (isset($sections[$this->category])) {
            return $sections[$this->category];
        }
        return NULL;
    }


}
