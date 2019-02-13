<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundLetterFormat as BaseRefundLetterFormat;

/**
 * This is the model class for table "refund_letter_format".
 */
class RefundLetterFormat extends BaseRefundLetterFormat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['letter_body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'is_active'], 'integer'],
            [['letter_name', 'header', 'footer'], 'string', 'max' => 200],
            [['letter_heading'], 'string', 'max' => 50]
        ]);
    }
	
}
