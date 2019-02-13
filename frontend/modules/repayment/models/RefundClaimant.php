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
    const REFUND_TYPE_NON_BENEFICIARY=1;
    const REFUND_TYPE_OVER_DEDUCTED=2;
    const REFUND_TYPE_DECEASED=3;
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
    public $applicationCode;
    public $refundClaimantid;

    public $is_necta;
    public $f4indexno_non_necta;
    public $f4_completion_year_nonnecta;
    public function rules()
    {
        return [
            //[['applicant_id', 'f4_completion_year', 'necta_details_confirmed', 'created_by', 'updated_by'], 'integer'],
            [['email','refund_type','firstname','middlename','surname','phone_number','verifyCode'], 'required','on'=>'refundRegistration'],
            [['applicationCode','verifyCode','refundClaimantid'], 'required','on'=>'refundApplicationCodeVerification'],
            ['verifyCode', 'captcha','on'=>['refundRegistration','refundApplicationCodeVerification']],
            //[['f4indexno','f4_completion_year'], 'required','on'=>'refundf4educationnecta'],
            [['f4indexno','necta_firstname','necta_middlename','necta_surname','f4_completion_year'], 'required','on'=>'refundf4education'],
            [['created_at', 'updated_at','sex','refundClaimantid','f4_certificate_document','f4type'], 'safe'],
			[['f4_certificate_document'], 'file', 'extensions'=>['pdf']],
            [['firstname', 'middlename', 'surname', 'necta_firstname', 'necta_middlename', 'necta_surname'], 'string', 'max' => 45],
            [['sex', 'necta_sex'], 'string', 'max' => 1],
            [['firstname', 'middlename', 'surname'], 'match','not' => true,'pattern' => '/[^a-zA-Z_-]/','message' => 'Only Characters  Are Allowed...'],
            ['phone_number', 'checkphonenumber'],
            ['applicationCode', 'validateApplicationCode'],
            ['email', 'email'],
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
            'necta_firstname' => 'Firstname',
            'necta_middlename' => 'Middlename',
            'necta_surname' => 'Surname',
            'necta_sex' => 'Sex',
            'necta_details_confirmed' => 'Details Confirmed',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'verifyCode'=>'Enter Text: ',
            'applicationCode'=>'Code:',
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
    public function checkphonenumber($attribute, $params)
    {
        $phone=str_replace(" ","",str_replace(",","",$this->phone_number));
        if (!preg_match('/^[0-9]*$/', $phone)) {
            $this->addError('phone_number', 'Incorrect Mobile Phone No.');
        }
    }

    public function validateApplicationCode($attribute, $params) {
        //applicationCode
        if ($attribute && $this->applicationCode && $this->refundClaimantid) {
            if (\frontend\modules\repayment\models\RefundApplication::find()->where('refund_claimant_id=:refund_claimant_id AND application_number=:application_number', [':refund_claimant_id' => $this->refundClaimantid,'application_number'=>$this->applicationCode])
                ->exists()) {
                return true;
            }
            $this->addError($attribute,'Incorrect Code');
            return FALSE;
        }
        return true;
    }
    public static function getRefuntTypePerClaimant($refund_application_id){
        $details_ = \frontend\modules\repayment\models\RefundApplication::find()
            ->select('refund_type_id')
            ->where(['refund_application_id'=>$refund_application_id])
            ->one();
        return $details_;
    }
	public static function getStageChecked($refundClaimID){
        $details_ = self::find()
            ->select('f4indexno')
            ->where(['refund_claimant_id'=>$refundClaimID])
            ->one();
			$results=count($details_->f4indexno);
        return $results;
    }
}
