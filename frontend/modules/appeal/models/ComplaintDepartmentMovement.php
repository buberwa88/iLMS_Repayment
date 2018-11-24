<?php

namespace frontend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "complaint_department_movement".
 *
 * @property integer $complaint_department_movement_id
 * @property integer $complaint_id
 * @property integer $from_department_id
 * @property integer $to_department_id
 * @property string $description
 * @property integer $movement_status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Complaint $complaint
 * @property Department $fromDepartment
 * @property Department $toDepartment
 * @property User $createdBy
 * @property User $updatedBy
 */
class ComplaintDepartmentMovement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint_department_movement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complaint_id', 'from_department_id', 'to_department_id', 'description', 'movement_status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['complaint_id', 'from_department_id', 'to_department_id', 'movement_status', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['complaint_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complaint::className(), 'targetAttribute' => ['complaint_id' => 'complaint_id']],
            [['from_department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['from_department_id' => 'department_id']],
            [['to_department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['to_department_id' => 'department_id']],
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
            'complaint_department_movement_id' => 'Complaint Department Movement ID',
            'complaint_id' => 'Complaint ID',
            'from_department_id' => 'From Department ID',
            'to_department_id' => 'To Department ID',
            'description' => 'Description',
            'movement_status' => 'Movement Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaint()
    {
        return $this->hasOne(Complaint::className(), ['complaint_id' => 'complaint_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromDepartment()
    {
        return $this->hasOne(Department::className(), ['department_id' => 'from_department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToDepartment()
    {
        return $this->hasOne(Department::className(), ['department_id' => 'to_department_id']);
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


    public function getCreatorName(){
        
        $user = $this->createdBy;
        
        return $user->firstname." ".$user->middlename." ".$user->surname;
    }

    public function getFromDepartmentName(){
        
        $department = $this->fromDepartment;
        
        return $department->department_name;
    }

    public function getToDepartmentName(){
        
        $department = $this->toDepartment;
        
        return $department->department_name;
    }

    public function getAssignedOfficer(){
        
        $assignedOfficer = "-";

        return $assignedOfficer;
    }
}
