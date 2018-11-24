<?php

namespace backend\modules\repayment\models;

use Yii;

/**
 * This is the model class for table "employer_monthly_penalty_setting".
 *
 * @property integer $employer_mnthly_penalty_setting_id
 * @property integer $employer_type
 * @property integer $payment_deadline_day_per_month
 * @property string $penalty
 * @property integer $is_active
 * @property string $created_at
 * @property integer $created_by
 *
 * @property EmployerType $employerType
 */
class EmployerMonthlyPenaltySetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employer_monthly_penalty_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_type_id', 'payment_deadline_day_per_month', 'penalty', 'created_at', 'created_by'], 'required'],
            [['employer_type_id', 'payment_deadline_day_per_month', 'is_active', 'created_by'], 'integer'],
            [['penalty'], 'number'],
			['payment_deadline_day_per_month', 'string', 'length' => [1, 2]],
			['penalty', 'checkmaxandminvalues'],
            [['created_at'], 'safe'],
            [['employer_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerType::className(), 'targetAttribute' => ['employer_type_id' => 'employer_type_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employer_mnthly_penalty_setting_id' => 'Employer Mnthly Penalty Setting ID',
            'employer_type_id' => 'Employer Type',
            'payment_deadline_day_per_month' => 'Payment Deadline Day Per Month',
            'penalty' => 'Penalty(%)',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerType()
    {
        return $this->hasOne(EmployerType::className(), ['employer_type_id' => 'employer_type_id']);
    }
	public function checkmaxandminvalues($attribute, $params)
{
    $percent=$this->penalty;

    //Here you do your validation logic
    if($percent < 0)
    {
        $this->addError('penalty', 'Penalty should not be less than 0');
    }
   else if($percent > 100)
   {

        $this->addError('penalty', 'Penalty should not be greater than 100');
   }
}
    public static function updateOldEmployerMonthlyPenaltySettings($employer_type_id,$employer_mnthly_penalty_setting_id){
	   $end_date=date("Y-m-d");
       EmployerMonthlyPenaltySetting::updateAll(['is_active' =>0], 'employer_type_id="'.$employer_type_id.'" AND employer_mnthly_penalty_setting_id<>"'.$employer_mnthly_penalty_setting_id.'" AND is_active="1"');
    }
}
