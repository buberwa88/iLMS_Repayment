<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\EmployerPenalty;

/**
 * EmployerPenaltySearch represents the model behind the search form about `frontend\modules\repayment\models\EmployerPenalty`.
 */
class EmployerPenaltySearch extends EmployerPenalty
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_penalty_id'], 'integer'],
            [['amount'], 'number'],
            [['penalty_date', 'created_at','employer_id'], 'safe'],
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
        $query = EmployerPenalty::find();

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
		$query->joinWith('employer');
        $query->andFilterWhere([
            'employer_penalty_id' => $this->employer_penalty_id,
            //'employer_id' => $this->employer_id,
            'amount' => $this->amount,
            'penalty_date' => $this->penalty_date,
            'created_at' => $this->created_at,
        ]);
		$query->andFilterWhere(['like', 'employer.employer_name', $this->employer_id]);
        return $dataProvider;
    }
	public function searchPenaltyheslb($params)
    {
        $query = EmployerPenalty::find();

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
		$query->joinWith('employer');
        $query->andFilterWhere([
            'employer_penalty_id' => $this->employer_penalty_id,
            //'employer_id' => $this->employer_id,
            'amount' => $this->amount,
            'penalty_date' => $this->penalty_date,
            'created_at' => $this->created_at,
        ]);
		$query->andFilterWhere(['like', 'employer.employer_name', $this->employer_id]);
        return $dataProvider;
    }
}
