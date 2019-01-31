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
            [['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
            [['refund_application_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundApplication::className(), 'targetAttribute' => ['refund_application_id' => 'refund_application_id']],
            [['refund_comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundComment::className(), 'targetAttribute' => ['refund_comment_id' => 'refund_comment_id']],
            [['last_verified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_verified_by' => 'user_id']],
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
        return $this->hasOne(AttachmentDefinition::className(), ['attachment_definition_id' => 'attachment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplication()
    {
        return $this->hasOne(RefundApplication::className(), ['refund_application_id' => 'refund_application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundComment()
    {
        return $this->hasOne(RefundComment::className(), ['refund_comment_id' => 'refund_comment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastVerifiedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'last_verified_by']);
    }
}
