<?php

namespace backend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "learning_institution".
 *
 * @property integer $learning_institution_id
 * @property string $institution_type
 * @property string $institution_code
 * @property string $institution_name
 * @property string $institution_phone
 * @property string $institution_address
 * @property integer $ward_id
 * @property string $bank_account_number
 * @property string $bank_account_name
 * @property integer $bank_id
 * @property string $bank_branch_name
 * @property integer $entered_by_applicant
 * @property string $created_at
 * @property integer $created_by
 * @property string $contact_firstname
 * @property string $contact_middlename
 * @property string $contact_surname
 * @property string $contact_email_address
 * @property string $contact_phone_number
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property DisbursementBatch[] $disbursementBatches
 * @property Education[] $educations
 * @property InstitutionPaymentRequest[] $institutionPaymentRequests
 * @property Bank $bank
 * @property User $createdBy
 * @property Ward $ward
 * @property LearningInstitutionFee[] $learningInstitutionFees
 * @property Programme[] $programmes
 */
class LearningInstitution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'learning_institution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['institution_type'], 'string'],
            [['institution_name', 'ward_id', 'created_at', 'created_by'], 'required'],
            [['ward_id', 'bank_id', 'entered_by_applicant', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['institution_code'], 'string', 'max' => 10],
            [['institution_name', 'institution_phone', 'institution_address', 'bank_branch_name', 'contact_firstname', 'contact_middlename', 'contact_surname'], 'string', 'max' => 45],
            [['bank_account_number'], 'string', 'max' => 20],
            [['bank_account_name'], 'string', 'max' => 60],
            [['contact_email_address'], 'string', 'max' => 100],
            [['contact_phone_number'], 'string', 'max' => 50],
            [['institution_code'], 'unique'],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'bank_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ward::className(), 'targetAttribute' => ['ward_id' => 'ward_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'learning_institution_id' => 'Learning Institution ID',
            'institution_type' => 'Institution Type',
            'institution_code' => 'Institution Code',
            'institution_name' => 'Institution Name',
            'institution_phone' => 'Institution Phone',
            'institution_address' => 'Institution Address',
            'ward_id' => 'Ward ID',
            'bank_account_number' => 'Bank Account Number',
            'bank_account_name' => 'Bank Account Name',
            'bank_id' => 'Bank ID',
            'bank_branch_name' => 'Bank Branch Name',
            'entered_by_applicant' => 'Entered By Applicant',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'contact_firstname' => 'Contact Firstname',
            'contact_middlename' => 'Contact Middlename',
            'contact_surname' => 'Contact Surname',
            'contact_email_address' => 'Contact Email Address',
            'contact_phone_number' => 'Contact Phone Number',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches()
    {
        return $this->hasMany(DisbursementBatch::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducations()
    {
        return $this->hasMany(Education::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionPaymentRequests()
    {
        return $this->hasMany(InstitutionPaymentRequest::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['bank_id' => 'bank_id']);
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
    public function getWard()
    {
        return $this->hasOne(Ward::className(), ['ward_id' => 'ward_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLearningInstitutionFees()
    {
        return $this->hasMany(LearningInstitutionFee::className(), ['learning_institution_id' => 'learning_institution_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgrammes()
    {
        return $this->hasMany(Programme::className(), ['learning_institution_id' => 'learning_institution_id']);
    }
}
