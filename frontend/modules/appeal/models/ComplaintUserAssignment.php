<?php

namespace frontend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "complaint_user_assignment".
 *
 * @property integer $complaint_user_assignment_id
 * @property integer $complaint_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $status
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Complaint $complaint
 * @property User $user
 */
class ComplaintUserAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complaint_user_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complaint_id', 'user_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'required'],
            [['complaint_id', 'user_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
            [['complaint_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complaint::className(), 'targetAttribute' => ['complaint_id' => 'complaint_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'complaint_user_assignment_id' => 'Complaint User Assignment ID',
            'complaint_id' => 'Complaint ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
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
    public function getComplaint()
    {
        return $this->hasOne(Complaint::className(), ['complaint_id' => 'complaint_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
