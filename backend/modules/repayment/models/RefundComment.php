<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundComment as BaseRefundComment;

/**
 * This is the model class for table "refund_comment".
 */
class RefundComment extends BaseRefundComment {

    const REASON_GROUP_INVALID = 0;
    const REASON_GROUP_INCOMPLETE = 1;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['attachment_definition_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['attachment_definition_id', 'created_by', 'is_active', 'reason_type', 'comment'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['comment'], 'string', 'max' => 100]
        ]);
    }

    public static function getVerificationComment($verification_comment_id) {
        return $results = self::find()
                        ->where(['refund_comment_id' => $verification_comment_id])->one()->comment;
    }

    function getReasoGroups() {
        return [
            self::REASON_GROUP_INVALID => 'Invalid',
            self::REASON_GROUP_INCOMPLETE => 'Incomplete'
        ];
    }

    function getReasonGroupName() {
        $groups = $this->getReasoGroups();
        if (isset($groups[$this->reason_type])) {
            return $groups[$this->reason_type];
        }
        return NULL;
    }

}
