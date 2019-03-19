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
			[['is_active','verification_framework_title', 'verification_framework_desc','refund_type_id'], 'required','on'=>'frameworkRegister'],
			[['is_active','verification_framework_title', 'verification_framework_desc','refund_type_id'], 'required','on'=>'frameworkUpdate'],
            [['created_by', 'confirmed_by', 'updated_by', 'is_active'], 'integer'],
			[['refund_type_id'], 'validateFramework','on'=>'frameworkRegister'],
			 [['refund_type_id'], 'validateFrameworkUpdate','on'=>'frameworkUpdate'],
            [['verification_framework_title', 'verification_framework_desc', 'verification_framework_stage', 'support_document'], 'string', 'max' => 100]
        ]);
    }
	public static function getActiveFramework($applicantCategory){
        $results= self::find()->where(['is_active'=>1,'refund_type_id'=>$applicantCategory])->one();
        return $results;
    }
	public function validateFramework($attribute)
{
    if (self::findBySql("SELECT * FROM refund_verification_framework where refund_type_id = '$this->refund_type_id' AND is_active='1'")
        ->exists()) {
        $this->addError($attribute, 'Active Framework Exist');
        return FALSE;
    }
    return true;
}
	public function validateFrameworkUpdate($attribute)
{
    if (self::findBySql("SELECT * FROM refund_verification_framework where refund_type_id = '$this->refund_type_id' AND is_active='1' AND refund_verification_framework_id <> '$this->refund_verification_framework_id'")
        ->exists()) {
        $this->addError($attribute, 'Active Framework Exist');
        return FALSE;
    }
    return true;
}
	
}
