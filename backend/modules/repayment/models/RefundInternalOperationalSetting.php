<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_internal_operational_setting".
 *
 * @property integer $refund_internal_operational_id
 * @property string $name
 * @property string $code
 * @property string $access_role_master
 * @property string $access_role_child
 * @property integer $flow_order_list
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property RefundApplicationOperation[] $refundApplicationOperations
 * @property User $createdBy
 * @property User $updatedBy
 */
class RefundInternalOperationalSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_internal_operational_setting';
    }

    /**
     * @inheritdoc
     */
    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;
    const STATUS_NEED_FURTHER_VERIFICATION = 3;
    const VERIFICATION_STATUS_NEED_INVESTIGATION = 4;

    const loan_recovery_data_section_c = 'LRDS';
    const validation_section_c = 'VLSC';
    const audit_investigation_department_c = 'AIND';
    const director_loan_recovery_repayment_c = 'DLRR';
    const executive_director_c = 'ED';
	const account_section_c = 'AS';
	
	//configuration for application and pay list flow
    const FLOW_TYPE_APPLICATION = 1;
	const FLOW_TYPE_PAY_LIST = 2;
	

    const loan_recovery_data_section = 'loan_recovery_data_section';
    const loan_recovery_data_section_officer = 'loan_recovery_data_section_officer';
    const validation_section = 'validation_section';
    const validation_section_officer ='validation_section_officer';
    const audit_investigation_department = 'audit_investigation_department';
    const audit_investigation_department_officer='audit_investigation_department_officer';
    const director_loan_recovery_repayment = 'director_loan_recovery_repayment';
    const director_loan_recovery_repayment_officer = 'director_loan_recovery_repayment_officer';
    const executive_director = 'executive_director';
    const executive_director_officer = 'executive_director_officer';
    const account_section = 'account_section';
    const account_section_officer = 'account_section_officer';

    public function rules()
    {
        return [
            [['flow_order_list', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at','flow_type'], 'safe'],
            [['name', 'access_role_master', 'access_role_child'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 50],
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
            'refund_internal_operational_id' => 'Refund Internal Operational ID',
            'name' => 'Name',
            'code' => 'Code',
            'access_role_master' => 'Access Role',
            'access_role_child' => 'Access Role Child',
            'flow_order_list' => 'Flow Order List',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_active' => 'Is Active',
			'flow_type'=>'flow_type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperations()
    {
        return $this->hasMany(RefundApplicationOperation::className(), ['refund_internal_operational_id' => 'refund_internal_operational_id']);
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

    public static function getSettingDetails()
    {
        $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  flow_order_list='2' AND is_active='1' AND is_active='1'")->one();
        return $refundInterOperSetting;
    }
    static function getVerificationStatus() {
        return array(
            self::STATUS_VALID => 'Valid',
            self::STATUS_INVALID => 'Invalid',
            self::STATUS_NEED_FURTHER_VERIFICATION => 'Need Further Verification',
        );
    }
    public static function getNextFlow($currentFlow_id,$statusResponse,$orderList_ASC_DESC,$condition){
        if($statusResponse=='REFUND_DATA_SECTION') {
            $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  access_role_master='loan_recovery_data_section' AND is_active='1'")->one();
        }else if($statusResponse=='AUDIT_INVEST_SECTION') {
            $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  access_role_master='audit_investigation_department' AND is_active='1'")->one();
        } else{
            $refundInterOperSetting = self::findBySql("SELECT * FROM  refund_internal_operational_setting WHERE  refund_internal_operational_id $condition $currentFlow_id AND  is_active='1' ORDER BY refund_internal_operational_id $orderList_ASC_DESC")->one();
        }
        return $refundInterOperSetting;
    }
    static function getVerificationStatusResponse() {
        return array(
            self::VERIFICATION_RESPONSE_TEMP_STOP_DEDUCT => 'Issue temporary stop deduction',
            self::VERIFICATION_RESPONSE_PERMANENT_STOP_DEDUCT => 'Issue permanent stop deduction',
            self::VERIFICATION_RESPONSE_INVEST_TEMP_STOP_DEDUCT => 'Need Invest. with temporary stop deduction',
            self::VERIFICATION_RESPONSE_INVEST_NO_STOP_DEDUCT => 'Need invest. with no stop deduction',
            self::VERIFICATION_RESPONSE_NEED_FURTHER_VERFICATION => 'Need Further Verification',
            self::VERIFICATION_RESPONSE_CONCLUDED_VALID => 'Concluded Valid',
            self::VERIFICATION_RESPONSE_NEED_DENIAL_LETTER => 'Need Denial Letter',
        );
    }
    static function getVerificationStatusAuditSection() {
        return array(
            self::STATUS_VALID => 'Valid',
            self::STATUS_INVALID => 'Invalid',
            self::VERIFICATION_STATUS_NEED_INVESTIGATION => 'Need Investigation',

        );
    }
    static function getUserRoles() {
        return array(
            self::loan_recovery_data_section => 'Loan Recovery Data Section-Supervisor',
            self::loan_recovery_data_section_officer => 'Loan Recovery Data Section-Officer',
            self::validation_section => 'Validation Section-Supervisor',
            self::validation_section_officer => 'Validation Section-Officer',
            self::audit_investigation_department => 'Audit & Investigation Department-Supervisor',
            self::audit_investigation_department_officer => 'Audit & Investigation Department-Officer',
            self::director_loan_recovery_repayment => 'Director of Loan Recovery-Supervisor',
            //self::director_loan_recovery_repayment_officer => 'Director of Loan Recovery-Supervisor',
            self::executive_director => 'Executive Director',
            //self::executive_director_officer => 'Need Further Verification',
            self::account_section => 'Account Section',
            //self::account_section_officer => 'Need Further Verification',
        );
    }
}
