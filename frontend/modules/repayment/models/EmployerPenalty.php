<?php

namespace frontend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "employer_penalty".
 *
 * @property integer $employer_penalty_id
 * @property integer $employer_id
 * @property string $amount
 * @property string $penalty_date
 * @property string $created_at
 *
 * @property EmployerPenalty $employer
 * @property EmployerPenalty[] $employerPenalties
 */
class EmployerPenalty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer_penalty';
    }
    public $employerName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['employer_id', 'amount', 'penalty_date', 'created_at'], 'required'],
			[['cancel_reason'], 'required','on'=>'Cancell_employer_penalty2'],
            [['employer_id'], 'integer'],
            [['amount'], 'number'],
            [['penalty_date', 'created_at','is_active','canceled_by','canceled_at','cancel_reason','amount'], 'safe'],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employer::className(), 'targetAttribute' => ['employer_id' => 'employer_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employer_penalty_id' => 'Employer Penalty ID',
            'employer_id' => 'Employer ID',
            'amount' => 'Amount',
            'penalty_date' => 'Penalty Date',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(Employer::className(), ['employer_id' => 'employer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerPenalties()
    {
        return $this->hasMany(EmployerPenalty::className(), ['employer_id' => 'employer_penalty_id']);
    }
}
