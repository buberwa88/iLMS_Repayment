<?php

namespace backend\modules\repayment\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\User;
use backend\modules\appeal\models\AttachmentDefinition;

/**
 * This is the base model class for table "refund_verification_framework_item".
 *
 * @property integer $refund_verification_framework_item_id
 * @property integer $refund_verification_framework_id
 * @property integer $attachment_definition_id
 * @property string $verification_prompt
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property \backend\modules\repayment\models\AttachmentDefinition $attachmentDefinition
 * @property \backend\modules\repayment\models\User $createdBy
 * @property \backend\modules\repayment\models\User $updatedBy
 * @property \backend\modules\repayment\models\RefundVerificationFramework $refundVerificationFramework
 */
class RefundVerificationFrameworkItem extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'attachmentDefinition',
            'createdBy',
            'updatedBy',
            'refundVerificationFramework'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_verification_framework_id', 'attachment_definition_id', 'status', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['verification_prompt'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_verification_framework_item';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_verification_framework_item_id' => 'Refund Verification Framework Item ID',
            'refund_verification_framework_id' => 'Refund Verification Framework',
            'attachment_definition_id' => 'Attachment ',
            'verification_prompt' => 'Verification Prompt',
            'status' => 'Priority',
            'is_active' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentDefinition()
    {
        return $this->hasOne(AttachmentDefinition::className(), ['attachment_definition_id' => 'attachment_definition_id']);
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
    public function getRefundVerificationFramework()
    {
        return $this->hasOne(\backend\modules\repayment\models\RefundVerificationFramework::className(), ['refund_verification_framework_id' => 'refund_verification_framework_id']);
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
