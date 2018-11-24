<?php

namespace backend\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property integer $department_id
 * @property string $department_name
 * @property integer $status
 *
 * @property ComplaintDepartmentMovement[] $complaintDepartmentMovements
 * @property ComplaintDepartmentMovement[] $complaintDepartmentMovements0
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_name', 'status'], 'required'],
            [['status'], 'integer'],
            [['department_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_id' => 'Department ID',
            'department_name' => 'Department Name',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaintDepartmentMovements()
    {
        return $this->hasMany(ComplaintDepartmentMovement::className(), ['from_department_id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaintDepartmentMovements0()
    {
        return $this->hasMany(ComplaintDepartmentMovement::className(), ['to_department_id' => 'department_id']);
    }
}
