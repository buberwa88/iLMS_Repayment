<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "refund_internal_operational".
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
 * @property RefundApplicationInternalOperation[] $refundApplicationInternalOperations
 * @property User $createdBy
 * @property User $updatedBy
 */
class RefundInternalOperational extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_internal_operational';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flow_order_list', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'access_role_master' => 'Access Role Master',
            'access_role_child' => 'Access Role Child',
            'flow_order_list' => 'Flow Order List',
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
    public function getRefundApplicationInternalOperations()
    {
        return $this->hasMany(RefundApplicationInternalOperation::className(), ['refund_internal_operational_id' => 'refund_internal_operational_id']);
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
