<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "employer_penalty_cycle".
 *
 * @property integer $employer_penalty_cycle_id
 * @property integer $employer_id
 * @property integer $repayment_deadline_day
 * @property double $penalty_rate
 * @property integer $duration
 * @property string $duration_type
 * @property integer $is_active
 * @property string $cycle_type
 * @property string $start_date
 * @property string $end_date
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class EmployerPenaltyCycle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer_penalty_cycle';
    }
	public $penalty;
	public $payment_deadline_day_per_month;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_id', 'repayment_deadline_day', 'duration', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['repayment_deadline_day', 'penalty_rate', 'duration', 'duration_type', 'cycle_type', 'start_date', 'created_at', 'created_by'], 'required'],
            [['penalty_rate'], 'number'],
            [['duration_type', 'cycle_type'], 'string'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employer_penalty_cycle_id' => 'Employer Penalty Cycle ID',
            'employer_id' => 'Employer ID',
            'repayment_deadline_day' => 'Repayment Deadline Day',
            'penalty_rate' => 'Penalty Rate',
            'duration' => 'Duration',
            'duration_type' => 'Duration Type',
            'is_active' => 'Is Active',
            'cycle_type' => 'Cycle Type',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
