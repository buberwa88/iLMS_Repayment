<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_framework_item_passed".
 *
 * @property integer $verification_framework_item_passed_id
 * @property integer $verification_framework_item_id
 * @property integer $verification_framework_id
 * @property integer $application_id
 * @property integer $attachment_definition_id
 * @property string $attachment_desc
 * @property string $verification_prompt
 * @property string $created_at
 * @property integer $created_by
 * @property integer $category
 * @property integer $is_active
 * @property string $last_updated_at
 * @property integer $last_updated_by
 *
 * @property Application $application
 * @property AttachmentDefinition $attachmentDefinition
 * @property VerificationFrameworkItem $verificationFrameworkItem
 */
class VerificationFrameworkItemPassed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_framework_item_passed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_framework_item_id', 'verification_framework_id', 'application_id', 'attachment_definition_id', 'created_by', 'category', 'is_active', 'last_updated_by'], 'integer'],
            [['verification_framework_id', 'attachment_definition_id', 'attachment_desc', 'verification_prompt', 'created_at', 'created_by'], 'required'],
            [['created_at', 'last_updated_at'], 'safe'],
            [['attachment_desc', 'verification_prompt'], 'string', 'max' => 100],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::className(), 'targetAttribute' => ['application_id' => 'application_id']],
            [['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
            [['verification_framework_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => VerificationFrameworkItem::className(), 'targetAttribute' => ['verification_framework_item_id' => 'verification_framework_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_framework_item_passed_id' => 'Verification Framework Item Passed ID',
            'verification_framework_item_id' => 'Verification Framework Item ID',
            'verification_framework_id' => 'Verification Framework ID',
            'application_id' => 'Application ID',
            'attachment_definition_id' => 'Attachment Definition ID',
            'attachment_desc' => 'Attachment Desc',
            'verification_prompt' => 'Verification Prompt',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'category' => 'Category',
            'is_active' => 'Is Active',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['application_id' => 'application_id']);
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
    public function getVerificationFrameworkItem()
    {
        return $this->hasOne(VerificationFrameworkItem::className(), ['verification_framework_item_id' => 'verification_framework_item_id']);
    }
    
    public static function insertPassedAttachments($verification_framework_item_id,$verification_framework_id,$application_id,$attachment_definition_id,$attachment_desc,$verification_prompt,$created_at,$created_by,$category,$is_active,$last_updated_at,$last_updated_by){
		Yii::$app->db->createCommand()
        ->insert('verification_framework_item_passed', [
                'verification_framework_item_id' =>$verification_framework_item_id,
		'verification_framework_id' =>$verification_framework_id,
		'application_id' =>$application_id,
		'attachment_definition_id' =>$attachment_definition_id,
		'attachment_desc' =>$attachment_desc,
		'verification_prompt' =>$verification_prompt,
		'created_at' =>$created_at,
		'created_by' =>$created_by,
		'category' =>$category,
		'is_active' =>$is_active,
		'last_updated_at' =>$last_updated_at,
		'last_updated_by' =>$last_updated_by,		   
        ])->execute();
    }
    public static function checkExist($verification_framework_item_id,$application_id) {
            if (self::find()->where('verification_framework_item_id=:verification_framework_item_id AND application_id=:application_id', [':verification_framework_item_id' => $verification_framework_item_id,':application_id'=>$application_id])
                            ->exists()) {
                return 1;
            }
            return 0;
        }

static function getVerificationFrameworkItemPassed($application_id,$verificationFrameworkID){
          return new \yii\data\ActiveDataProvider([
            'query' => self::find()->where(['verification_framework_id' =>$verificationFrameworkID,'application_id'=>$application_id]),
        ]);
    }
}
