<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundVerificationFramework as BaseRefundVerificationFramework;

/**
 * This is the model class for table "refund_verification_framework".
 */
class RefundVerificationFramework extends BaseRefundVerificationFramework
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['created_at', 'confirmed_at', 'updated_at','refund_type_id'], 'safe'],
            [['created_by', 'confirmed_by', 'updated_by', 'is_active'], 'integer'],
            [['verification_framework_title', 'verification_framework_desc', 'verification_framework_stage', 'support_document'], 'string', 'max' => 100]
        ]);
    }
	public static function getActiveFramework($applicantCategory){
        $results= self::find()->where(['is_active'=>1,'refund_type_id'=>$applicantCategory])->one();
        return $results;
    }
	
}
