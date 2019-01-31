<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_comment".
 *
 * @property integer $refund_comment_id
 * @property integer $attachment_definition_id
 * @property string $comment
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property RefundApplicationInternalOperation[] $refundApplicationInternalOperations
 * @property RefundClaimantAttachment[] $refundClaimantAttachments
 * @property AttachmentDefinition $attachmentDefinition
 * @property User $createdBy
 * @property User $updatedBy
 */
class RefundComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment_definition_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['comment'], 'string', 'max' => 100],
            [['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_comment_id' => 'Refund Comment ID',
            'attachment_definition_id' => 'Attachment Definition ID',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationInternalOperations()
    {
        return $this->hasMany(RefundApplicationInternalOperation::className(), ['refund_comment_id' => 'refund_comment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundClaimantAttachments()
    {
        return $this->hasMany(RefundClaimantAttachment::className(), ['refund_comment_id' => 'refund_comment_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
