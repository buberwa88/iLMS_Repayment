<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\LoanRepaymentDetail;

/**
 * LoanRepaymentDetailSearch represents the model behind the search form about `frontend\modules\repayment\models\LoanRepaymentDetail`.
 */
class LoanRepaymentDetailSearch extends LoanRepaymentDetail
{
    /**
     * @inheritdoc
     */
	 public $payment_status;
	 public $f4indexno;
	 public $employer_name;
	 public $bill_number2;
         public $payment_date;
         public $date_receipt_received;
         public $control_number;
         public $receipt_number;
    public function rules()
    {
        return [
            [['loan_repayment_detail_id', 'loan_repayment_id', 'treasury_payment_id', 'applicant_id', 'loan_repayment_item_id', 'loan_summary_id'], 'integer'],
            [['amount'], 'number'],
            //[['applicantName'], 'safe'],
			[['applicantName','firstname','surname','middlename','f4indexno','outstandingDebt','totalLoan','payment_status','f4indexno','employer_name','bill_number2','payment_date','date_receipt_received','control_number','receipt_number'], 'safe'],
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
    //used twice
    public function search($params,$loan_repayment_id)
    {
        $query = LoanRepaymentDetail::find()
                                    ->groupBy('applicant_id')
                                    ->where(['loan_repayment_id'=>$loan_repayment_id]);

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
            'loan_repayment_detail_id' => $this->loan_repayment_detail_id,
            'loan_repayment_id' => $this->loan_repayment_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'amount' => $this->amount,
            'applicantName'=> $this->applicantName,
            'loan_summary_id' => $this->loan_summary_id,
        ]);
		
		$query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
	public function searchTreasuryPayment($params,$treasury_payment_id)
    {
        $query = LoanRepaymentDetail::find()
                                    ->groupBy('applicant_id')
                                    ->where(['treasury_payment_id'=>$treasury_payment_id]);

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
            'loan_repayment_detail_id' => $this->loan_repayment_detail_id,
            'loan_repayment_id' => $this->loan_repayment_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'amount' => $this->amount,
            'applicantName'=> $this->applicantName,
            'loan_summary_id' => $this->loan_summary_id,
        ]);
		
		$query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
                        ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
	
	public function searchTreasuryAllPayments($params)
    {
        $query = LoanRepaymentDetail::find()
		                    ->select("SUM(loan_repayment_detail.amount) AS amount,loan_repayment_detail.loan_summary_id AS loan_summary_id,loan_repayment_detail.treasury_payment_id AS treasury_payment_id,loan_repayment_detail.applicant_id AS applicant_id,loan_repayment_detail.loan_repayment_id AS loan_repayment_id,loan_repayment.payment_status AS payment_status,applicant.f4indexno AS f4indexno")
                                    ->groupBy('applicant_id,loan_repayment_detail.treasury_payment_id')
				    ->andWhere(['not', ['loan_repayment_detail.treasury_payment_id'=>null]]);

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
		$query->joinWith("loanRepayment");
                //$query->joinWith("treasuryPayment");
                $query->joinwith(["applicant","applicant.user"]);		
		$query->joinWith(["loanRepayment","loanRepayment.employer"]);
		
        $query->andFilterWhere([
            'loan_repayment_detail_id' => $this->loan_repayment_detail_id,
            'loan_repayment_id' => $this->loan_repayment_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'amount' => $this->amount,
            'applicantName'=> $this->applicantName,
			'loan_repayment.payment_status'=> $this->payment_status,
            'loan_summary_id' => $this->loan_summary_id,
        ]);
		
		$query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
                        ->andFilterWhere(['like', 'loan_repayment.payment_date', $this->payment_date])
                        ->andFilterWhere(['like', 'loan_repayment.date_receipt_received', $this->date_receipt_received])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'loan_repayment.receipt_number', $this->receipt_number])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
                        ->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'loan_repayment.control_number', $this->control_number])
			->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
	
}
