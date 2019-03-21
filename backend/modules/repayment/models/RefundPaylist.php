<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_paylist".
 *
 * @property integer $refund_paylist_id
 * @property string $paylist_name
 * @property string $paylist_description
 * @property string $paylist_number
 * @property string $date_created
 * @property integer $created_by
 * @property string $date_updated
 * @property integer $updated_by
 * @property integer $status
 */
class RefundPaylist extends \yii\db\ActiveRecord {

    public $paylist_claimant;
    public $paylist_total_amount;
    public $rejection_narration;
    public $refund_application_id;

    const STATUS_CREATED = 1;
    const STATUS_CONFIRMED_SUBMITTED = 2;
    const STATUS_REVIEWED_AND_APPROVED = 3;
    const STATUS_PAID = 4;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'refund_paylist';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['paylist_name', 'paylist_number', 'created_by', 'status', 'paylist_description', 'paylist_claimant'], 'required'],
            [['paylist_name', 'paylist_number'], 'unique'],
            [['paylist_claimant'], 'validateClaimantList', 'on' => 'paylist-creation'],
            [['paylist_description'], 'string'],
            [['date_created', 'date_updated', 'paylist_total_amount','current_level','cheque_number','pay_description'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['paylist_name'], 'string', 'max' => 255],
            [['paylist_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'refund_paylist_id' => 'Refund Paylist ID',
            'paylist_name' => 'Paylist Name',
            'paylist_description' => 'Description',
            'paylist_number' => 'Paylist Number',
            'date_created' => 'Date Created',
            'created_by' => 'Created By',
            'date_updated' => 'Date Updated',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'paylist_claimant' => 'Claimants',
            'paylist_total_amount'=>'Total Amount',
            'current_level'=>'Current Level',
        ];
    }

    function getStatusOptions() {
        return [
            //self::STATUS_CREATED => 'Created',
            //self::STATUS_REVIEWED => 'Reviewed',
            //self::STATUS_APPROVED => 'Approved',
            self::STATUS_CREATED => 'NOT PAID',
            self::STATUS_CONFIRMED_SUBMITTED => 'NOT PAID',
            self::STATUS_REVIEWED_AND_APPROVED => 'NOT PAID',
            self::STATUS_PAID => 'PAID',
        ];
    }

    function getStatusName() {
        $status = $this->getStatusOptions();
        if (isset($status[$this->status])) {
            return $status[$this->status];
        }
        return NULL;
    }

    /*
     * validates if the claimant list is correct
     * 
     */

    function validateClaimantList() {
//        if (is_array($this->paylist_claimant) && count($this->paylist_claimant)) {
//            return FALSE;
//        }
        $this->addError($this->paylist_claimant, 'Please Select/Add Paylist Claimant(s)');
        return FALSE;
    }

    function getClaimantsListArray() {
        $claimant_list = [];
        $sql = "SELECT refund_application_id,application_number,refund_claimant_amount,refund_claimant.refund_claimant_id, firstname, middlename, surname 
                FROM refund_claimant INNER JOIN refund_application 
                ON refund_application.refund_claimant_id=refund_claimant.refund_claimant_id
                WHERE refund_application.current_status=" . \frontend\modules\repayment\models\RefundApplication::PAY_LIST_WAITING_QUEUE;

        $claimants = \frontend\modules\repayment\models\RefundApplication::findBySql($sql)->all();

        if ($claimants) {
            foreach ($claimants as $claimant) {

                $claimant_list[$claimant->refund_application_id] = strtoupper($claimant->application_number . ' - ' . $claimant->refundClaimant->firstname . ' ' . $claimant->refundClaimant->middlename . ' ' . $claimant->refundClaimant->surname) . '  - TSH: ' . number_format($claimant->refund_claimant_amount);
            }
        }
        return $claimant_list;
    }

    function hasPaylistItems() {
        return RefundPaylistDetails::find()->where(['refund_paylist_id' => $this->refund_paylist_id])->exists();
    }

    function getPaylistItems() {
        return RefundPaylistDetails::find()->where(['refund_paylist_id' => $this->refund_paylist_id])->all();
    }
    public function getRefundInternalOperational()
    {
        return $this->hasOne(RefundInternalOperationalSetting::className(), ['refund_internal_operational_id' => 'current_level']);
    }
    public static function currentStageLevelPaylist($refund_paylist_id){
        return  self::find()->where(['refund_paylist_id'=>$refund_paylist_id])->one();
    }

    public static function updateAllPaidRefundApplication($refund_paylist_id){

        $applicationDetails = self::findBySql("SELECT 
                    refund_application_id   FROM refund_paylist_details  where  refund_paylist_id ='$refund_paylist_id'")->all();

        if(count($applicationDetails) > 0) {
            foreach($applicationDetails AS $resultPaylistPaid){
                $refund_application_id=$resultPaylistPaid->refund_application_id;
                \frontend\modules\repayment\models\RefundApplication::updateAll(['current_status' =>10], 'refund_application_id ="' . $refund_application_id . '"');
                \backend\modules\repayment\models\RefundApplicationOperation::updateAll(['is_current_stage' =>0,'general_status'=>2], 'refund_application_id ="' . $refund_application_id . '"');
                \backend\modules\repayment\models\RefundPaylistOperation::updateAll(['is_current_stage' =>0,'general_status'=>2], 'refund_paylist_id ="' . $refund_paylist_id . '"');
            }
        }
    }

   

}
