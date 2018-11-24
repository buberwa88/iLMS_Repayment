<?php

namespace backend\modules\appeal\models;

use Yii;
use yii\helpers\VarDumper;
use backend\modules\appeal\helpers\ComplaintHelper;

/**
 * This is the model class for table "complaint".
 *
 * @property integer $complaint_id
 * @property integer $complaint_category_id
 * @property string $complaint
 * @property integer $applicant_id
 * @property integer $complaint_parent_id
 * @property string $complaint_response
 * @property integer $status
 * @property integer $level
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ComplaintCategory $complaintCategory
 * @property Complaint $complaintParent
 * @property Complaint[] $complaints
 * @property User $createdBy
 * @property User $updatedBy
 * @property ComplaintDepartmentMovement[] $complaintDepartmentMovements
 * @property ComplaintUserAssignment[] $complaintUserAssignments
 */
class Complaint extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complaint_category_id', 'complaint'], 'required'],
            [['complaint_category_id', 'applicant_id', 'complaint_parent_id', 'status', 'level', 'created_by', 'updated_by'], 'integer'],
            [['complaint', 'complaint_response'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['complaint_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComplaintCategory::className(), 'targetAttribute' => ['complaint_category_id' => 'complaint_category_id']],
            [['complaint_parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complaint::className(), 'targetAttribute' => ['complaint_parent_id' => 'complaint_id']],
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
            'complaint_id' => 'Complaint ID',
            'complaint_category_id' => 'Complaint Type',
            'complaint' => 'Complaint',
            'applicant_id' => 'Applicant ID',
            'complaint_parent_id' => 'Complaint Parent ID',
            'complaint_response' => 'Complaint Response',
            'status' => 'Status',
            'level' => 'Level',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaintCategory()
    {
        return $this->hasOne(ComplaintCategory::className(), ['complaint_category_id' => 'complaint_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaintParent()
    {
        return $this->hasOne(Complaint::className(), ['complaint_id' => 'complaint_parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaint::className(), ['complaint_parent_id' => 'complaint_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    public function getCreatorName(){

        $user = $this->createdBy;

        return $user->firstname." ".$user->middlename." ".$user->surname;
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
    public function getComplaintDepartmentMovements()
    {
        return $this->hasMany(ComplaintDepartmentMovement::className(), ['complaint_id' => 'complaint_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaintUserAssignments()
    {
        return $this->hasMany(ComplaintUserAssignment::className(), ['complaint_id' => 'complaint_id']);
    }

    public function getStatusValue(){


        if($this->level == 0){
            $status = "Draft";
        }else{

            $status = ComplaintHelper::decodeStatusFromNumber($this->status);
    
            if($status != null){
                $status = ucfirst($status);
            }
            
        }

        return $status;
    }


    public function getLastAssignedOfficer(){
        
        $officers = $this->complaintUserAssignments;
        
        $size =  count($officers);
        
        $name = "";

        if($size > 0){
            $officer = $officers[$size - 1];
            $name = $officer->user->firstname." ".$officer->user->middlename." ".$officer->user->surname;
        }

        return $name;
    }


    public static function complaintToken($id){

        $applicant = ApplicantComplaintToken::findOne(['status'=>0]);

        if($applicant != null){
            return $applicant->token;
        }

        return null;
    }
}
