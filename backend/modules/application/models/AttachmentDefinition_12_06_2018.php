<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "attachment_definition".
 *
 * @property integer $attachment_definition_id
 * @property string $attachment_desc
 * @property double $max_size_MB
 * @property integer $require_verification
 * @property string $verification_prompt
 * @property string $attachment_code
 * @property integer $is_active
 *
 * @property AppealAttachment[] $appealAttachments
 * @property ApplicantCategoryAttachment[] $applicantCategoryAttachments
 * @property ApplicationAttachment[] $applicationAttachments
 * @property QpossibleResponse[] $qpossibleResponses
 * @property SectionQuestion[] $sectionQuestions
 */
class AttachmentDefinition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachment_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment_desc'], 'required'],
            [['max_size_MB'], 'number'],
            [['require_verification', 'is_active'], 'integer'],
            [['attachment_desc', 'verification_prompt'], 'string', 'max' => 500],
            [['attachment_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attachment_definition_id' => 'Attachment Definition ID',
            'attachment_desc' => 'Attachment Desc',
            'max_size_MB' => 'Max Size  Mb',
            'require_verification' => 'Require Verification',
            'verification_prompt' => 'Verification Prompt',
            'attachment_code' => 'Attachment Code',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppealAttachments()
    {
        return $this->hasMany(AppealAttachment::className(), ['attachment_definition_id' => 'attachment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicantCategoryAttachments()
    {
        return $this->hasMany(ApplicantCategoryAttachment::className(), ['attachment_definition_id' => 'attachment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationAttachments()
    {
        return $this->hasMany(ApplicationAttachment::className(), ['attachment_definition_id' => 'attachment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQpossibleResponses()
    {
        return $this->hasMany(QpossibleResponse::className(), ['attachment_definition_id' => 'attachment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionQuestions()
    {
        return $this->hasMany(SectionQuestion::className(), ['attachment_definition_id' => 'attachment_definition_id']);
    }
}
