<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\LoanSummary;

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
            [['reference_number', 'created_at'], 'safe'],
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
        $query = LoanSummary::find();

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
            'loan_summary_id' => $this->loan_summary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number]);

        return $dataProvider;
    }
    
    public function getBillUnderEmployer($params,$employerID)
    {
        $query = LoanSummary::find()
                                    ->where(['employer_id'=>$employerID])
                                    ->orderBy('loan_summary_id DESC');

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
            'loan_summary_id' => $this->loan_summary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number]);

        return $dataProvider;
    }
    public function getBillLoanee($params,$applicantID)
    {
	    /*
        $query = LoanSummary::find()
                                    ->andwhere(['applicant_id'=>$applicantID])
                                    ->andWhere(['or',
                                        ['status'=>'0'],
                                        ['status'=>'1'],
                                        ['status'=>'2'],
                                        ['status'=>'3'],
                                        ['status'=>'4'],
                                        ['status'=>'5'],
                                        ['status'=>'6']
                                    ])
                                    ->orderBy('loan_summary_id DESC');
									*/
        $query = LoanSummary::find()
                                    ->select('loan_summary.loan_summary_id AS loan_summary_id,loan_summary.status AS status, loan_summary.reference_number AS reference_number,loan_summary_detail.applicant_id AS applicant_id')
                                    ->innerJoin('loan_summary_detail', '`loan_summary_detail`.`loan_summary_id` = `loan_summary`.`loan_summary_id`')
									->andWhere(['and',
											   ['loan_summary_detail.applicant_id'=>$applicantID],
									   ])
                                    ->groupBy('{{loan_summary_detail}}.loan_summary_id')
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
        $query->andFilterWhere([
            'loan_summary_id' => $this->loan_summary_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number]);

        return $dataProvider;
    }
}
