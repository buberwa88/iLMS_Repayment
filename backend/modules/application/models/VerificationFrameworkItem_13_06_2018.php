<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_framework_item".
 *
 * @property integer $verification_framework_item_id
 * @property integer $verification_framework_id
 * @property integer $attachment_definition_id
 * @property string $attachment_desc
 * @property string $verification_prompt
 * @property string $created_at
 * @property integer $created_by
 * @property integer $is_active
 *
 * @property AttachmentDefinition $attachmentDefinition
 * @property VerificationFramework $verificationFramework
 */
class VerificationFrameworkItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_framework_item';
    }

    /**
     * @inheritdoc
     */
    public $is_active;
    public function rules()
    {
        return [
            [['verification_framework_id', 'attachment_definition_id', 'attachment_desc', 'verification_prompt', 'created_at', 'created_by'], 'required'],
            [['verification_framework_id', 'attachment_definition_id', 'created_by', 'is_active'], 'integer'],
            [['attachment_definition_id'],'validateVerificationFramework'],
            [['created_at'], 'safe'],
            [['attachment_desc', 'verification_prompt'], 'string', 'max' => 100],
            [['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
            [['verification_framework_id'], 'exist', 'skipOnError' => true, 'targetClass' => VerificationFramework::className(), 'targetAttribute' => ['verification_framework_id' => 'verification_framework_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_framework_item_id' => 'Verification Framework Item ID',
            'verification_framework_id' => 'Verification Framework ID',
            'attachment_definition_id' => 'Attachment',
            'attachment_desc' => 'Attachment Desc',
            'verification_prompt' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'is_active' => 'Is Active',
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
    public function getVerificationFramework()
    {
        return $this->hasOne(VerificationFramework::className(), ['verification_framework_id' => 'verification_framework_id']);
    }
    static function getVerificationItemById($id){
          return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where('verification_framework_id=:id',[':id' => $id]),
        ]);
    }
    public function validateVerificationFramework($attribute) {
        if ($attribute && $this->verification_framework_id && $this->attachment_definition_id) {
            if (self::find()->where('verification_framework_id=:verification_framework_id AND attachment_definition_id=:attachment_definition_id', [':verification_framework_id' => $this->verification_framework_id,':attachment_definition_id'=>$this->attachment_definition_id])
                            ->exists()) {
                $this->addError($attribute,' Verification item already exists');
                return FALSE;
            }
        }
        return true;
    }
}
