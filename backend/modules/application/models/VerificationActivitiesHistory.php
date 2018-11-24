<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "verification_activities_history".
 *
 * @property integer $verification_activities_history_id
 * @property integer $application_id
 * @property string $activity
 * @property integer $done_by
 * @property integer $done_at
 */
class VerificationActivitiesHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_activities_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'activity', 'done_by', 'done_at','comment'], 'required'],
            [['application_id', 'done_by', 'done_at','other'], 'integer'],
            [['activity'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verification_activities_history_id' => 'Verification Activities History ID',
            'application_id' => 'Application ID',
            'activity' => 'Activity',
            'done_by' => 'Done By',
            'done_at' => 'Done At',
            'other'=>'Other',
            'comment'=>'Comment',
        ];
    }
    public static function insertVerificationActivityHistory($application_id,$activity,$done_by,$done_at,$other,$comment){
        Yii::$app->db->createCommand()
        ->insert('verification_activities_history', [
        'application_id' =>$application_id,
        'activity' =>$activity,
        'done_by' =>$done_by,
        'done_at'=>$done_at,
        'other'=>$other,
        'comment'=>$comment,
        ])->execute(); 
    }
}
