<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_application".
 *
 * @property integer $refund_application_id
 * @property integer $refund_claimant_id
 * @property string $claim_number
 * @property string $amount
 * @property integer $finaccial_year_id
 * @property integer $academic_year_id
 * @property string $trustee_firstname
 * @property string $trustee_midlename
 * @property string $trustee_surname
 * @property string $trustee_sex
 * @property integer $verification_status
 * @property integer $refund_verification_framework_id
 * @property string $check_number
 * @property string $bank_account_number
 * @property string $bank_account_name
 * @property integer $bank_id
 * @property integer $refund_type_id
 * @property string $liquidation_letter_number
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property AcademicYear $academicYear
 * @property Bank $bank
 * @property User $createdBy
 * @property FinancialYear $finaccialYear
 * @property RefundClaimant $refundClaimant
 * @property RefundType $refundType
 * @property RefundVerificationFramework $refundVerificationFramework
 * @property User $updatedBy
 * @property RefundApplicationInternalOperation[] $refundApplicationInternalOperations
 * @property RefundClaimantAttachment[] $refundClaimantAttachments
 */
class RefundApplication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_application';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_claimant_id', 'finaccial_year_id', 'academic_year_id', 'verification_status', 'refund_verification_framework_id', 'bank_id', 'refund_type_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['updated_at'], 'required'],
            [['claim_number', 'check_number', 'bank_account_number', 'liquidation_letter_number'], 'string', 'max' => 50],
            [['trustee_firstname', 'trustee_midlename', 'trustee_surname'], 'string', 'max' => 45],
            [['trustee_sex'], 'string', 'max' => 1],
            [['bank_account_name'], 'string', 'max' => 100],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Bank::className(), 'targetAttribute' => ['bank_id' => 'bank_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['finaccial_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\disbursement\models\FinancialYear::className(), 'targetAttribute' => ['finaccial_year_id' => 'financial_year_id']],
            [['refund_claimant_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundClaimant::className(), 'targetAttribute' => ['refund_claimant_id' => 'refund_claimant_id']],
            [['refund_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\RefundType::className(), 'targetAttribute' => ['refund_type_id' => 'refund_type_id']],
            [['refund_verification_framework_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\RefundVerificationFramework::className(), 'targetAttribute' => ['refund_verification_framework_id' => 'refund_verification_framework_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_application_id' => 'Refund Application ID',
            'refund_claimant_id' => 'Refund Claimant ID',
            'claim_number' => 'Claim Number',
            'amount' => 'Amount',
            'finaccial_year_id' => 'Finaccial Year ID',
            'academic_year_id' => 'Academic Year ID',
            'trustee_firstname' => 'Trustee Firstname',
            'trustee_midlename' => 'Trustee Midlename',
            'trustee_surname' => 'Trustee Surname',
            'trustee_sex' => 'Trustee Sex',
            'verification_status' => 'Verification Status',
            'refund_verification_framework_id' => 'Refund Verification Framework ID',
            'check_number' => 'Check Number',
            'bank_account_number' => 'Bank Account Number',
            'bank_account_name' => 'Bank Account Name',
            'bank_id' => 'Bank ID',
            'refund_type_id' => 'Refund Type ID',
            'liquidation_letter_number' => 'Liquidation Letter Number',
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
    public function getAcademicYear()
    {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(\backend\modules\application\models\Bank::className(), ['bank_id' => 'bank_id']);
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
    public function getFinaccialYear()
    {
        return $this->hasOne(\backend\modules\disbursement\models\FinancialYear::className(), ['financial_year_id' => 'finaccial_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundClaimant()
    {
        return $this->hasOne(RefundClaimant::className(), ['refund_claimant_id' => 'refund_claimant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundType()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundType::className(), ['refund_type_id' => 'refund_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundVerificationFramework()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundVerificationFramework::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
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
    public function getRefundApplicationInternalOperations()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationInternalOperation::className(), ['refund_application_id' => 'refund_application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundClaimantAttachments()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundClaimantAttachment::className(), ['refund_application_id' => 'refund_application_id']);
    }
}