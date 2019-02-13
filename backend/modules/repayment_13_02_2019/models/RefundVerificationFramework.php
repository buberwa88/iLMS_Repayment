<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_verification_framework".
 *
 * @property integer $refund_verification_framework_id
 * @property string $verification_framework_title
 * @property string $verification_framework_desc
 * @property string $verification_framework_stage
 * @property string $support_document
 * @property integer $refund_type_id
 * @property string $created_at
 * @property integer $created_by
 * @property integer $confirmed_by
 * @property string $confirmed_at
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property RefundApplication[] $refundApplications
 * @property User $confirmedBy
 * @property User $createdBy
 * @property User $refundType
 * @property User $updatedBy
 * @property RefundVerificationFrameworkItem[] $refundVerificationFrameworkItems
 */
class RefundVerificationFramework extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_verification_framework';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_type_id', 'created_by', 'confirmed_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'confirmed_at', 'updated_at'], 'safe'],
            [['verification_framework_title', 'verification_framework_desc', 'verification_framework_stage', 'support_document'], 'string', 'max' => 100],
            [['confirmed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['confirmed_by' => 'user_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['refund_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['refund_type_id' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_verification_framework_id' => 'Refund Verification Framework ID',
            'verification_framework_title' => 'Verification Framework Title',
            'verification_framework_desc' => 'Verification Framework Desc',
            'verification_framework_stage' => 'Verification Framework Stage',
            'support_document' => 'Support Document',
            'refund_type_id' => 'Refund Type ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'confirmed_by' => 'Confirmed By',
            'confirmed_at' => 'Confirmed At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplications()
    {
        return $this->hasMany(RefundApplication::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfirmedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'confirmed_by']);
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
    public function getRefundType()
    {
        return $this->hasOne(User::className(), ['user_id' => 'refund_type_id']);
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
    public function getRefundVerificationFrameworkItems()
    {
        return $this->hasMany(RefundVerificationFrameworkItem::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
    }
}
