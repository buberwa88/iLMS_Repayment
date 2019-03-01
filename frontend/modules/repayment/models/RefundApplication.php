<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_application".
 *
 * @property integer $refund_application_id
 * @property integer $refund_claimant_id
 * @property string $application_number
 * @property string $refund_claimant_amount
 * @property integer $finaccial_year_id
 * @property integer $academic_year_id
 * @property string $trustee_firstname
 * @property string $trustee_midlename
 * @property string $trustee_surname
 * @property string $trustee_sex
 * @property integer $current_status
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
 * @property integer $submitted
 *
 * @property AcademicYear $academicYear
 * @property Bank $bank
 * @property User $createdBy
 * @property FinancialYear $finaccialYear
 * @property RefundClaimant $refundClaimant
 * @property RefundType $refundType
 * @property RefundVerificationFramework $refundVerificationFramework
 * @property User $updatedBy
 * @property RefundApplicationOperation[] $refundApplicationOperations
 * @property RefundClaimantAttachment[] $refundClaimantAttachments
 */
class RefundApplication extends \yii\db\ActiveRecord {
    /*
     * Application Current Status values
     * 
     */

    const APPLICATION_STATUS_SAVED = 0;
    const Preview_Complete = 1;
    const Incomplete = 2;
    const Waiting = 3;
    const Invalid = 4;
    const Pending = 5;
    const Verification_Onprogress = 6;
    const Verification_Complete = 7;
    const PAY_LIST_WAITING_QUEUE = 8;
    const APPLICATION_IN_PALIST = 9;
    const PAID_APPLICATION = 10;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'refund_application';
    }

    /**
     * @inheritdoc
     */
    public $verificationCode;
    public $pin;
    public $f4indexno;
    public $firstname;
    public $middlename;
    public $surname;
    public $letter_family_session_document2;
    public $totalApplication;
    public $refundTypeExpalnation;
    public $refund_type_confirmed;
    public $refundType;

    public function rules() {
        return [
            [['refund_claimant_id', 'finaccial_year_id', 'academic_year_id', 'current_status', 'refund_verification_framework_id', 'bank_id', 'refund_type_id', 'created_by', 'updated_by', 'is_active', 'submitted'], 'integer'],
            [['refund_claimant_amount'], 'number'],
            [['application_number', 'verificationCode'], 'required', 'on' => 'view-status'],
            [['pin'], 'required', 'on' => 'refund-login'],
            [['pin'], 'validatePin', 'on' => 'refund-login'],
            [['application_number'], 'validateApplicationNo', 'on' => 'view-status'],
            [['bank_account_number', 'bank_account_name', 'bank_name', 'branch', 'bank_card_document'], 'required', 'on' => 'refundBankDetailsAdd'],
            [['death_certificate_number', 'death_certificate_document'], 'required', 'on' => 'refundDeathDetails'],
            [['liquidation_letter_document', 'liquidation_letter_number'], 'required', 'on' => 'refundEmploymentDetails'],
            [['court_letter_number', 'court_letter_certificate_document','letter_family_session_document'], 'required', 'on' => 'refundCourtDetails'],
            [['trustee_firstname', 'trustee_midlename', 'trustee_surname', 'letter_family_session_document'], 'required', 'on' => 'refundFamilySessionDetails'],
            //[['social_fund_document','social_fund_status','social_fund_receipt_document'], 'required','on'=>'refundSocialFundDetails'],
            [['social_fund_status'], 'required', 'on' => 'refundSocialFundDetails'],
            [['created_at', 'updated_at', 'trustee_phone_number', 'trustee_email', 'trustee_email', 'bank_name', 'branch', 'bank_card_document', 'social_fund_status', 'social_fund_document', 'social_fund_receipt_document', 'liquidation_letter_document', 'liquidation_letter_number', 'death_certificate_number', 'death_certificate_document', 'court_letter_number', 'court_letter_certificate_document', 'letter_family_session_document', 'assignee', 'date_verified', 'last_verified_by', 'assigned_by', 'verification_response', 'current_level', 'soccialFundDocument', 'refundTypeExpalnation', 'refund_type_confirmed','employer_letter_document','educationAttained','claimant_names_changed_status','deed_pole_document','refundType'], 'safe'],
            [['death_certificate_document', 'court_letter_certificate_document', 'letter_family_session_document'], 'file', 'extensions' => ['pdf']],
            [['bank_card_document'], 'file', 'extensions' => ['pdf']],
            [['social_fund_document'], 'file', 'extensions' => ['pdf']],
            [['social_fund_receipt_document'], 'file', 'extensions' => ['pdf']],
            [['liquidation_letter_document'], 'file', 'extensions' => ['pdf']],
            [['deed_pole_document'], 'file', 'extensions' => ['pdf']],
            /*
              [['social_fund_receipt_document','social_fund_document'], 'required', 'when' => function($model) {
              return $model->social_fund_status == 1;
              }],
             */

            ['claimant_names_changed_status', 'required', 'when' => function ($model) {
                if($model->refundType ==1 || $model->refundType ==2) {
                    return 1;
                }
            }, 'whenClient' => "function (attribute, value) {
            if ($('#refundType_id').val() == 1 || $('#refundType_id').val() == 2) {
    return 1;
    }
}"],
            [['soccialFundDocument'], 'required', 'when' => function ($model) {
            return $model->social_fund_status == 1;
        }, 'whenClient' => "function (attribute, value) { 
             if ($('#social_fund_status_id').val() == 1) {
             return $('#social_fund_status_id input:checked').val() == 1;
             }				
			}"],
            [['social_fund_receipt_document', 'social_fund_document'], 'required', 'when' => function ($model) {
            return $model->soccialFundDocument == 1;
        },
                'whenClient' => "function (attribute, value) {
                if ($('#social_fund_status_id').val() == 1) {
				return $('#social_fund_status_id input:checked').val() == 1;
				}
			}"],
            [['social_fund_receipt_document', 'social_fund_document'], 'required', 'when' => function ($model) {
            return $model->soccialFundDocument == 1;
        }, 'whenClient' => "function (attribute, value) {
        if ($('#soccialFundDocument_id').val() == 1) {
				return $('#soccialFundDocument_id input:checked').val() == 1;
				}
			}"],
            [['deed_pole_document'], 'required', 'when' => function ($model) {
                return $model->claimant_names_changed_status == 1;
            }, 'whenClient' => "function (attribute, value) {
        if ($('#claimant_names_changed_status_id input:checked').val() == 1) {
				return $('#claimant_names_changed_status_id input:checked').val() == 1;
				}
			}"],
//            [['updated_at'], 'required'],
            [['application_number', 'check_number', 'bank_account_number', 'liquidation_letter_number'], 'string', 'max' => 50],
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
    public function attributeLabels() {
        return [
            'refund_application_id' => 'Refund Application ID',
            'refund_claimant_id' => 'Refund Claimant ID',
            'application_number' => 'Application Number',
            'refund_claimant_amount' => 'Refund Amount',
            'finaccial_year_id' => 'Finaccial Year ID',
            'academic_year_id' => 'Academic Year ID',
            'trustee_firstname' => 'Trustee Firstname',
            'trustee_midlename' => 'Trustee Midlename',
            'trustee_surname' => 'Trustee Surname',
            'trustee_sex' => 'Trustee Sex',
            'current_status' => 'Current Status',
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
            'submitted' => 'Submitted',
            'verification_response' => 'Verification Response',
            'current_level' => 'Current Level',
            'soccialFundDocument' => 'soccialFundDocument',
            'trustee_email' => 'Email',
            'refund_type_confirmed' => 'refund_type_confirmed',
            'employer_letter_document'=>'employer_letter_document',
            'educationAttained'=>'educationAttained',
            'claimant_names_changed_status'=>'Have you changed you names',
            'bank_card_document'=>'Bank Document',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear() {
        return $this->hasOne(\common\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank() {
        return $this->hasOne(\backend\modules\application\models\Bank::className(), ['bank_id' => 'bank_id']);
    }

    public function getRefundInternalOperationalSetting() {
        return $this->hasOne(\backend\modules\repayment\models\RefundInternalOperationalSetting::className(), ['refund_internal_operational_id' => 'current_level']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinaccialYear() {
        return $this->hasOne(\backend\modules\disbursement\models\FinancialYear::className(), ['financial_year_id' => 'finaccial_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundClaimant() {
        return $this->hasOne(RefundClaimant::className(), ['refund_claimant_id' => 'refund_claimant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundType() {
        return $this->hasOne(\backend\modules\repayment\models\RefundType::className(), ['refund_type_id' => 'refund_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundVerificationFramework() {
        return $this->hasOne(\backend\modules\repayment\models\RefundVerificationFramework::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }

    function validateApplicationNo() {
        if ($this->application_number) {
            if (self::find()->where(['application_number' => $this->application_number])->exists()) {
                return TRUE;
            }
            $this->addError('application_number', 'Invalid Application/Reference No');
            return FALSE;
        }
        $this->addError('application_number', 'Invalid Wrong Application/Reference No');
        return FALSE;
    }

    function validatePin() {
        if (\Yii::$app->session->has('user_otp_time')) {
            $otp_time = strtotime(\Yii::$app->session->get('user_otp_time'));
            $current_time = strtotime(date('Y-m-d H:i:s', time()));
            $time_difference = floor(($current_time - $otp_time) / (60 * 60));
            if ($this->pin && $time_difference > 60) {
                $this->addError($this->pin, 'PIN has Exipired, Please create a new PIN');
                return FALSE;
            }
            return TRUE;
        }
        $this->addError($this->pin, 'PIN has Exipired, Please create a new PIN');
        return FALSE;
    }

    static function getDetailsByApplicationNo($application_number) {
        return self::find()->where(['application_number' => $application_number])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperations() {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationInternalOperation::className(), ['refund_application_id' => 'refund_application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundClaimantAttachments() {
        return $this->hasMany(\backend\modules\repayment\models\RefundClaimantAttachment::className(), ['refund_application_id' => 'refund_application_id']);
    }

    public static function getStageChecked($level, $refund_claimant_id) {
        $status = 1;
        $models = \frontend\modules\repayment\models\RefundApplication::find()->where("refund_claimant_id='{$refund_claimant_id}'")->all();

        if (count($models) > 0) {
            /*
              foreach($models as $model){
              if($model->under_sponsorship==1&&$model->sponsor_proof_document==""){
              $status=$status*0;
              }
              ###################non-necta student
              if($model->is_necta==2&&$model->certificate_document==""){
              $status=$status*0;
              }
              ########################end ################
              }
             */
            $status = $status * 0;
        } else {
            $status = $status * 0;
        }

        return $status;
    }

    public static function getRefundApplicationDetails($refundClaimantid) {
        return self::findOne($refundClaimantid);
    }

    public static function getStageCheckedBankDetails($refundApplicationID) {
        $details_ = self::find()
                ->select('bank_account_number')
                ->where(['refund_application_id' => $refundApplicationID])
                ->one();
        $results = count($details_->bank_account_number);
        return $results;
    }

    public static function getStageCheckedApplicationGeneral($refundApplicationID) {
        return self::find()
                        ->select('refund_application.*')
                        ->where(['refund_application_id' => $refundApplicationID])
                        ->one();
        //$results=count($details_->bank_account_number);
        //return $results;
    }

    public static function getStageCheckedSocialFund($refundApplicationID) {
        $details_ = self::find()
                ->select('social_fund_status')
                ->where(['refund_application_id' => $refundApplicationID])
                ->one();
        $results = count($details_->social_fund_status);
        return $results;
    }

    static function getRefundApplicationDetailsById($id) {
        return self::find()->where(['refund_application_id' => $id])->one();
    }

    function getApplicationStatus() {
        return [
            self::APPLICATION_STATUS_SAVED => 'Saved',
            self::Preview_Complete => 'Preview Complete',
            self::Incomplete => 'Incomplete',
            self::Waiting => 'Waiting',
            self::Invalid => 'Invalid',
            self::Pending => 'Pending',
            self::Verification_Onprogress => 'Verification Onprogress',
            self::Verification_Complete => 'Verification Complete',
        ];
    }

    public function getCurrentStutusName() {
        $status = $this->getApplicationStatus();
        if (is_array($status) && isset($status[$this->current_status])) {
            return $status[$this->current_status];
        }
        return Null;
    }

    static function pendindApplicationForPaylistExist() {
        return self::find()->where(['current_status' => self::PAY_LIST_WAITING_QUEUE])->exists();
    }

}
