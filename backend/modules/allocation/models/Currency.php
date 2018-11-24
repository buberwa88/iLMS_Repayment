<?php

namespace backend\modules\allocation\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $currency_id
 * @property string $currency_ref
 * @property string $currency_postfix
 * @property string $currency_desc
 *
 * @property BankAccount[] $bankAccounts
 * @property SystemSetting[] $systemSettings
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_ref', 'currency_postfix'], 'required'],
            [['currency_ref'], 'string', 'max' => 3],
            [['currency_postfix', 'currency_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'currency_id' => 'Currency ID',
            'currency_ref' => 'Currency Ref',
            'currency_postfix' => 'Currency Postfix',
            'currency_desc' => 'Currency Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankAccounts()
    {
        return $this->hasMany(BankAccount::className(), ['currency_id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemSettings()
    {
        return $this->hasMany(SystemSetting::className(), ['currency_id' => 'currency_id']);
    }
}
