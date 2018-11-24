<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "tempemplyebasic012457".
 *
 * @property integer $id
 * @property integer $loan_repayment_id
 * @property integer $applicant_id
 * @property string $old_amount
 * @property string $new_amount
 */
class Tempemplyebasic012457 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    /*
    public static function tableName()
    {
        return 'tempemplyebasic012457';
    }
     * 
     */
    
    public static function tableName($tableName)
    {
        return $tableName;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_repayment_id', 'applicant_id'], 'integer'],
            [['old_amount', 'new_amount'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loan_repayment_id' => 'Loan Repayment Batch ID',
            'applicant_id' => 'Applicant ID',
            'old_amount' => 'Old Amount',
            'new_amount' => 'New Amount',
        ];
    }
}
