<?php

namespace backend\modules\repayment\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "refund_internal_operational_setting".
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
 * @property \backend\modules\repayment\models\RefundApplicationOperation[] $refundApplicationOperations
 * @property \backend\modules\repayment\models\User $createdBy
 * @property \backend\modules\repayment\models\User $updatedBy
 */
class RefundInternalOperationalSetting extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'refundApplicationOperations',
            'createdBy',
            'updatedBy'
        ];
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
            [['code'], 'string', 'max' => 50]
        ];
    }

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
    public function attributeLabels()
    {
        return [
            'refund_internal_operational_id' => 'Refund Internal Operational ID',
            'name' => 'Name',
            'code' => 'Code',
            'access_role_master' => 'Access Role Master',
            'access_role_child' => 'Access Role Child',
            'flow_order_list' => 'Flow Order List',
            'is_active' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperations()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationOperation::className(), ['refund_internal_operational_id' => 'refund_internal_operational_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\backend\modules\repayment\models\User::className(), ['user_id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(\backend\modules\repayment\models\User::className(), ['user_id' => 'updated_by']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => \Yii::$app->user->identity->user_id,
            ],
        ];
    }
}
