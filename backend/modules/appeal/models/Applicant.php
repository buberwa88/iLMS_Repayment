<?php

namespace backend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "applicant".
 *
 * @property integer $applicant_id
 * @property integer $user_id
 * @property string $NID
 * @property string $f4indexno
 * @property string $f6indexno
 * @property string $mailing_address
 * @property string $date_of_birth
 * @property string $place_of_birth
 * @property integer $loan_repayment_bill_requested
 *
 * @property Appeal[] $appeals
 * @property User $user
 * @property ApplicantComplaintToken[] $applicantComplaintTokens
 * @property Application[] $applications
 * @property EmployedBeneficiary[] $employedBeneficiaries
 * @property LoanRepaymentBatch[] $loanRepaymentBatches
 * @property LoanRepaymentBatchDetail[] $loanRepaymentBatchDetails
 * @property LoanRepaymentBill[] $loanRepaymentBills
 * @property LoanRepaymentBillDetail[] $loanRepaymentBillDetails
 */
class Applicant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'f4indexno', 'mailing_address', 'date_of_birth', 'place_of_birth'], 'required'],
            [['user_id', 'loan_repayment_bill_requested'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['NID'], 'string', 'max' => 30],
            [['f4indexno', 'f6indexno'], 'string', 'max' => 45],
            [['mailing_address'], 'string', 'max' => 80],
            [['place_of_birth'], 'string', 'max' => 100],
            [['f4indexno'], 'unique'],
            [['user_id'], 'unique'],
            [['NID'], 'unique'],
            [['f6indexno'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_id' => 'Applicant ID',
            'user_id' => 'User ID',
            'NID' => 'Nid',
            'f4indexno' => 'F4indexno',
            'f6indexno' => 'F6indexno',
            'mailing_address' => 'Mailing Address',
            'date_of_birth' => 'Date Of Birth',
            'place_of_birth' => 'Place Of Birth',
            'loan_repayment_bill_requested' => 'Loan Repayment Bill Requested',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppeals()
    {
        return $this->hasMany(Appeal::className(), ['application_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantComplaintTokens()
    {
        return $this->hasMany(ApplicantComplaintToken::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployedBeneficiaries()
    {
        return $this->hasMany(EmployedBeneficiary::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBatches()
    {
        return $this->hasMany(LoanRepaymentBatch::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBatchDetails()
    {
        return $this->hasMany(LoanRepaymentBatchDetail::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBills()
    {
        return $this->hasMany(LoanRepaymentBill::className(), ['applicant_id' => 'applicant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentBillDetails()
    {
        return $this->hasMany(LoanRepaymentBillDetail::className(), ['applicant_id' => 'applicant_id']);
    }
}
