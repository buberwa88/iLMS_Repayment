<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "bank_account".
 *
 * @property integer $bank_account_id
 * @property integer $bank_id
 * @property string $branch_name
 * @property string $account_name
 * @property string $account_number
 * @property integer $currency_id
 *
 * @property Bank $bank
 * @property Currency $currency
 */
class BankAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_id', 'branch_name', 'account_name', 'account_number', 'currency_id'], 'required'],
            [['account_number'], 'unique'],
            [['bank_id', 'currency_id'], 'integer'],
            [['branch_name'], 'string', 'max' => 45],
            [['account_name'], 'string', 'max' => 60],
            [['account_number'], 'string', 'max' => 20],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\application\models\Bank::className(), 'targetAttribute' => ['bank_id' => 'bank_id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\Currency::className(), 'targetAttribute' => ['currency_id' => 'currency_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bank_account_id' => 'Bank Account ID',
            'bank_id' => 'Bank Name',
            'branch_name' => 'Branch Name',
            'account_name' => 'Account Name',
            'account_number' => 'Account Number',
            'currency_id' => 'Currency',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(\backend\modules\application\models\Bank::className(), ['bank_id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(\backend\modules\allocation\models\Currency::className(), ['currency_id' => 'currency_id']);
    }
}
