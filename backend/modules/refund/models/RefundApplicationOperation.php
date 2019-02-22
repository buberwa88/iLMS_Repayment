<?php

namespace backend\modules\refund\models;

use Yii;

/**
 * This is the model class for table "refund_application_operation".
 *
 * @property integer $refund_application_operation_id
 * @property integer $refund_application_id
 * @property integer $refund_internal_operational_id
 * @property string $access_role
 * @property integer $status
 * @property integer $refund_status_reason_setting_id
 * @property string $narration
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
 * @property RefundComment $refundStatusReasonSetting
 * @property RefundInternalOperationalSetting $refundInternalOperational
 * @property User $updatedBy
 * @property RefundApplicationOperationLetter[] $refundApplicationOperationLetters
 * @property RefundApplicationProgress[] $refundApplicationProgresses
 */
class RefundApplicationOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_application_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_application_id', 'refund_internal_operational_id', 'status', 'refund_status_reason_setting_id', 'assignee', 'assigned_by', 'last_verified_by', 'is_current_stage', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['assigned_at', 'date_verified', 'created_at', 'updated_at'], 'safe'],
            [['created_at'], 'required'],
            [['access_role'], 'string', 'max' => 50],
            [['narration'], 'string', 'max' => 500],
            [['assigned_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assigned_by' => 'user_id']],
            [['assignee'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assignee' => 'user_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['last_verified_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_verified_by' => 'user_id']],
            [['refund_application_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundApplication::className(), 'targetAttribute' => ['refund_application_id' => 'refund_application_id']],
            [['refund_status_reason_setting_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundComment::className(), 'targetAttribute' => ['refund_status_reason_setting_id' => 'refund_comment_id']],
            [['refund_internal_operational_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundInternalOperationalSetting::className(), 'targetAttribute' => ['refund_internal_operational_id' => 'refund_internal_operational_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_application_operation_id' => 'Refund Application Operation ID',
            'refund_application_id' => 'Refund Application ID',
            'refund_internal_operational_id' => 'Refund Internal Operational ID',
            'access_role' => 'Access Role',
            'status' => 'Status',
            'refund_status_reason_setting_id' => 'Refund Status Reason Setting ID',
            'narration' => 'Narration',
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
    public function getRefundStatusReasonSetting()
    {
        return $this->hasOne(RefundComment::className(), ['refund_comment_id' => 'refund_status_reason_setting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundInternalOperational()
    {
        return $this->hasOne(RefundInternalOperationalSetting::className(), ['refund_internal_operational_id' => 'refund_internal_operational_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperationLetters()
    {
        return $this->hasMany(RefundApplicationOperationLetter::className(), ['refund_application_operation_id' => 'refund_application_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationProgresses()
    {
        return $this->hasMany(RefundApplicationProgress::className(), ['refund_application_operation_id' => 'refund_application_operation_id']);
    }
}
