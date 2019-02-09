<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_claimant_employment".
 *
 * @property integer $refund_claimant_employment_id
 * @property string $employer_name
 * @property string $start_date
 * @property string $end_date
 * @property integer $refund_claimant_id
 * @property integer $refund_application_id
 * @property string $employee_id
 * @property string $matching_status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property User $createdBy
 * @property RefundApplication $refundApplication
 * @property RefundClaimant $refundClaimant
 * @property User $updatedBy
 */
class RefundClaimantEmployment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_claimant_employment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['refund_claimant_id', 'refund_application_id', 'created_by', 'updated_by'], 'integer'],
            [['employer_name', 'employee_id'], 'string', 'max' => 100],
            [['matching_status'], 'string', 'max' => 200],
			[['employer_name', 'employee_id', 'start_date', 'end_date'], 'required','on'=>'refundEmploymentDetails'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['refund_application_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundApplication::className(), 'targetAttribute' => ['refund_application_id' => 'refund_application_id']],
            [['refund_claimant_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundClaimant::className(), 'targetAttribute' => ['refund_claimant_id' => 'refund_claimant_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_claimant_employment_id' => 'Refund Claimant Employment ID',
            'employer_name' => 'Employer Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'refund_claimant_id' => 'Refund Claimant ID',
            'refund_application_id' => 'Refund Application ID',
            'employee_id' => 'Employee ID',
            'matching_status' => 'Matching Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
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
    public function getRefundApplication()
    {
        return $this->hasOne(RefundApplication::className(), ['refund_application_id' => 'refund_application_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
