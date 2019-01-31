<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_application_internal_operation".
 *
 * @property integer $refund_application_internal_operation_id
 * @property integer $refund_application_id
 * @property integer $refund_internal_operational_id
 * @property string $access_role
 * @property integer $verification_status
 * @property integer $approval_status
 * @property integer $need_investigation_status
 * @property integer $refund_comment_id
 * @property string $narration
 * @property integer $refund_letter_format_id
 * @property string $letter_number
 * @property integer $assignee
 * @property string $assigned_at
 * @property integer $assigned_by
 * @property integer $last_verified_by
 * @property integer $is_current_stage
 * @property string $date_verified
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property User $assignedBy
 * @property User $assignee0
 * @property User $createdBy
 * @property User $lastVerifiedBy
 * @property RefundApplication $refundApplication
 * @property RefundComment $refundComment
 * @property RefundInternalOperational $refundInternalOperational
 * @property RefundLetterFormat $refundLetterFormat
 * @property User $updatedBy
 */
class RefundApplicationInternalOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_application_internal_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_application_id', 'refund_internal_operational_id', 'verification_status', 'approval_status', 'need_investigation_status', 'refund_comment_id', 'refund_letter_format_id', 'assignee', 'assigned_by', 'last_verified_by', 'is_current_stage', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['assigned_at', 'date_verified', 'created_at', 'updated_at'], 'safe'],
            [['created_at'], 'required'],
            [['access_role', 'letter_number'], 'string', 'max' => 50],
            [['narration'], 'string', 'max' => 500],
            [['assigned_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assigned_by' => 'user_id']],
            [['assignee'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assignee' => 'user_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['last_verified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_verified_by' => 'user_id']],
            [['refund_application_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundApplication::className(), 'targetAttribute' => ['refund_application_id' => 'refund_application_id']],
            [['refund_comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundComment::className(), 'targetAttribute' => ['refund_comment_id' => 'refund_comment_id']],
            [['refund_internal_operational_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundInternalOperational::className(), 'targetAttribute' => ['refund_internal_operational_id' => 'refund_internal_operational_id']],
            [['refund_letter_format_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundLetterFormat::className(), 'targetAttribute' => ['refund_letter_format_id' => 'refund_letter_format_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_application_internal_operation_id' => 'Refund Application Internal Operation ID',
            'refund_application_id' => 'Refund Application ID',
            'refund_internal_operational_id' => 'Refund Internal Operational ID',
            'access_role' => 'Access Role',
            'verification_status' => 'Verification Status',
            'approval_status' => 'Approval Status',
            'need_investigation_status' => 'Need Investigation Status',
            'refund_comment_id' => 'Refund Comment ID',
            'narration' => 'Narration',
            'refund_letter_format_id' => 'Refund Letter Format ID',
            'letter_number' => 'Letter Number',
            'assignee' => 'Assignee',
            'assigned_at' => 'Assigned At',
            'assigned_by' => 'Assigned By',
            'last_verified_by' => 'Last Verified By',
            'is_current_stage' => 'Is Current Stage',
            'date_verified' => 'Date Verified',
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
    public function getAssignedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'assigned_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignee0()
    {
        return $this->hasOne(User::className(), ['user_id' => 'assignee']);
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
    public function getLastVerifiedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'last_verified_by']);
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
    public function getRefundInternalOperational()
    {
        return $this->hasOne(RefundInternalOperational::className(), ['refund_internal_operational_id' => 'refund_internal_operational_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundLetterFormat()
    {
        return $this->hasOne(RefundLetterFormat::className(), ['refund_letter_format_id' => 'refund_letter_format_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
