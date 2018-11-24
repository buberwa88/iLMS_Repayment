<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "system_setting".
 *
 * @property integer $system_setting_id
 * @property integer $academic_year_id
 * @property integer $currency_id
 * @property integer $waiting_days_for_uncollected_disbursement_return
 * @property string $application_open_date
 * @property string $application_close_date
 * @property double $minimum_loanable_amount
 * @property integer $loan_repayment_grace_period_days
 * @property double $employee_monthly_loan_repayment_percent
 * @property double $self_employed_monthly_loan_repayment_amount
 * @property string $previous_loan_repayment_for_new_loan
 * @property double $total_budget
 *
 * @property AcademicYear $academicYear
 * @property Currency $currency
 */
class SystemSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id'], 'required'],
            [['academic_year_id', 'currency_id', 'waiting_days_for_uncollected_disbursement_return', 'loan_repayment_grace_period_days'], 'integer'],
            [['application_open_date', 'application_close_date'], 'safe'],
            [['minimum_loanable_amount', 'employee_monthly_loan_repayment_percent', 'self_employed_monthly_loan_repayment_amount', 'total_budget'], 'number'],
            [['previous_loan_repayment_for_new_loan'], 'string', 'max' => 27],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'academic_year_id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\allocation\models\Currency::className(), 'targetAttribute' => ['currency_id' => 'currency_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'system_setting_id' => 'System Setting',
            'academic_year_id' => 'Academic Year',
            'currency_id' => 'Currency',
            'waiting_days_for_uncollected_disbursement_return' => 'Waiting Days For Uncollected Disbursement Return',
            'application_open_date' => 'Application Open Date',
            'application_close_date' => 'Application Close Date',
            'minimum_loanable_amount' => 'Minimum Loanable Amount',
            'loan_repayment_grace_period_days' => 'Loan Repayment Grace Period Days',
            'employee_monthly_loan_repayment_percent' => 'Employee Monthly Loan Repayment Percent',
            'self_employed_monthly_loan_repayment_amount' => 'Self Employed Monthly Loan Repayment Amount',
            'previous_loan_repayment_for_new_loan' => 'Previous Loan Repayment For New Loan',
            'total_budget' => 'Total Budget',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(\backend\models\AcademicYear::className(), ['academic_year_id' => 'academic_year_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(\backend\modules\allocation\models\Currency::className(), ['currency_id' => 'currency_id']);
    }
}
