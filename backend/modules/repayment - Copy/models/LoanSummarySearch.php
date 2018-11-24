<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\LoanSummary;

/**
 * LoanSummarySearch represents the model behind the search form about `frontend\modules\repayment\models\LoanSummary`.
 */
class LoanSummarySearch extends LoanSummary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_summary_id', 'employer_id', 'applicant_id', 'created_by'], 'integer'],
            [['reference_number', 'created_at','outstanding_debt','paid','outstanding_debt','firstname','middlename','surname','f4indexno','employer_name'], 'safe'],
            [['amount'], 'number'],
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
        $query = LoanSummary::find()
                                  ->where('loan_summary.status <>"7"')
								   ->orderBy('loan_summary.loan_summary_id DESC');

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
		
        $query->andFilterWhere([
            'loan_summary_id' => $this->loan_summary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'outstanding_debt' => $this->outstanding_debt,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'loan_summary.applicant_id', $this->applicant_id])
			->andFilterWhere(['like', 'loan_summary.reference_number', $this->reference_number])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
    public function searchNewBill2($params)
    {
        $query = LoanSummary::find()
                                  ->where('loan_summary.status ="5"');

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
		
        $query->andFilterWhere([
            'loan_summary_id' => $this->loan_summary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'outstanding_debt' => $this->outstanding_debt,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'loan_summary.applicant_id', $this->applicant_id])
			->andFilterWhere(['like', 'loan_summary.reference_number', $this->reference_number])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
			->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
    
    public function searchNewBillLoanee($params)
    {
        $query = LoanSummary::find()
                                  ->where('loan_summary.status ="7"');

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
		$query->joinWith("employer");
		$query->joinWith("applicant");
        $query->joinwith(["applicant","applicant.user"]);
		
        $query->andFilterWhere([
            'loan_summary_id' => $this->loan_summary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'outstanding_debt' => $this->outstanding_debt,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        
		    $query->andFilterWhere(['like', 'loan_summary.applicant_id', $this->applicant_id])
			->andFilterWhere(['like', 'loan_summary.reference_number', $this->reference_number])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
			->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
}
