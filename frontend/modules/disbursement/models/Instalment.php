<?php

namespace frontend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "instalment".
 *
 * @property integer $instalment_id
 * @property integer $instalment
 * @property string $instalment_desc
 * @property integer $is_active
 *
 * @property DisbursementSetting[] $disbursementSettings
 */
class Instalment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instalment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instalment_id', 'instalment'], 'required'],
            [['instalment_id', 'instalment', 'is_active'], 'integer'],
            [['instalment_desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'instalment_id' => Yii::t('app', 'Instalment ID'),
            'instalment' => Yii::t('app', 'Instalment'),
            'instalment_desc' => Yii::t('app', 'Instalment Desc'),
            'is_active' => Yii::t('app', 'Is Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisbursementSettings()
    {
        return $this->hasMany(DisbursementSetting::className(), ['instalment_id' => 'instalment_id']);
    }
}
