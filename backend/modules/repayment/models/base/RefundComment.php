<?php

namespace backend\modules\repayment\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use backend\modules\appeal\models\AttachmentDefinition;
use common\models\User;

/**
 * This is the base model class for table "refund_comment".
 *
 * @property integer $refund_comment_id
 * @property integer $attachment_definition_id
 * @property string $comment
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_active
 *
 * @property \backend\modules\repayment\models\RefundApplicationOperation[] $refundApplicationOperations
 * @property \backend\modules\repayment\models\RefundClaimantAttachment[] $refundClaimantAttachments
 * @property \backend\modules\repayment\models\AttachmentDefinition $attachmentDefinition
 * @property \backend\modules\repayment\models\User $createdBy
 * @property \backend\modules\repayment\models\User $updatedBy
 */
class RefundComment extends \yii\db\ActiveRecord
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
            'refundClaimantAttachments',
            'attachmentDefinition',
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
            [['attachment_definition_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['comment'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund_comment';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'refund_comment_id' => 'Refund Comment',
            'attachment_definition_id' => 'Attachment',
            'comment' => 'Comment',
            'is_active' => 'Status',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundApplicationOperations()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundApplicationOperation::className(), ['refund_status_reason_setting_id' => 'refund_comment_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefundClaimantAttachments()
    {
        return $this->hasMany(\backend\modules\repayment\models\RefundClaimantAttachment::className(), ['refund_comment_id' => 'refund_comment_id']);
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
