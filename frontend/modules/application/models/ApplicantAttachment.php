<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "applicant_attachment".
 *
 * @property integer $applicant_attachment_id
 * @property integer $application_id
 * @property integer $attachment_definition_id
 * @property string $attachment_path
 * @property integer $verification_status
 *
 * @property Application $application
 * @property AttachmentDefinition $attachmentDefinition
 */
class ApplicantAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'applicant_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'attachment_path'], 'required'],
           
           // [['attachment_path'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
              ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'applicant_attachment_id' => 'Applicant Attachment ID',
            'application_id' => 'Application ID',
            'attachment_definition_id' => 'Attachment Definition ID',
            'attachment_path' => 'Attachment Path',
            'verification_status' => 'Verification Status',
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
    public function getAttachmentComment()
    {
        return $this->hasOne(\backend\modules\application\models\VerificationCommentGroup::className(), ['verification_comment_group_id' => 'comment']);
    }
    public function SaveAttachments($application_id,$attachment_id,$attachment_name,$attachment_name_old)
    {
          if($attachment_name_old==1){
   Yii::$app->db->createCommand("DELETE FROM `applicant_attachment` WHERE `application_id`='{$application_id}' AND `attachment_definition_id`='{$attachment_id}'")->execute();
          }
          else{
       Yii::$app->db->createCommand("DELETE FROM `applicant_attachment` WHERE `application_id`='{$application_id}' AND `attachment_definition_id`='{$attachment_id}' AND attachment_path='{$attachment_name_old}'")->execute();
                
          }
        $model= New ApplicantAttachment();
            $model->application_id=$application_id;
            $model->attachment_definition_id=$attachment_id;
            $model->attachment_path=$attachment_name;
        $model->save();
        return $model;
    }
}
