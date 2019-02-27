<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_claimant_attachment".
 *
 * @property integer $refund_claimant_attachment_id
 * @property integer $refund_application_id
 * @property integer $attachment_definition_id
 * @property string $attachment_path
 * @property integer $verification_status
 * @property integer $refund_comment_id
 * @property string $other_description
 * @property integer $last_verified_by
 * @property string $last_verified_at
 * @property integer $is_active
 *
 * @property AttachmentDefinition $attachmentDefinition
 * @property RefundApplication $refundApplication
 * @property RefundComment $refundComment
 * @property User $lastVerifiedBy
 */
class RefundClaimantAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 const F4_CERTIFICATE_DOCUMENT='F4CERT';	 
	 const Salary_PAY_Slip='SSP';
	 const Bank_Card='BCRD';
	 const Letter_from_social_security='LFSS';
	 const Liquidation_letter='LLT';
	 const Letter_from_court='LFC';
	 const Letter_of_family_session='LOFS';
	 const RECEIPT_FROM_SOCIAL_FUND='RFSSC';	 
	 const College_Education_Certificate_Document='COECD';
	 const Bachelor_Education_Certificate_Document='BECD';
	 const Masters_Education_Certificate_Document='MAECD';
	 const Death_Certificate_Document='DCFD';
    const Employer_letter_Document='EMPLD';
    const Claimant_deed_pole_document='CDPD';

    public static function tableName()
    {
        return 'refund_claimant_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_application_id', 'attachment_definition_id', 'verification_status', 'refund_comment_id', 'last_verified_by', 'is_active'], 'integer'],
            [['last_verified_at'], 'safe'],
            [['attachment_path', 'other_description'], 'string', 'max' => 500],
            [['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
            [['refund_application_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\RefundApplication::className(), 'targetAttribute' => ['refund_application_id' => 'refund_application_id']],
            [['refund_comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\RefundComment::className(), 'targetAttribute' => ['refund_comment_id' => 'refund_comment_id']],
            [['last_verified_by'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\User::className(), 'targetAttribute' => ['last_verified_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_claimant_attachment_id' => 'Refund Claimant Attachment ID',
            'refund_application_id' => 'Refund Application ID',
            'attachment_definition_id' => 'Attachment Definition ID',
            'attachment_path' => 'Attachment Path',
            'verification_status' => 'Verification Status',
            'refund_comment_id' => 'Refund Comment ID',
            'other_description' => 'Other Description',
            'last_verified_by' => 'Last Verified By',
            'last_verified_at' => 'Last Verified At',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentDefinition()
    {
        return $this->hasOne(\frontend\modules\application\models\AttachmentDefinition::className(), ['attachment_definition_id' => 'attachment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplication()
    {
        return $this->hasOne(\frontend\modules\repayment\models\RefundApplication::className(), ['refund_application_id' => 'refund_application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundComment()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundComment::className(), ['refund_comment_id' => 'refund_comment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastVerifiedBy()
    {
        return $this->hasOne(\frontend\modules\repayment\models\User::className(), ['user_id' => 'last_verified_by']);
    }
	public static function insertClaimantAttachment($refund_application_id,$attachment_code,$attachment_path){
		$getAttachmentDef = \backend\modules\application\models\AttachmentDefinition::findBySql("SELECT attachment_definition_id FROM  attachment_definition WHERE  attachment_code='$attachment_code' AND is_active='1'")->one();
		$attachment_definition_id=$getAttachmentDef->attachment_definition_id;
		Yii::$app->db->createCommand()
                    ->insert('refund_claimant_attachment', [
                        'refund_application_id' => $refund_application_id,
                        'attachment_definition_id' => $attachment_definition_id,
                        'attachment_path' => $attachment_path,
                    ])->execute();
	}
}
