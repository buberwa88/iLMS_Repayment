<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "loan_repayment_item".
 *
 * @property integer $loan_repayment_item_id
 * @property string $item_name
 * @property string $item_code
 * @property integer $is_active
 * @property string $created_at
 * @property integer $created_by
 *
 * @property LoanSummaryDetail[] $LoanSummaryDetails
 * @property User $createdBy
 * @property LoanRepaymentSetting[] $loanRepaymentSettings
 */
class LoanRepaymentItem extends \yii\db\ActiveRecord
{
    const ITEM_ORDER_LIST_1 = 1;
    const ITEM_ORDER_LIST_2 = 2;
    const ITEM_ORDER_LIST_3 = 3;
    const ITEM_ORDER_LIST_4 = 4;    
    const ITEM_ORDER_LIST_CONDITION_1=1;
    const ITEM_ORDER_LIST_CONDITION_2=2;

    const PRINCIPAL='PRC';
    const Loan_Administration_Fee='LAF';
    const Penalty='PNT';
    const Value_Retention_Fee='VRF';
    const Employer_Penalty='EPNT';
    const testing='TEST';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loan_repayment_item';
    }
    
    public $is_parent_child;
    public $item_status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'item_code', 'created_at', 'created_by', 'is_active','payable_status','is_parent_child'], 'required'],
            [['is_active', 'created_by'], 'integer'],
			[['item_code'], 'unique', 'message'=>'Item code already exist!'],
            [['created_at','payable_status','payable_order_list','payable_order_list_status','parent_id','item_status'], 'safe'],
            ['parent_id', 'required', 'when' => function ($model) {
    return $model->is_parent_child == 2;
}, 'whenClient' => "function (attribute, value) {
    return $('#is_parent_child_id').val() == 2;
}"],
        ['payable_order_list', 'required', 'when' => function ($model) {
    return $model->payable_status == 1;
}, 'whenClient' => "function (attribute, value) {
    return $('#payable_status_id').val() == 1;
}"],
        ['payable_order_list_status', 'required', 'when' => function ($model) {
    return $model->payable_status == 1;
}, 'whenClient' => "function (attribute, value) {
    return $('#payable_status_id').val() == 1;
}"],
            [['item_name'], 'string', 'max' => 45],
            [['item_code'], 'string', 'max' => 5],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'loan_repayment_item_id' => 'Loan Repayment Item ID',
            'parent_id'=>'Parent',
            'item_name' => 'Item Name',
            'item_code' => 'Item Code',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'payable_status'=>'Payment Order',
            'payable_order_list'=>'payable_order_list',
            'payable_order_list_status'=>'payable_order_list_status',
            'is_parent_child'=>'Is Parent?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanSummaryDetails()
    {
        return $this->hasMany(LoanSummaryDetail::className(), ['loan_repayment_item_id' => 'loan_repayment_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentSettings()
    {
        return $this->hasMany(LoanRepaymentSetting::className(), ['loan_repayment_item_id' => 'loan_repayment_item_id']);
    }
    public function getLoanRepaymentItem()
    {
        return $this->hasOne(LoanRepaymentItem::className(), ['loan_repayment_item_id' => 'parent_id']);
    }
    static function getLoanItemPaymentOrderList() {
        return [
            self::ITEM_ORDER_LIST_1 => '1',
            self::ITEM_ORDER_LIST_2 => '2',
            self::ITEM_ORDER_LIST_3 => '3',    
            self::ITEM_ORDER_LIST_4 => '4', 
        ];
    }
    static function getLoanItemPaymentOrderListCondition() {
        return [
            self::ITEM_ORDER_LIST_CONDITION_1 => 'Full paid before other items',
            self::ITEM_ORDER_LIST_CONDITION_2 => 'Partially Depending onthe item rate', 
        ];
    }
    public static function checkItemUsed($repaymentItemID){
        $countExist=0;
        $loanRepaymentItemSetting = \backend\modules\repayment\models\LoanRepaymentSetting::findBySql("SELECT * FROM loan_repayment_setting WHERE  loan_repayment_item_id='$repaymentItemID'")->count();
        if($loanRepaymentItemSetting > 0){
            $countExist=1;
        }
        $loanRepaymentSummaryDetail = \backend\modules\repayment\models\LoanSummaryDetail::findBySql("SELECT * FROM loan_summary_detail WHERE  loan_repayment_item_id='$repaymentItemID'")->count();
        if($loanRepaymentSummaryDetail > 0){
            $countExist=1;
        }
        $loan_repayment_detail = \backend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT * FROM loan_repayment_detail WHERE  loan_repayment_item_id='$repaymentItemID'")->count();
        if($loan_repayment_detail > 0){
            $countExist=1;
        }
        $loan_repayment_item = \backend\modules\repayment\models\LoanRepaymentItem::findBySql("SELECT * FROM  loan_repayment_item WHERE  payable_status='$repaymentItemID'")->count();
        if($loan_repayment_item > 1){
            $countExist=1;
        }

    return $countExist;
    }

    static function getLoanRepaymentItemList() {
        return [
            self::PRINCIPAL=>'PRC',
            self::Loan_Administration_Fee=>'LAF',
            self::Penalty=>'PNT',
            self::Value_Retention_Fee=>'VRF',
            self::Employer_Penalty=>'EPNT',
            self::testing=>'TEST',
        ];
    }
    
}
