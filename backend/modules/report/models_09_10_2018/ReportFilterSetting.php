<?php

namespace backend\modules\report\models;

use Yii;

/**
 * This is the model class for table "report_filter_setting".
 *
 * @property integer $report_filter_setting_id
 * @property integer $number_of_rows
 * @property integer $is_active
 * @property integer $created_by
 * @property string $created_at
 */
class ReportFilterSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_filter_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['number_of_rows', 'unique', 'targetAttribute' => ['number_of_rows', 'is_active'],'message'=>'Item Exists'],
            [['number_of_rows'], 'required'], 
            ['number_of_rows', 'unique', 'targetAttribute' => ['number_of_rows', 'is_active']],
            [['number_of_rows', 'is_active', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_filter_setting_id' => 'Report Filter Setting ID',
            'number_of_rows' => 'Total Rows',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
}
