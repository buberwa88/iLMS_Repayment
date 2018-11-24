<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "sent_notification".
 *
 * @property integer $sent_notification_id
 * @property integer $cnotification_id
 * @property string $description
 * @property integer $target_group
 * @property integer $user_sent
 * @property string $date_sent
 */
class SentNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sent_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cnotification_id', 'target_group', 'user_sent', 'date_sent','target_group','repeat_every'], 'required'],
            [['cnotification_id', 'target_group', 'user_sent','repeat_every'], 'integer'],
            [['date_sent'], 'safe'],
            [['description'], 'string', 'max' => 150],
            [['sms_text'], 'string', 'max' => 255],
        ];
    }

    
    public static function getTargetGroups(){
        $target_group = [
            0=>'All Applicants',
            1=>'Just Created an Account',
            2=>'Direct',
            3=>'Direct(Mixed)',
            4=>'Equivalent',
            5=>'Selected',
            6=>'None Selected',
            7=>'Have not Paid',
            8=>'Incomplete Sittings',
            9=>'Incomplete Choices',
            10=>'Dont Meet Requirements',
            11=>'Not Confirmed Selection',
        ];
        
        return $target_group;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sent_notification_id' => 'Sent Notification ID',
            'cnotification_id' => 'Cnotification ID',
            'description' => 'Description',
            'target_group' => 'Target Group',
            'user_sent' => 'User Sent',
            'date_sent' => 'Date Sent',
        ];
    }
}
