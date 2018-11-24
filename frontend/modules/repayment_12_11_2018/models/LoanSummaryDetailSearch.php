<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\LoanSummaryDetail;

/**
 * LoanSummaryDetailSearch represents the model behind the search form about `frontend\modules\repayment\models\LoanSummaryDetail`.
 */
class LoanSummaryDetailSearch extends LoanSummaryDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_summary_detail_id', 'loan_summary_id', 'applicant_id', 'loan_repayment_item_id', 'academic_year_id'], 'integer'],
			[['firstname','surname','middlename','f4indexno','paid','outstandingDebt','totalLoan'], 'safe'],
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
        $query = LoanSummaryDetail::find();

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
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
		
        $query->andFilterWhere([
            'loan_summary_detail_id' => $this->loan_summary_detail_id,
            'loan_summary_id' => $this->loan_summary_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'academic_year_id' => $this->academic_year_id,
            'amount' => $this->amount,
        ]);
        
		$query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);
			
        return $dataProvider;
    }
    public function loaneesUnderBill($params,$loan_summary_id)
    {
        $query = LoanSummaryDetail::find()
                                    ->where(['loan_summary_id'=>$loan_summary_id])
                                    ->groupBy('applicant_id')
                                    ->orderBy('loan_summary_detail_id DESC');

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
		$query->joinWith("applicant");
         $query->joinwith(["applicant","applicant.user"]);
		
        $query->andFilterWhere([
            'loan_summary_detail_id' => $this->loan_summary_detail_id,
            'loan_summary_id' => $this->loan_summary_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'academic_year_id' => $this->academic_year_id,
            'amount' => $this->amount,
        ]);
		
		$query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
}
