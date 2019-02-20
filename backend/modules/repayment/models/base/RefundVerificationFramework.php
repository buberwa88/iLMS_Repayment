<?php

namespace backend\modules\repayment\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use frontend\modules\repayment\models\RefundApplication;
use common\models\User;

/**
 * This is the base model class for table "refund_verification_framework".
 *
 * @property integer $refund_verification_framework_id
 * @property string $verification_framework_title
 * @property string $verification_framework_desc
 * @property string $verification_framework_stage
 * @property string $support_document
 * @property string $created_at
 * @property integer $created_by
 * @property integer $confirmed_by
 * @property string $confirmed_at
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property \backend\modules\repayment\models\RefundApplication[] $refundApplications
 * @property \backend\modules\repayment\models\User $confirmedBy
 * @property \backend\modules\repayment\models\User $createdBy
 * @property \backend\modules\repayment\models\User $updatedBy
 * @property \backend\modules\repayment\models\RefundVerificationFrameworkItem[] $refundVerificationFrameworkItems
 */
class RefundVerificationFramework extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'refundApplications',
            'confirmedBy',
            'createdBy',
            'updatedBy',
            'refundVerificationFrameworkItems'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'confirmed_at', 'updated_at'], 'safe'],
            [['created_by', 'confirmed_by', 'updated_by', 'is_active'], 'integer'],
            [['verification_framework_title', 'verification_framework_desc', 'verification_framework_stage', 'support_document'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_verification_framework';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_verification_framework_id' => 'Refund Verification Framework ID',
            'verification_framework_title' => 'Framework Name',
            'verification_framework_desc' => 'Verification Framework Desc',
            'verification_framework_stage' => 'Verification Framework Stage',
            'support_document' => 'Support Document',
            'confirmed_by' => 'Confirmed By',
            'confirmed_at' => 'Confirmed At',
            'is_active' => 'Is Active',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplications()
    {
        return $this->hasMany(RefundApplication::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfirmedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'confirmed_by']);
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
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundVerificationFrameworkItems()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundVerificationFrameworkItem::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
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
