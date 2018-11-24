<?php

namespace backend\modules\application\models;

use Yii;

/**
 * This is the model class for table "application_cycle_status".
 *
 * @property integer $application_cycle_status_id
 * @property string $application_cycle_status_name
 * @property string $application_cycle_status_description
 *
 * @property ApplicationCycle[] $applicationCycles
 */
class ApplicationCycleStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_cycle_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_cycle_status_name', 'application_cycle_status_description'], 'required'],
            [['application_cycle_status_name', 'application_cycle_status_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'application_cycle_status_id' => 'Application Status ID',
            'application_cycle_status_name' => 'Application Status Name',
            'application_cycle_status_description' => 'Application Status Description',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationCycles()
    {
        return $this->hasMany(ApplicationCycle::className(), ['application_cycle_status_id' => 'application_cycle_status_id']);
    }
}
