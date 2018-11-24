<?php

namespace frontend\modules\application\models;

use Yii;

/**
 * This is the model class for table "cnotification".
 *
 * @property integer $cnotification_id
 * @property string $subject
 * @property string $notification
 * @property string $date_created
 */
class Cnotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cnotification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'notification', 'date_created','type'], 'required'],
            [['notification'], 'string'],
            [['date_created'], 'safe'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cnotification_id' => 'Cnotification ID',
            'subject' => 'Subject',
            'notification' => 'Notification',
            'date_created' => 'Date Created',
        ];
    }
}
