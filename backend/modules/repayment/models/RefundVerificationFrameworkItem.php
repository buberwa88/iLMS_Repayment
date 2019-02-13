<?php

namespace backend\modules\repayment\models;

use Yii;
use \backend\modules\repayment\models\base\RefundVerificationFrameworkItem as BaseRefundVerificationFrameworkItem;

/**
 * This is the model class for table "refund_verification_framework_item".
 */
class RefundVerificationFrameworkItem extends BaseRefundVerificationFrameworkItem
{
    /**
     * @inheritdoc
     */
	 public $verification_status;
	 public $refund_comment_id;
	 public $other_description;
	 public $refund_claimant_attachment_id;
	 public $attachment_path;
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['refund_verification_framework_id', 'attachment_definition_id', 'status', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['verification_prompt'], 'string', 'max' => 200]
        ]);
    }
	static function getVerificationAttachments($applicationID, $verificationFrameworkID){
            $query1 = self::find()
                ->select("refund_verification_framework_item.refund_verification_framework_id AS refund_verification_framework_id,refund_verification_framework_item.attachment_definition_id AS attachment_definition_id,refund_verification_framework_item.verification_prompt AS verification_prompt")
    ->from('refund_verification_framework_item')
    ->where(['refund_verification_framework_item.status'=>1,'refund_verification_framework_item.refund_verification_framework_id'=>$verificationFrameworkID]);
            $query2 = self::find()
                ->select("refund_verification_framework_item.refund_verification_framework_id AS refund_verification_framework_id,refund_verification_framework_item.attachment_definition_id AS attachment_definition_id,refund_verification_framework_item.verification_prompt AS verification_prompt")
    ->from('refund_verification_framework_item')
   ->innerJoin('refund_verification_framework','refund_verification_framework.refund_verification_framework_id=refund_verification_framework_item.refund_verification_framework_id')           ->innerJoin('attachment_definition','attachment_definition.attachment_definition_id=refund_verification_framework_item.attachment_definition_id')
   ->innerJoin('refund_claimant_attachment','refund_claimant_attachment.attachment_definition_id=attachment_definition.attachment_definition_id')         
    ->where(['refund_verification_framework.refund_verification_framework_id'=>$verificationFrameworkID,'refund_claimant_attachment.refund_application_id'=>$applicationID,'refund_verification_framework_item.status'=>2]);
        
        return new \yii\data\ActiveDataProvider([
            'query' => $query1->union($query2),
            'pagination' => [
        'pageSize' => 20,
    ],
        ]);
         
    }
	public static function getApplicantAttachmentPath($attachmentDefinitionID,$applicationID){
        $resultsAttachmentParth= \backend\modules\repayment\models\RefundClaimantAttachment::find()->where(['refund_application_id'=>$applicationID,'attachment_definition_id'=>$attachmentDefinitionID])->one();
        return $resultsAttachmentParth;
    }

}
