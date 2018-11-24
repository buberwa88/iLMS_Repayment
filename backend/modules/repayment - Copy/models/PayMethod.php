<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "pay_method".
 *
 * @property integer $pay_method_id
 * @property string $method_desc
 *
 * @property LoanRepayment[] $LoanRepaymentes
 */
class PayMethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method_desc'], 'required'],
            [['method_desc'], 'unique'],
            [['method_desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pay_method_id' => 'Pay Method ID',
            'method_desc' => 'Method Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanRepaymentes()
    {
        return $this->hasMany(LoanRepayment::className(), ['pay_method_id' => 'pay_method_id']);
    }
}
