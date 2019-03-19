<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_application_operation".
 *
 * @property integer $refund_application_operation_id
 * @property integer $refund_application_id
 * @property integer $refund_internal_operational_id
 * @property string $access_role
 * @property integer $status
 * @property integer $refund_status_reason_setting_id
 * @property string $narration
 * @property integer $assignee
 * @property string $assigned_at
 * @property integer $assigned_by
 * @property integer $last_verified_by
 * @property integer $is_current_stage
 * @property string $date_verified
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property User $assignedBy
 * @property User $assignee0
 * @property User $createdBy
 * @property User $lastVerifiedBy
 * @property RefundApplication $refundApplication
 * @property RefundComment $refundStatusReasonSetting
 * @property RefundInternalOperationalSetting $refundInternalOperational
 * @property User $updatedBy
 * @property RefundApplicationOperationLetter[] $refundApplicationOperationLetters
 * @property RefundApplicationProgress[] $refundApplicationProgresses
 */
class RefundApplicationOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_application_operation';
    }

    /**
     * @inheritdoc
     */
    public $f4indexno;
    public $firstname;
    public $middlename;
    public $surname;
    public $refund_type_id;
    public $current_status;
    public $verificationStatus;
    public $refund_statusreasonsettingid;
    public $refundType;
    public $retiredStatus;
    public $needStopDeductionOrNot;
    public $needNeedDenialLetter;
    public $item_name;
    public function rules()
    {
        return [
            [['refund_application_id', 'refund_internal_operational_id', 'status', 'refund_status_reason_setting_id', 'assignee', 'assigned_by', 'last_verified_by', 'is_current_stage', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['assigned_at', 'date_verified', 'created_at', 'updated_at','general_status','current_verification_response','previous_internal_operational_id'], 'safe'],
            [['created_at'], 'required'],
            //['needStopDeductionOrNot', 'validateNeedPermanentStopDeduction'],
            [['verificationStatus','refund_statusreasonsettingid','needStopDeductionOrNot'], 'required','on'=>'refundApplicationOeration'],
            //[['access_role'], 'string', 'max' => 50],
            [['narration'], 'string', 'max' => 500],
            /*
			[['needStopDeductionOrNot'], 'required', 'when' => function($model) {
            if($model->verificationStatus==1 && $model->refundType==1 && $model->retiredStatus==2) {
                return $model->verificationStatus == 1;
            }
        }],needNeedDenialLetter
*/
            /*
            [['needStopDeductionOrNot'], 'required', 'when' => function ($model) {
                if($model->verificationStatus==1 && $model->refundType==1 && $model->retiredStatus==2){
                    return 1;
                }
            },
                'whenClient' => "function (attribute, value) {
                    if ($('#verificationStatus_id').val() == 1 && $('#refundType_id').val() == 1 && $('#retiredStatus_id').val() == 2) {
                           return 1;
                        }
                  }"],
            [['needNeedDenialLetter'], 'required', 'when' => function ($model) {
                if($model->verificationStatus==2 && $model->refundType==1 && $model->retiredStatus==2){
                    return 1;
                }
            },
                'whenClient' => "function (attribute, value) {
                    if ($('#verificationStatus_id').val() == 2 && $('#refundType_id').val() == 1 && $('#retiredStatus_id').val() == 2) {
                           return 1;
                        }
                  }"],
            */

            [['assigned_by'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\User::className(), 'targetAttribute' => ['assigned_by' => 'user_id']],
            [['assignee'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\User::className(), 'targetAttribute' => ['assignee' => 'user_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['last_verified_by'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\User::className(), 'targetAttribute' => ['last_verified_by' => 'user_id']],
            [['refund_application_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\RefundApplication::className(), 'targetAttribute' => ['refund_application_id' => 'refund_application_id']],
            [['refund_status_reason_setting_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\RefundComment::className(), 'targetAttribute' => ['refund_status_reason_setting_id' => 'refund_comment_id']],
            [['refund_internal_operational_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\repayment\models\RefundInternalOperationalSetting::className(), 'targetAttribute' => ['refund_internal_operational_id' => 'refund_internal_operational_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\repayment\models\User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_application_operation_id' => 'Refund Application Operation ID',
            'refund_application_id' => 'Refund Application ID',
            'refund_internal_operational_id' => 'Refund Internal Operational ID',
            //'access_role' => 'Access Role',
            'status' => 'Status',
            'refund_status_reason_setting_id' => 'Refund Status Reason Setting ID',
            'narration' => 'Narration',
            'assignee' => 'Assignee',
            'assigned_at' => 'Assigned At',
            'assigned_by' => 'Assigned By',
            'last_verified_by' => 'Last Verified By',
            'is_current_stage' => 'Is Current Stage',
            'date_verified' => 'Date Verified',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
            'verificationStatus'=>'Verification Status',
            'refund_statusreasonsettingid'=>'Comment',
            'needStopDeductionOrNot'=>'Verification Response',
            'needNeedDenialLetter'=>'Need Denial Letter',
			'previous_internal_operational_id'=>'previous_internal_operational_id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedBy()
    {
        return $this->hasOne(\frontend\modules\repayment\models\User::className(), ['user_id' => 'assigned_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignee0()
    {
        return $this->hasOne(\frontend\modules\repayment\models\User::className(), ['user_id' => 'assignee']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\frontend\modules\repayment\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastVerifiedBy()
    {
        return $this->hasOne(\frontend\modules\repayment\models\User::className(), ['user_id' => 'last_verified_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplication()
    {
        return $this->hasOne(\frontend\modules\repayment\models\RefundApplication::className(), ['refund_application_id' => 'refund_application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundStatusReasonSetting()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundStatusReasonSetting::className(), ['refund_status_reason_setting_id' => 'refund_status_reason_setting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundInternalOperational()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundInternalOperationalSetting::className(), ['refund_internal_operational_id' => 'refund_internal_operational_id']);
    }
    public function getRefundInternalOperationalPrevious()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundInternalOperationalSetting::className(), ['refund_internal_operational_id' => 'previous_internal_operational_id']);
    }
    public function getVerificationResponse()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundVerificationResponseSetting::className(), ['refund_verification_response_setting_id' => 'current_verification_response']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\frontend\modules\repayment\models\User::className(), ['user_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperationLetters()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationOperationLetter::className(), ['refund_application_operation_id' => 'refund_application_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationProgresses()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationProgress::className(), ['refund_application_operation_id' => 'refund_application_operation_id']);
    }
    public static function getTotalApplicationAttempted($loggedIn,$todate){
        $applicationDetails = \frontend\modules\repayment\models\RefundApplication::findBySql("SELECT 
                    COUNT(refund_application_id) AS 'totalApplication'	   
                    FROM refund_application
                    where  	refund_application.submitted=3 AND refund_application.assignee='$loggedIn' AND date_verified like '%$todate%' AND last_verified_by='$loggedIn'")->one();
        return $applicationDetails->totalApplication;
    }
    public static function getTotalApplicationNotAttempted($loggedIn,$todate){
        $applicationDetails = \frontend\modules\repayment\models\RefundApplication::findBySql("SELECT 
                    COUNT(refund_application_id) AS 'totalApplication'	   
                    FROM refund_application
                    where  refund_application.submitted=3 AND assignee='$loggedIn'  AND (last_verified_by='' OR last_verified_by IS NULL)")->one();
        return $applicationDetails->totalApplication;
    }
    public static function insertRefundapplicationoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child)
    {
        $currentVerificationResponse=-1;
            Yii::$app->db->createCommand()
                ->insert('refund_application_operation', [
                    'refund_application_id' => $refund_application_id,
                    'refund_internal_operational_id' => $refund_internal_operational_id,
                    'access_role_master' => $access_role_master,
                    'access_role_child' => $access_role_child,
                    'created_at'=>date("Y-m-d H:i:s"),
                ])->execute();
        self::updateCurrentVerificationLevel($refund_internal_operational_id,$refund_application_id,$currentVerificationResponse);
        }

    public function validateNeedPermanentStopDeduction($attribute, $params) {
        //applicationCode
        //if ($attribute && $this->verificationStatus && $this->refundType && $this->retiredStatus) {
            if (($this->verificationStatus==1 && $this->refundType==1 && $this->retiredStatus==2) && $this->needStopDeductionOrNot==''){
                $this->addError($this->needStopDeductionOrNot,'Please Confirm');
                return FALSE;
            }
            return true;
        //}
        return true;
    }
    public static function insertRefundapplicationoperation_inoperation($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID)
    {
        Yii::$app->db->createCommand()
            ->insert('refund_application_operation', [
                'refund_application_id' => $refund_application_id,
                'refund_internal_operational_id' => $refund_internal_operational_id,
                'access_role_master' => $access_role_master,
                'access_role_child' => $access_role_child,
                'created_at'=>date("Y-m-d H:i:s"),
                'status'=>$verificationStatus,
                'refund_status_reason_setting_id'=>$refundStatusReasonSettingId,
                'narration'=>$narration,
                'last_verified_by'=>$lastVerifiedBy,
                'date_verified'=>$dataVerified,
                'general_status'=>$generalStatus,
                'current_verification_response'=>$currentVerificationResponse,
                'previous_internal_operational_id'=>$previousInterOperatID,
            ])->execute();
        self::updateCurrentVerificationLevel($refund_internal_operational_id,$refund_application_id,$currentVerificationResponse);
    }
    public static function insertRefundapplicationoperation_inoperationTemporaryLetter($refund_application_id,$refund_internal_operational_id,$access_role_master,$access_role_child,$verificationStatus,$refundStatusReasonSettingId,$narration,$lastVerifiedBy,$dataVerified,$generalStatus,$currentVerificationResponse,$previousInterOperatID)
    {
        Yii::$app->db->createCommand()
            ->insert('refund_application_operation', [
                'refund_application_id' => $refund_application_id,
                'refund_internal_operational_id' => $refund_internal_operational_id,
                'access_role_master' => $access_role_master,
                'access_role_child' => $access_role_child,
                'created_at'=>date("Y-m-d H:i:s"),
                'status'=>$verificationStatus,
                'refund_status_reason_setting_id'=>$refundStatusReasonSettingId,
                'narration'=>$narration,
                'last_verified_by'=>$lastVerifiedBy,
                'date_verified'=>$dataVerified,
                'general_status'=>$generalStatus,
                'is_current_stage'=>0,
                'current_verification_response'=>$currentVerificationResponse,
                'previous_internal_operational_id'=>$previousInterOperatID,
            ])->execute();
        self::updateCurrentVerificationLevel($refund_internal_operational_id,$refund_application_id,$currentVerificationResponse);
    }
    public static function getUserRoleByUserID($user_id){
        return self::findBySql('SELECT GROUP_CONCAT(item_name) as item_name FROM auth_assignment WHERE user_id="'.$user_id.'"')->one();
    }
    public static function getApplicationDEtails($RefundApplicationId){
        $applicationDetails = \frontend\modules\repayment\models\RefundApplication::findBySql("SELECT 
                    *   FROM refund_application INNER JOIN refund_claimant ON refund_claimant.refund_claimant_id=refund_application.refund_claimant_id    where  	refund_application.refund_application_id='$RefundApplicationId'")->one();
        return $applicationDetails;
    }
    public static function updateCurrentVerificationLevel($refund_internal_operational_id,$refund_application_id,$currentVerificationResponse){
$responseCode=\backend\modules\repayment\models\RefundVerificationResponseSetting::getVerificationResponseCode($currentVerificationResponse)->response_code;
        if($responseCode==\backend\modules\repayment\models\RefundVerificationResponseSetting::Permanent_stop_deduction_letter || $responseCode==\backend\modules\repayment\models\RefundVerificationResponseSetting::Concluded_Valid){
            $current_status=8;
            $details=self::getApplicationDEtails($refund_application_id);
            $date=date("Y-m-d");
            $loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
            $refund_claimant_amount=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($details->refundClaimant->applicant_id,$date,$loan_given_to);
        }else{
            $current_status=6;
            $refund_claimant_amount=null;
        }
        \frontend\modules\repayment\models\RefundApplication::updateAll(['current_level' =>$refund_internal_operational_id,'verification_response'=>$currentVerificationResponse,'current_status'=>$current_status,'refund_claimant_amount'=>$refund_claimant_amount], 'refund_application_id ="'.$refund_application_id.'"');
    }
}
