<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\EmployerPenaltyPayment;

/**
 * EmployerPenaltyPaymentSearch represents the model behind the search form about `frontend\modules\repayment\models\EmployerPenaltyPayment`.
 */
class EmployerPenaltyPaymentSearch extends EmployerPenaltyPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_penalty_payment_id'], 'integer'],
            [['amount'], 'number'],
            [['payment_date', 'created_at','payment_status','control_number', 'employer_id'], 'safe'],
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
        $query = EmployerPenaltyPayment::find();

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
            'employer_penalty_payment_id' => $this->employer_penalty_payment_id,
            'employer_id' => $this->employer_id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
			'payment_status' => $this->payment_status,
        ]);
		
		$query->andFilterWhere(['like', 'control_number', $this->control_number]);
		
        return $dataProvider;
    }
	public function searchPenaltyPaymentheslb($params)
    {
        $query = EmployerPenaltyPayment::find();

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
            'employer_penalty_payment_id' => $this->employer_penalty_payment_id,
            //'employer_id' => $this->employer_id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
			'payment_status' => $this->payment_status,
        ]);
		
		$query->andFilterWhere(['like', 'control_number', $this->control_number])
		      ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id]);
		
        return $dataProvider;
    }
	public function searchPenaltyBillsheslb($params)
    {
        $query = EmployerPenaltyPayment::find()->where(['payment_status'=>0]);

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
            'employer_penalty_payment_id' => $this->employer_penalty_payment_id,
            //'employer_id' => $this->employer_id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
			'payment_status' => $this->payment_status,
        ]);
		
		$query->andFilterWhere(['like', 'control_number', $this->control_number])
		      ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id]);
		
        return $dataProvider;
    }
	public function searchPenaltyPaymentheslbPaid($params)
    {
        $query = EmployerPenaltyPayment::find()->where(['payment_status'=>1]);

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
            'employer_penalty_payment_id' => $this->employer_penalty_payment_id,
            //'employer_id' => $this->employer_id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
			'payment_status' => $this->payment_status,
        ]);
		
		$query->andFilterWhere(['like', 'control_number', $this->control_number])
		      ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id]);
		
        return $dataProvider;
    }
}
