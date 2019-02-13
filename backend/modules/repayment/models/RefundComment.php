<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundComment as BaseRefundComment;

/**
 * This is the model class for table "refund_comment".
 */
class RefundComment extends BaseRefundComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['attachment_definition_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['comment'], 'string', 'max' => 100]
        ]);
    }
	public static function getVerificationComment($verification_comment_id){
      return $results=self::find()
               ->where(['refund_comment_id'=>$verification_comment_id])->one()->comment; 
    }
	
}
