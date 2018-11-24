<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SystemSetting;

/**
 * SystemSettingSearch represents the model behind the search form about `backend\models\SystemSetting`.
 */
class SystemSettingSearch extends SystemSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['system_setting_id', 'academic_year_id', 'currency_id', 'waiting_days_for_uncollected_disbursement_return', 'loan_repayment_grace_period_days'], 'integer'],
            [['application_open_date', 'application_close_date', 'previous_loan_repayment_for_new_loan'], 'safe'],
            [['minimum_loanable_amount', 'employee_monthly_loan_repayment_percent', 'self_employed_monthly_loan_repayment_amount', 'total_budget'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SystemSetting::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'system_setting_id' => $this->system_setting_id,
            'academic_year_id' => $this->academic_year_id,
            'currency_id' => $this->currency_id,
            'waiting_days_for_uncollected_disbursement_return' => $this->waiting_days_for_uncollected_disbursement_return,
            'application_open_date' => $this->application_open_date,
            'application_close_date' => $this->application_close_date,
            'minimum_loanable_amount' => $this->minimum_loanable_amount,
            'loan_repayment_grace_period_days' => $this->loan_repayment_grace_period_days,
            'employee_monthly_loan_repayment_percent' => $this->employee_monthly_loan_repayment_percent,
            'self_employed_monthly_loan_repayment_amount' => $this->self_employed_monthly_loan_repayment_amount,
            'total_budget' => $this->total_budget,
        ]);

        $query->andFilterWhere(['like', 'previous_loan_repayment_for_new_loan', $this->previous_loan_repayment_for_new_loan]);

        return $dataProvider;
    }
}
