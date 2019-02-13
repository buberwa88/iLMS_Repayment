<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "loan_repayment_setting".
 *
 * @property integer $loan_repayment_setting_id
 * @property integer $loan_repayment_item_id
 * @property string $start_date
 * @property string $end_date
 * @property double $percent
 * @property string $created_at
 * @property integer $created_by
 *
 * @property LoanRepaymentItem $loanRepaymentItem
 * @property User $createdBy
 */
class LoanRepaymentSetting extends \yii\db\ActiveRecord
{
    
    const CHARGING_INTERVAL_ONCE = "ONCE";
    const CHARGING_INTERVAL_HOURLY = "HOURLY";
    const CHARGING_INTERVAL_DAILY = "DAILY";
    const CHARGING_INTERVAL_MONTHLY = "MONTHLY";
    const CHARGING_INTERVAL_ANNUALLY = "ANNUALLY";
    const ITEM_APPLICABLE_SCOPE_LOANEE = "LOANEE";
    const ITEM_APPLICABLE_SCOPE_EMPLOYER = "EMPLOYER";
    const FORMULA_STAGE_0=0;
    const FORMULA_STAGE_1=1;
    const FORMULA_STAGE_2=2;
	/////constats for formula stage level
	const FORMULA_STAGE_LEVEL_DISBUSRMENT=1;
    const FORMULA_STAGE_LEVEL_DUE_LOAN=2;
    const FORMULA_STAGE_ON_REPAYMENT=3;
	////cosntants for formalar stage due loan
	const FORMULA_STAGE_LEVEL_DUE_LOAN_AFTER_GRADUATION=1;
	const FORMULA_STAGE_LEVEL_DUE_LOAN_AFTER_ACADEMIC_YEAR=2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loan_repayment_setting';
    }
	public $item_name;
	public $penalty;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_repayment_item_id', 'rate', 'calculation_mode','rate_type','charging_interval','item_applicable_scope','start_date'], 'required'],
            [['loan_repayment_item_id', 'created_by'], 'integer'],
            [['start_date','end_date', 'created_at','calculation_mode','is_active','item_name','charging_interval','rate_type','item_applicable_scope','item_formula','formula_stage','employer_type_id','payment_deadline_day_per_month','loan_repayment_rate','formula_stage_level','formula_stage_level_condition','grace_period'], 'safe'],
            [['rate'], 'number'],
            [['loan_repayment_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanRepaymentItem::className(), 'targetAttribute' => ['loan_repayment_item_id' => 'loan_repayment_item_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_repayment_setting_id' => 'Loan Repayment Setting ID',
            'loan_repayment_item_id' => 'Item Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'rate' => 'Rate',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
	    'calculation_mode'=>'calculation_mode',
	    'is_active'=>'Activate This Setting?',
	    'item_name'=>'Item Name',
            'charging_interval'=>'Charging Interval',
            'rate_type'=>'Rate Type',
            'item_applicable_scope'=>'item_applicable_scope',
            'item_formula'=>'item_formula',
            'formula_stage'=>'formula_stage',
            'employer_type_id'=>'employer_type_id',
            'payment_deadline_day_per_month'=>'payment_deadline_day_per_month',
            'loan_repayment_rate'=>'loan_repayment_rate',
            'formula_stage_level'=>'Level',
            'formula_stage_level_condition'=>'Level Condition',
            'grace_period'=>'Grace Period',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentItem()
    {
        return $this->hasOne(LoanRepaymentItem::className(), ['loan_repayment_item_id' => 'loan_repayment_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }
	public static function updateOldRepaymentItemSettings($loan_repayment_item_id,$loan_repayment_setting_id){
	   $end_date=date("Y-m-d");
       LoanRepaymentSetting::updateAll(['end_date' =>$end_date,'is_active' =>0], 'loan_repayment_item_id="'.$loan_repayment_item_id.'" AND loan_repayment_setting_id<>"'.$loan_repayment_setting_id.'" AND is_active="1"');
    }
    static function getLoanItemRepaymentChargingInterval() {
        return [
            self::CHARGING_INTERVAL_ONCE => 'ONCE',
            self::CHARGING_INTERVAL_HOURLY => 'HOURLY',
            self::CHARGING_INTERVAL_DAILY => 'DAILY',    
            self::CHARGING_INTERVAL_MONTHLY => 'MONTHLY', 
            self::CHARGING_INTERVAL_ANNUALLY => 'ANNUALLY',
        ];
    }
    static function getLoanItemRepaymentiapplicableScope() {
        return [
            self::ITEM_APPLICABLE_SCOPE_LOANEE => 'LOANEE',
            self::ITEM_APPLICABLE_SCOPE_EMPLOYER => 'EMPLOYER',
        ];
    }    
    static function getLoanItemPaymentFormulaStage() {
        return [
            self::FORMULA_STAGE_0 => 'General',
            self::FORMULA_STAGE_1 => 'Before Repayment',
            self::FORMULA_STAGE_2 => 'On Repayment', 
        ];
    }
	public static function getLoanRepaymentRateVRF($vrfID){
	return  self::findBySql("SELECT loan_repayment_rate FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_setting.loan_repayment_item_id='$vrfID' AND loan_repayment_setting.is_active='1' AND loan_repayment_setting.formula_stage='2' AND loan_repayment_item.item_code='VRF' AND loan_repayment_item.is_active='1'")->one();	
	}
	public static function getLoanRepaymentRateOtherItems($itemsID){
	return  self::findBySql("SELECT loan_repayment_rate FROM loan_repayment_setting INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_setting.loan_repayment_item_id WHERE  loan_repayment_setting.loan_repayment_item_id='$itemsID' AND loan_repayment_setting.is_active='1' AND loan_repayment_item.is_active='1'")->one();	
	}
}
