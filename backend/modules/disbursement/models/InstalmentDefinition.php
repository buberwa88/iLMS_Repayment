<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "instalment_definition".
 *
 * @property integer $instalment_definition_id
 * @property integer $instalment
 * @property string $instalment_desc
 * @property integer $is_active
 *
 * @property DisbursementBatch[] $disbursementBatches
 * @property DisbursementSetting[] $disbursementSettings
 * @property DisbursementSetting2[] $disbursementSetting2s
 */
class InstalmentDefinition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instalment_definition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instalment'], 'required'],
            [['instalment', 'is_active'], 'integer'],
            [['instalment_desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'instalment_definition_id' => 'Instalment',
            'instalment' => 'Instalment',
            'instalment_desc' => 'Description',
            'is_active' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementBatches()
    {
        return $this->hasMany(DisbursementBatch::className(), ['instalment_definition_id' => 'instalment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSettings()
    {
        return $this->hasMany(DisbursementSetting::className(), ['instalment_definition_id' => 'instalment_definition_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSetting2s()
    {
        return $this->hasMany(DisbursementSetting2::className(), ['instalment_definition_id' => 'instalment_definition_id']);
    }
}
