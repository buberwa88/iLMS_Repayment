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
class EmployerPenaltyCycle extends \yii\db\ActiveRecord {

    const REPAYMENT_CYCLE_GENERAL = '0';
    const REPAYMENT_CYCLE_EMPLOYER = '1';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'employer_penalty_cycle';
    }

    /**
     * @inheritdoc
     */
	 public $penalty;
	 public $payment_deadline_day_per_month;
    public function rules() {
        return [
            [['employer_id', 'repayment_deadline_day', 'duration', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['repayment_deadline_day', 'penalty_rate', 'duration', 'duration_type', 'cycle_type', 'start_date', 'created_at', 'created_by'], 'required'],
            [['penalty_rate'], 'number'],
            [['created_by'], 'validateConfiguration'],
            [['duration_type', 'cycle_type'], 'string'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'employer_penalty_cycle_id' => 'Employer Penalty Cycle ID',
            'employer_id' => 'Employer',
            'repayment_deadline_day' => 'Repayment Day',
            'penalty_rate' => 'Penalty Rate(%)',
            'duration' => 'Duration',
            'duration_type' => 'Penalty Type',
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

    public function getEmployer() {
        return $this->hasOne(\backend\modules\repayment\models\Employer::className(), ['employer_id' => 'employer_id']);
    }

    function validateConfiguration($attribute) {
        if ($attribute) {
            $condition = ['is_active' => 1];
            switch ($this->cycle_type) {
                case self::REPAYMENT_CYCLE_GENERAL:
                    $condition['cycle_type'] = self::REPAYMENT_CYCLE_GENERAL;
                    $condition['employer_id'] = NULL;

                    break;

                case self::REPAYMENT_CYCLE_EMPLOYER:
                    $condition['cycle_type'] = self::REPAYMENT_CYCLE_EMPLOYER;
                    $condition['employer_id'] = $this->employer_id;

                    break;
            }
            if (self::find()->where($condition)->exists()) {
                $this->addError($attribute, 'Configuration Already Exist in similar Dates');
                return FALSE;
            }
        }
        return TRUE;
    }

    static function durationType() {
        return [
            'd' => 'Daily', 'w' => 'Weekly', 'm' => 'Monthly', 'y' => 'Yearly'
        ];
    }

    function getDurationTypeName() {
        $duration_type = self::durationType();
        if ($this->duration_type && isset($duration_type[$this->duration_type])) {
            return $duration_type[$this->duration_type];
        }
        return NULL;
    }

    static function cycleType() {
        return [
            self::REPAYMENT_CYCLE_GENERAL => 'General', self::REPAYMENT_CYCLE_EMPLOYER => 'Employer'
        ];
    }

    function getCycleTypeName() {
        $cycle_type = self::cycleType();
        if (isset($cycle_type[$this->cycle_type])) {
            return $cycle_type[$this->cycle_type];
        }
        return NULL;
    }

}
