<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_paylist_operation".
 *
 * @property integer $refund_application_operation_id
 * @property integer $refund_paylist_id
 * @property integer $refund_internal_operational_id
 * @property integer $previous_internal_operational_id
 * @property string $access_role_master
 * @property string $access_role_child
 * @property integer $status
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
 * @property integer $general_status
 *
 * @property RefundPaylist $refundPaylist
 * @property RefundInternalOperationalSetting $refundInternalOperational
 * @property RefundInternalOperationalSetting $previousInternalOperational
 */
class RefundPaylistOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    //refund paylist operation
    const Recommended_for_approval = 1;
    const Rejected = 2;
    const Approved = 3;
   //end

    public static function tableName()
    {
        return 'refund_paylist_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_paylist_id', 'refund_internal_operational_id', 'previous_internal_operational_id', 'status', 'assignee', 'assigned_by', 'last_verified_by', 'is_current_stage', 'created_by', 'updated_by', 'is_active', 'general_status'], 'integer'],
            [['assigned_at', 'date_verified', 'created_at', 'updated_at'], 'safe'],
            [['created_at'], 'required'],
            [['access_role_master', 'access_role_child'], 'string', 'max' => 50],
            [['narration'], 'string', 'max' => 500],
            [['refund_paylist_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundPaylist::className(), 'targetAttribute' => ['refund_paylist_id' => 'refund_paylist_id']],
            [['refund_internal_operational_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundInternalOperationalSetting::className(), 'targetAttribute' => ['refund_internal_operational_id' => 'refund_internal_operational_id']],
            [['previous_internal_operational_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefundInternalOperationalSetting::className(), 'targetAttribute' => ['previous_internal_operational_id' => 'refund_internal_operational_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_application_operation_id' => 'Refund Application Operation ID',
            'refund_paylist_id' => 'Refund Paylist ID',
            'refund_internal_operational_id' => 'Refund Internal Operational ID',
            'previous_internal_operational_id' => 'Previous Internal Operational ID',
            'access_role_master' => 'Access Role Master',
            'access_role_child' => 'Access Role Child',
            'status' => 'Status',
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
            'general_status' => 'General Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundPaylist()
    {
        return $this->hasOne(RefundPaylist::className(), ['refund_paylist_id' => 'refund_paylist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundInternalOperational()
    {
        return $this->hasOne(RefundInternalOperationalSetting::className(), ['refund_internal_operational_id' => 'refund_internal_operational_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreviousInternalOperational()
    {
        return $this->hasOne(RefundInternalOperationalSetting::className(), ['refund_internal_operational_id' => 'previous_internal_operational_id']);
    }

    public static function insertRefundPaylistOperation($refund_paylist_id, $refund_internal_operational_id, $previous_internal_operational_id, $access_role_master, $access_role_child, $status, $narration, $lastVerifiedBy, $dataVerified, $generalStatus)
    {
        Yii::$app->db->createCommand()
            ->insert('refund_paylist_operation', [
                'refund_paylist_id' => $refund_paylist_id,
                'refund_internal_operational_id' => $refund_internal_operational_id,
                'access_role_master' => $access_role_master,
                'access_role_child' => $access_role_child,
                'created_at' => date("Y-m-d H:i:s"),
                'status' => $status,
                'narration' => $narration,
                'last_verified_by' => $lastVerifiedBy,
                'date_verified' => $dataVerified,
                'general_status' => $generalStatus,
                'previous_internal_operational_id' => $previous_internal_operational_id,
            ])->execute();
        self::updateCurrentVerificationLevel($refund_internal_operational_id,$refund_paylist_id);
    }

    public static function updateCurrentVerificationLevel($refund_internal_operational_id,$refund_paylist_id)
    {
        \backend\modules\repayment\models\RefundPaylist::updateAll(['current_level' => $refund_internal_operational_id], 'refund_paylist_id ="' . $refund_paylist_id . '"');
    }
    public static function updatePaylist($refund_paylist_id) {
        self::updateAll(['is_current_stage' => 0], 'refund_paylist_id ="' . $refund_paylist_id . '"');
    }
    public static function getPaylistOperationCurrentStage($refund_paylist_id,$finalValue){
       return self::findBySql("SELECT is_current_stage,refund_internal_operational_id,status  FROM refund_paylist_operation
                    where  	refund_paylist_id='$refund_paylist_id' AND (access_role_master IN($finalValue) OR access_role_child  IN($finalValue)) ORDER BY refund_application_operation_id DESC")->one();
    }
}
