<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\EmployerMonthlyPenaltySetting;

/**
 * EmployerMonthlyPenaltySettingSearch represents the model behind the search form about `backend\modules\repayment\models\EmployerMonthlyPenaltySetting`.
 */
class EmployerMonthlyPenaltySettingSearch extends EmployerMonthlyPenaltySetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_mnthly_penalty_setting_id', 'employer_type_id', 'payment_deadline_day_per_month', 'is_active', 'created_by'], 'integer'],
            [['penalty'], 'number'],
            [['created_at'], 'safe'],
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
        $query = EmployerMonthlyPenaltySetting::find()
		                                        ->orderBy('employer_mnthly_penalty_setting_id DESC');

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
            'employer_mnthly_penalty_setting_id' => $this->employer_mnthly_penalty_setting_id,
            'employer_type_id' => $this->employer_type_id,
            'payment_deadline_day_per_month' => $this->payment_deadline_day_per_month,
            'penalty' => $this->penalty,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        return $dataProvider;
    }
}
