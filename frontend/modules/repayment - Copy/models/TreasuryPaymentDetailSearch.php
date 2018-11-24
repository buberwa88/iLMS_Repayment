<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\TreasuryPaymentDetail;

/**
 * TreasuryPaymentDetailSearch represents the model behind the search form about `frontend\modules\repayment\models\TreasuryPaymentDetail`.
 */
class TreasuryPaymentDetailSearch extends TreasuryPaymentDetail
{
    /**
     * @inheritdoc
     */
	 public $bill_number;
    public function rules()
    {
        return [
            [['treasury_payment_detail_id', 'treasury_payment_id'], 'integer'],
            [['amount'], 'number'],
			[['employer_name','bill_number'], 'safe'],
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
        $query = TreasuryPaymentDetail::find();
		                               

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
            'treasury_payment_detail_id' => $this->treasury_payment_detail_id,
            'treasury_payment_id' => $this->treasury_payment_id,
            'employer_id' => $this->employer_id,
            'amount' => $this->amount,
        ]);

        return $dataProvider;
    }
	public function searchEmployersBills($params,$id)
    {
        $query = TreasuryPaymentDetail::find()
		                               ->where(['treasury_payment_id'=>$id]);

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
		$query->joinWith("loanRepayment");
        $query->joinwith(["loanRepayment","loanRepayment.employer"]);
		
		
        $query->andFilterWhere([
            'treasury_payment_detail_id' => $this->treasury_payment_detail_id,
            'treasury_payment_id' => $this->treasury_payment_id,
            //'employer_id' => $this->employer_id,
            //'amount' => $this->amount,
        ]);
		
		$query->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])
		      ->andFilterWhere(['like', 'loan_repayment.bill_number', $this->bill_number])
			  ->andFilterWhere(['like', 'treasury_payment_detail.amount', $this->amount]);

        return $dataProvider;
    }
}
