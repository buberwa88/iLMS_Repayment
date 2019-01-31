<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_verification_framework_item".
 *
 * @property integer $refund_verification_framework_item_id
 * @property integer $refund_verification_framework_id
 * @property integer $attachment_definition_id
 * @property string $verification_prompt
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $last_updated_at
 * @property integer $last_updated_by
 * @property integer $is_active
 *
 * @property AttachmentDefinition $attachmentDefinition
 * @property User $createdBy
 * @property User $lastUpdatedBy
 * @property RefundVerificationFramework $refundVerificationFramework
 */
class RefundVerificationFrameworkItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_verification_framework_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_verification_framework_id', 'attachment_definition_id', 'status', 'created_by', 'last_updated_by', 'is_active'], 'integer'],
            [['created_at', 'last_updated_at'], 'safe'],
            [['verification_prompt'], 'string', 'max' => 200],
            [['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_updated_by' => 'user_id']],
            [['refund_verification_framework_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundVerificationFramework::className(), 'targetAttribute' => ['refund_verification_framework_id' => 'refund_verification_framework_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_verification_framework_item_id' => 'Refund Verification Framework Item ID',
            'refund_verification_framework_id' => 'Refund Verification Framework ID',
            'attachment_definition_id' => 'Attachment Definition ID',
            'verification_prompt' => 'Verification Prompt',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundVerificationFramework()
    {
        return $this->hasOne(RefundVerificationFramework::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
    }
}
