<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\Loan;

/**
 * LoanSearch represents the model behind the search form about `backend\modules\repayment\models\Loan`.
 */
class LoanSearch extends Loan
{
    /**
     * @inheritdoc
     */
	 public $firstname;
	 public $middlename;
	 public $surname;
	 public $f4indexno;
	 public $amount;
	 public $paid;
	 public $outstandingDebt;
    public function rules()
    {
        return [
            [['loan_id', 'applicant_id', 'loan_repayment_item_id', 'academic_year_id', 'is_full_paid', 'loan_given_to', 'created_by', 'updated_by'], 'integer'],
            [['loan_number', 'created_at', 'updated_at','firstname','middlename','surname','f4indexno','amount','paid','outstandingDebt'], 'safe'],
            [['amount', 'vrf_accumulated'], 'number'],
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
        $query = Loan::find();

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
            'loan_id' => $this->loan_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'academic_year_id' => $this->academic_year_id,
            'amount' => $this->amount,
            'vrf_accumulated' => $this->vrf_accumulated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_full_paid' => $this->is_full_paid,
            'loan_given_to' => $this->loan_given_to,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'loan_number', $this->loan_number]);

        return $dataProvider;
    }
	public function Loansearch($params,$loan_given_to)
    {
        $query = Loan::find()
		           ->select('loan.applicant_id,loan.loan_number')
                   ->where(['loan.is_full_paid'=>1,'loan.loan_given_to'=>$loan_given_to])
				   //->where(['loan.is_full_paid'=>1])
				   ->groupBy('loan.applicant_id','loan.loan_number');

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
            'loan_id' => $this->loan_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'academic_year_id' => $this->academic_year_id,
            'amount' => $this->amount,
            'vrf_accumulated' => $this->vrf_accumulated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_full_paid' => $this->is_full_paid,
            'loan_given_to' => $this->loan_given_to,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'loan_number', $this->loan_number])		
		      ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			  ->andFilterWhere(['like', 'user.middlename', $this->middlename])
              ->andFilterWhere(['like', 'user.surname', $this->surname])
			  ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
}
