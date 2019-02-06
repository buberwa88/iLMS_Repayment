<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_claimant".
 *
 * @property integer $refund_claimant_id
 * @property integer $applicant_id
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $sex
 * @property string $phone_number
 * @property string $f4indexno
 * @property integer $f4_completion_year
 * @property string $necta_firstname
 * @property string $necta_middlename
 * @property string $necta_surname
 * @property string $necta_sex
 * @property integer $necta_details_confirmed
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property RefundApplication[] $refundApplications
 * @property Applicant $applicant
 * @property User $createdBy
 * @property User $updatedBy
 */
class RefundClaimant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_claimant';
    }

    /**
     * @inheritdoc
     */
    public $email;
    public $refund_type;
    public $verifyCode;
    public function rules()
    {
        return [
            [['applicant_id', 'f4_completion_year', 'necta_details_confirmed', 'created_by', 'updated_by'], 'integer'],
            [['email','refund_type','firstname','middlename','surname','phone_number','verifyCode'], 'required','on'=>'refundRegistration'],
            [['created_at', 'updated_at','sex'], 'safe'],
            [['firstname', 'middlename', 'surname', 'necta_firstname', 'necta_middlename', 'necta_surname'], 'string', 'max' => 45],
            [['sex', 'necta_sex'], 'string', 'max' => 1],
            [['phone_number'], 'string', 'max' => 50],
            [['f4indexno'], 'string', 'max' => 200],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
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
            'refund_claimant_id' => 'Refund Claimant ID',
            'applicant_id' => 'Applicant ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'phone_number' => 'Phone Number',
            'f4indexno' => 'F4indexno',
            'f4_completion_year' => 'F4 Completion Year',
            'necta_firstname' => 'Necta Firstname',
            'necta_middlename' => 'Necta Middlename',
            'necta_surname' => 'Necta Surname',
            'necta_sex' => 'Necta Sex',
            'necta_details_confirmed' => 'Necta Details Confirmed',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplications()
    {
        return $this->hasMany(RefundApplication::className(), ['refund_claimant_id' => 'refund_claimant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant()
    {
        return $this->hasOne(\frontend\modules\application\models\Applicant::className(), ['applicant_id' => 'applicant_id']);
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
