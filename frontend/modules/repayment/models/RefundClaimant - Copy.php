<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_claimant".
 *
 * @property integer $refund_claimant_id
 * @property integer $applicant_id
 * @property integer $claimant_user_id
 * @property string $firstname
 * @property string $middlename
 * @property string $surname
 * @property string $sex
 * @property string $phone_number
 * @property string $f4indexno
 * @property integer $completion_year
 * @property string $old_firstname
 * @property string $old_middlename
 * @property string $old_surname
 * @property string $old_sex
 * @property integer $old_details_confirmed
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property RefundApplication[] $refundApplications
 * @property Applicant $applicant
 * @property User $claimantUser
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
    public $is_necta;
    public $f4indexno_non_necta;
    public function rules()
    {
        return [
            [['applicant_id', 'claimant_user_id', 'completion_year', 'old_details_confirmed', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['sex'], 'required'],
            [['created_at', 'updated_at','is_necta'], 'safe'],
            [['firstname', 'middlename', 'surname', 'old_firstname', 'old_middlename', 'old_surname'], 'string', 'max' => 45],
            [['sex', 'old_sex'], 'string', 'max' => 1],
            [['phone_number'], 'string', 'max' => 50],
            [['f4indexno'], 'string', 'max' => 200],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\Applicant::className(), 'targetAttribute' => ['applicant_id' => 'applicant_id']],
            [['claimant_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['claimant_user_id' => 'user_id']],
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
            'claimant_user_id' => 'Claimant User ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'surname' => 'Surname',
            'sex' => 'Sex',
            'phone_number' => 'Phone Number',
            'f4indexno' => 'F4indexno',
            'completion_year' => 'Completion Year',
            'old_firstname' => 'Old Firstname',
            'old_middlename' => 'Old Middlename',
            'old_surname' => 'Old Surname',
            'old_sex' => 'Old Sex',
            'old_details_confirmed' => 'Old Details Confirmed',
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
    public function getClaimantUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'claimant_user_id']);
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
