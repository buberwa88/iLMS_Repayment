<?php

namespace backend\modules\report\models;

use Yii;

/**
 * This is the model class for table "erp_popular_report".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $report_id
 * @property integer $rate
 * @property string $set_date
 */
class PopularReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'popular_report';
    }

    /**
     * @inheritdoc
     */
    public $package;
    public function rules()
    {
        return [
            [['user_id', 'report_id', 'rate'], 'required'],
            [['user_id', 'report_id', 'rate'], 'integer'],
            [['set_date','package'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'report_id' => 'Report ID',
            'rate' => 'Rate',
            'set_date' => 'Set Date',
            'package'=>'Narration',
        ];
    }
    
    public function getReport()
    {
        return $this->hasOne(\backend\modules\report\models\Report::className(), ['id' => 'report_id']);
    }
}
