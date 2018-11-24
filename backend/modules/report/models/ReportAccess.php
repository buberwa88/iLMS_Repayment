<?php

namespace backend\modules\report\models;

use Yii;

/**
 * This is the model class for table "report_access".
 *
 * @property integer $report_access_id
 * @property integer $report_id
 * @property string $user_role
 * @property integer $user_id
 * @property integer $created_by
 * @property string $created_at
 */
class ReportAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id'], 'required'],
            [['report_id', 'user_id', 'created_by'], 'integer'],
            [['created_at', 'created_by','is_active'], 'safe'],
            [['user_role'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_access_id' => 'Report Access ID',
            'report_id' => 'Report ID',
            'user_role' => 'User Role',
            'user_id' => 'User ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'is_active'=>'Is Active',
        ];
    }
    public function getReport()
    {
        return $this->hasOne(\backend\modules\report\models\Report::className(), ['id' => 'report_id']);
    }
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['user_id' => 'user_id']);
    }
}
