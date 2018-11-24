<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "control_number_generator".
 *
 * @property integer $id
 * @property string $ilms_reference
 * @property double $amount
 * @property string $indate
 */
class ControlNumberGenerator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'control_number_generator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['indate'], 'safe'],
            [['ilms_reference'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ilms_reference' => 'Ilms Reference',
            'amount' => 'Amount',
            'indate' => 'Indate',
        ];
    }
}
