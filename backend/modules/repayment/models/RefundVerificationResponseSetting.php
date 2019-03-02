<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_verification_response_setting".
 *
 * @property integer $refund_status_reason_setting_id
 * @property string $response_code
 * @property string $access_role_master
 * @property string $access_role_child
 * @property string $reason
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class RefundVerificationResponseSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const Temporary_stop_Deduction_letter = 'TSDL';
    const No_stop_deduction_needed = 'NSTL';
    const Need_investigation = 'NIVST';
    const Need_further_verification = 'NFV';
    const Permanent_stop_deduction_letter = 'PSDL';
    const Concluded_Valid = 'CLV';
    const Issue_denial_letter = 'DL';

    public static function tableName()
    {
        return 'refund_verification_response_setting';
    }

    /**
     * @inheritdoc
     */
    public $id;
    public function rules()
    {
        return [
            [['created_at', 'updated_at','is_active','verification_status'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['response_code'], 'string', 'max' => 20],
            [['access_role_master', 'access_role_child'], 'string', 'max' => 50],
            [['reason'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_verification_response_setting_id' => 'Refund verification response Setting ID',
            'response_code' => 'Response Code',
            'access_role_master' => 'Access Role Master',
            'access_role_child' => 'Access Role Child',
            'reason' => 'Response',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'verification_status'=>'Verification Status',
        ];
    }

    public static function getRefundStatusResponseSetting($status,$refund_type_id,$retired_status) {
        if($status==4){
            if($refund_type_id==1 && $retired_status==2){
                $data2 = \backend\modules\repayment\models\RefundVerificationResponseSetting::findBySql(" SELECT refund_verification_response_setting_id AS id, reason AS name FROM  refund_verification_response_setting WHERE verification_status='$status' AND is_active='1' AND response_code IN('TSDL','NSTL') ")->asArray()->all();
            }else{
                $data2 = \backend\modules\repayment\models\RefundVerificationResponseSetting::findBySql(" SELECT refund_verification_response_setting_id AS id, reason AS name FROM  refund_verification_response_setting WHERE verification_status='$status' AND is_active='1' AND response_code='NIVST'")->asArray()->all();
            }
        }else if($status==1){
            if($refund_type_id==1 && $retired_status==2){
                $data2 = \backend\modules\repayment\models\RefundVerificationResponseSetting::findBySql(" SELECT refund_verification_response_setting_id AS id, reason AS name FROM  refund_verification_response_setting WHERE verification_status='$status' AND is_active='1' AND response_code='PSDL' ")->asArray()->all();
            }else{
                $data2 = \backend\modules\repayment\models\RefundVerificationResponseSetting::findBySql(" SELECT refund_verification_response_setting_id AS id, reason AS name FROM  refund_verification_response_setting WHERE verification_status='$status' AND is_active='1' AND response_code='CLV'")->asArray()->all();
            }
        }else{
            $data2 = \backend\modules\repayment\models\RefundVerificationResponseSetting::findBySql(" SELECT refund_verification_response_setting_id AS id, reason AS name FROM  refund_verification_response_setting WHERE verification_status='$status' AND is_active='1'")->asArray()->all();
        }
        $value2 = (count($data2) == 0) ? ['' => ''] : $data2;
        return $value2;
    }
    public static function getVerificationResponseCode($verificationResponse_id){
            $responseDetails = self::findBySql("SELECT response_code FROM  refund_verification_response_setting WHERE  refund_verification_response_setting_id='$verificationResponse_id' AND  is_active='1'")->one();

        return $responseDetails;
    }

    public static function getRefundVerificationResponseSettingByCodeConcat($groupCode){
        $codesID= self::findBySql("SELECT GROUP_CONCAT(refund_verification_response_setting_id) as id FROM refund_verification_response_setting WHERE response_code IN($groupCode)")->one();
        return $codesID->id;
    }


/*
	static function getVerificationResponCode() {
        return [
		    self::Concluded_Valid => 'Concluded Valid',
            self::Issue_denial_letter => 'Issue Denial Letter',
            self::Temporary_stop_Deduction_letter => 'Issue Temporary Stop Deduction',
            self::Permanent_stop_deduction_letter => 'Issue Permanent Stop Deduction',
            self::Need_further_verification => 'Need Further Verification',
            self::Need_investigation => 'Need Investigation',
            self::No_stop_deduction_needed => 'No Stop Deduction Needed',
        ];
    }
	*/

	static function getVerificationResponCode() {
        return [
		    self::Concluded_Valid => 'CLV',
            self::Issue_denial_letter => 'DL',
            self::Temporary_stop_Deduction_letter => 'TSDL',
            self::Permanent_stop_deduction_letter => 'PSDL',
            self::Need_further_verification => 'NFV',
            self::Need_investigation => 'NIVST',
            self::No_stop_deduction_needed => 'NSTL',
        ];
    }
	
}
