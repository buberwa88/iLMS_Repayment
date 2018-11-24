<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $notification_id
 * @property integer $user_id
 * @property string $subject
 * @property string $notification
 * @property string $date_created
 * @property integer $is_read
 * @property string $date_read
 */
class Notification extends \yii\db\ActiveRecord
{
    //public $sent_notification_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'subject', 'notification', 'date_created','sent_notification_id'], 'required'],
            [['user_id', 'is_read','sent_notification_id'], 'integer'],
            [['notification'], 'string'],
            [['date_created', 'date_read'], 'safe'],
            [['subject'], 'string', 'max' => 150],
        ];
    }

    
    public static function sendEmail($to, $subject, $email_body){
        
    }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'user_id' => 'User ID',
            'subject' => 'Subject',
            'notification' => 'Notification',
            'date_created' => 'Date Created',
            'is_read' => 'Is Read',
            'date_read' => 'Date Read',
        ];
    }
}
