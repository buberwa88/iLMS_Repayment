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
    //public $is_active;
    public $verification_status;
    public $comment;
    public $applicant_attachment_id;
    public $other_description;
    public $sponsor_address;
    public $attachment_path;
    public $verification_criteria_status;
    public $Name;
    public function rules()
    {
        return [
            [['verification_framework_id', 'attachment_definition_id', 'attachment_desc', 'verification_prompt', 'created_at', 'created_by','verification_status','category'], 'required'],
            [['verification_framework_id', 'attachment_definition_id', 'created_by', 'is_active'], 'integer'],
            [['attachment_definition_id'],'validateVerificationFramework'],
            //[['verification_criteria_status'],'compare','compareValue'=>'0','operator'=>'>','skipOnEmpty' => true,'message'=>'Error: All custom criteria must be OK'],
            [['created_at','verification_status','comment','applicant_attachment_id','sponsor_address','other_description','attachment_path','verification_criteria_status','Name'], 'safe'],
            [['attachment_desc', 'verification_prompt'], 'string', 'max' => 100],
            [['attachment_definition_id'], 'exist', 'skipOnError' => true, 'targetClass' => \frontend\modules\application\models\AttachmentDefinition::className(), 'targetAttribute' => ['attachment_definition_id' => 'attachment_definition_id']],
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
            'category'=>'Category',
            'other_description'=>'Other Description',
            'sponsor_address'=>'Sponsor Address',
            'attachment_path'=>'Attachment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentDefinition()
    {
        return $this->hasOne(\frontend\modules\application\models\AttachmentDefinition::className(), ['attachment_definition_id' => 'attachment_definition_id']);
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
    public static function checkItemsInApplication($verification_framework_id){
     $results= \backend\modules\application\models\Application::find()->where(['verification_framework_id'=>$verification_framework_id])->one(); 
     if(count($results) >0){
       return 1;  
     }else{
         return 0;
     }
    }
    
    public static function updateApplicationVerifiedReverse($verification_framework_id){
        \backend\modules\application\models\Application::updateAll(['verification_status' =>0], 'verification_framework_id ="'.$verification_framework_id.'" AND (released IS NULL OR released="")');
    }
    public static function getApplicantAttachmentPath($attachmentDefinitionID,$applicationID){
        $resultsAttachmentParth= \frontend\modules\application\models\ApplicantAttachment::find()->where(['application_id'=>$applicationID,'attachment_definition_id'=>$attachmentDefinitionID])->one();
        return $resultsAttachmentParth;
    }
    /*
    public static function updateApplicantAttachmentVerificationStatus($verification_status,$comment){
        \frontend\modules\application\models\ApplicantAttachment::updateAll(['verification_status' =>$verification_status,'comment'=>$comment], 'verification_framework_id ="'.$verification_framework_id.'"');
    }
     * 
     */


static function getVerificationAttachments($applicationID, $verificationFrameworkID){
            $query1 = self::find()
                ->select("verification_framework_item.verification_framework_id AS verification_framework_id,verification_framework_item.attachment_definition_id AS attachment_definition_id")
    ->from('verification_framework_item')
    ->where(['verification_framework_item.category'=>1,'verification_framework_item.verification_framework_id'=>$verificationFrameworkID]);
            $query2 = self::find()
                ->select("verification_framework_item.verification_framework_id AS verification_framework_id,verification_framework_item.attachment_definition_id AS attachment_definition_id")
    ->from('verification_framework_item')
   ->innerJoin('verification_framework','verification_framework.verification_framework_id=verification_framework_item.verification_framework_id')           ->innerJoin('attachment_definition','attachment_definition.attachment_definition_id=verification_framework_item.attachment_definition_id')
   ->innerJoin('applicant_attachment','applicant_attachment.attachment_definition_id=attachment_definition.attachment_definition_id')         
    ->where(['verification_framework.verification_framework_id'=>$verificationFrameworkID,'applicant_attachment.application_id'=>$applicationID,'verification_framework_item.category'=>2]);
        
        return new \yii\data\ActiveDataProvider([
            'query' => $query1->union($query2),
            'pagination' => [
        'pageSize' => 20,
    ],
        ]);
         
    }

public static function getAllMandatoryAttachments($verificationFrameworkID,$applicantCategory){
        if($verificationFrameworkID==''){
        $verificationF=\backend\modules\application\models\VerificationFramework::getActiveFramework($applicantCategory);
        $verificationFrameworkID1=$verificationF->verification_framework_id;  
      }else{
        $verificationFrameworkID1=$verificationFrameworkID;  
      }
        $query1 = self::find()
                ->select("verification_framework_item.verification_framework_id AS verification_framework_id,verification_framework_item.attachment_definition_id AS attachment_definition_id")
    ->from('verification_framework_item')
    ->where(['verification_framework_item.category'=>1,'verification_framework_item.verification_framework_id'=>$verificationFrameworkID1])->all();
        return $query1;
    }
public static function getVerificationCriteriaStatus($application_id) {        
        $applicationDetails = Application::findBySql("SELECT * FROM application WHERE application_id='$application_id'")->one();
        return $applicationDetails->verification_criteria_status;
    }
public static function getVerificationAttachmentsSet($verificationFrameworkID,$applicantCategory){
      if($verificationFrameworkID==''){
        $verificationF=\backend\modules\application\models\VerificationFramework::getActiveFramework($applicantCategory);
        $verificationFrameworkID1=$verificationF->verification_framework_id;  
      }else{
        $verificationFrameworkID1=$verificationFrameworkID;  
      }  
    $verificationVerificationItems= self::find()->joinWith('verificationFramework')->where(['verification_framework.verification_framework_id' =>$verificationFrameworkID1,'verification_framework_item.is_active'=>1])->all();
      return $verificationVerificationItems;
    }

}
