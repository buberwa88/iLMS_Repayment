<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "system_setting".
 *
 * @property integer $system_setting_id
 * @property string $setting_name
 * @property string $setting_code
 * @property string $setting_value
 * @property string $value_data_type
 * @property integer $is_active
 */
class SystemSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_name', 'setting_code', 'value_data_type'], 'required'],
            [['value_data_type'], 'string'],
            [['is_active'], 'integer'],
            [['setting_name'], 'string', 'max' => 100],
            [['setting_code'], 'string', 'max' => 20],
            [['setting_value'], 'string', 'max' => 50],
            [['setting_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'system_setting_id' => 'System Setting ID',
            'setting_name' => 'Setting Name',
            'setting_code' => 'Setting Code',
            'setting_value' => 'Setting Value',
            'value_data_type' => 'Value Data Type',
            'is_active' => 'Is Active',
        ];
    }
}
