<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "institution_payment_request".
 *
 * @property integer $institution_payment_request_id
 * @property integer $learning_institution_id
 * @property string $request_type
 * @property string $request_reference_number
 * @property integer $loan_item_id
 * @property string $request_date
 * @property double $student_number
 * @property double $amount
 * @property string $description
 * @property integer $submitted
 * @property string $created_at
 * @property integer $created_by
 *
 * @property DisbursementBatch[] $disbursementBatches
 * @property LearningInstitution $learningInstitution
 * @property LoanItem $loanItem
 * @property User $createdBy
 * @property InstitutionPaymentRequestDetail[] $institutionPaymentRequestDetails
 */
class InstitutionPaymentRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'institution_payment_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['learning_institution_id', 'loan_item_id', 'submitted', 'created_by'], 'integer'],
            [['request_type'], 'string'],
            [['request_reference_number', 'loan_item_id', 'student_number', 'amount', 'created_at', 'created_by'], 'required'],
            [['request_date', 'created_at'], 'safe'],
            [['student_number', 'amount'], 'number'],
            [['request_reference_number'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 300],
            [['learning_institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningInstitution::className(), 'targetAttribute' => ['learning_institution_id' => 'learning_institution_id']],
            [['loan_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanItem::className(), 'targetAttribute' => ['loan_item_id' => 'loan_item_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'institution_payment_request_id' => 'Institution Payment Request ID',
            'learning_institution_id' => 'Learning Institution ID',
            'request_type' => 'Request Type',
            'request_reference_number' => 'Request Reference Number',
            'loan_item_id' => 'Loan Item ID',
            'request_date' => 'Request Date',
            'student_number' => 'Student Number',
            'amount' => 'Amount',
            'description' => 'Description',
            'submitted' => 'Submitted',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches()
    {
        return $this->hasMany(DisbursementBatch::className(), ['institution_payment_request_id' => 'institution_payment_request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitution()
    {
        return $this->hasOne(LearningInstitution::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanItem()
    {
        return $this->hasOne(LoanItem::className(), ['loan_item_id' => 'loan_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequestDetails()
    {
        return $this->hasMany(InstitutionPaymentRequestDetail::className(), ['institution_payment_request_id' => 'institution_payment_request_id']);
    }
}
