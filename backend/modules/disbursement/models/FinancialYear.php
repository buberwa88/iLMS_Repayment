<?php

namespace backend\modules\disbursement\models;

use Yii;

/**
 * This is the model class for table "financial_year".
 *
 * @property integer $financial_year_id
 * @property string $financial_year
 * @property integer $is_active
 */
class FinancialYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financial_year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['financial_year'], 'required'],
            [['is_active'], 'integer'],
            [['financial_year'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'financial_year_id' => 'Financial Year ID',
            'financial_year' => 'Financial Year',
            'is_active' => 'Is Active',
        ];
    }
}
