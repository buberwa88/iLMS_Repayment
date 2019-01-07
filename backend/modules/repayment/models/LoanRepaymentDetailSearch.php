<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\LoanRepaymentDetail;

/**
 * LoanRepaymentDetailSearch represents the model behind the search form about `frontend\modules\repayment\models\LoanRepaymentDetail`.
 */
class LoanRepaymentDetailSearch extends LoanRepaymentDetail {

    /**
     * @inheritdoc
     */
	 public $date_bill_generated;
	 public $control_number;
	 public $payment_status;
	 public $employer_id;
	 public $payment_category;
    public function rules() {
        return [
            [['loan_repayment_detail_id', 'loan_repayment_id', 'applicant_id', 'loan_repayment_item_id', 'loan_summary_id'], 'integer'],
            [['amount'], 'number'],
            [['applicantName', 'firstname', 'surname', 'middlename', 'f4indexno', 'outstandingDebt', 'totalLoan','payment_status','date_bill_generated','control_number','employer_id','payment_category','first_name','middle_name','last_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params, $loan_repayment_id) {
        $query = LoanRepaymentDetail::find()
                ->groupBy('applicant_id')
                ->andWhere(['or',
            ['loan_repayment_id' => $loan_repayment_id],
            ['treasury_payment_id' => $loan_repayment_id]
        ]);

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
        $query->joinwith(["applicant", "applicant.user"]);

        $query->andFilterWhere([
            'loan_repayment_detail_id' => $this->loan_repayment_detail_id,
            'loan_repayment_id' => $this->loan_repayment_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'amount' => $this->amount,
            'applicantName' => $this->applicantName,
            'loan_summary_id' => $this->loan_summary_id,
        ]);

        $query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
                ->andFilterWhere(['like', 'user.firstname', $this->firstname])
                ->andFilterWhere(['like', 'user.middlename', $this->middlename])
                ->andFilterWhere(['like', 'user.surname', $this->surname])
                ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }

    /*
     * returns all repayments for any loadn beneficiary
     */

    static function getBeneficiaryRepayment($applicant_id) {
        $query = LoanRepaymentDetail::find()
                ->select('bill_number,control_number,receipt_number,payment_status,loan_repayment_detail_id,loan_repayment.loan_repayment_id,loan_repayment_detail.applicant_id,loan_given_to,prepaid_id,SUM(loan_repayment_detail.amount) as amount,')
                ->innerJoin('loan_repayment', 'loan_repayment_detail.loan_repayment_id=loan_repayment.loan_repayment_id')
                ->where(['loan_repayment_detail.applicant_id' => $applicant_id])
                ->groupBy('loan_repayment.loan_repayment_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
	public function searchAllEmployerRepaymentsknown($params) {
        $query = LoanRepaymentDetail::find()
		        ->select('bill_number,control_number,receipt_number,payment_status,loan_repayment_detail_id,loan_repayment.loan_repayment_id,loan_repayment_detail.applicant_id,loan_given_to,prepaid_id,SUM(loan_repayment_detail.amount) as amount,loan_repayment_detail.check_number,loan_repayment_detail.first_name,loan_repayment_detail.middle_name,loan_repayment_detail.last_name,loan_repayment.employer_id')
	            ->andWhere(['>','loan_repayment_detail.applicant_id','0'])
				->andWhere(['>','loan_repayment.employer_id','0'])
                ->groupBy('loan_repayment_detail.applicant_id');
                

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
		$query->joinWith("applicant");
        $query->joinwith(["applicant", "applicant.user"]);
		$query->joinWith(["loanRepayment", "loanRepayment.employer"]);

        $query->andFilterWhere([
            'loan_repayment_detail_id' => $this->loan_repayment_detail_id,
            'loan_repayment_id' => $this->loan_repayment_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'amount' => $this->amount,
            'applicantName' => $this->applicantName,
            'loan_summary_id' => $this->loan_summary_id,
			'loan_repayment.payment_category' => $this->payment_category,
			'loan_repayment.payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
                ->andFilterWhere(['like', 'user.firstname', $this->firstname])
                ->andFilterWhere(['like', 'user.middlename', $this->middlename])
                ->andFilterWhere(['like', 'user.surname', $this->surname])
				->andFilterWhere(['like', 'loan_repayment.control_number', $this->control_number])
				->andFilterWhere(['like', 'loan_repayment.date_bill_generated', $this->date_bill_generated])
				->andFilterWhere(['like', 'employer.employer_name', $this->employer_id])
                ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
	
	public function searchAllEmployerRepaymentsunknown($params) {
        $query = LoanRepaymentDetail::find()
		        ->select('bill_number,control_number,receipt_number,payment_status,loan_repayment_detail_id,loan_repayment.loan_repayment_id,loan_repayment_detail.applicant_id,loan_given_to,prepaid_id,loan_repayment_detail.amount,loan_repayment_detail.check_number,loan_repayment_detail.first_name,loan_repayment_detail.middle_name,loan_repayment_detail.last_name,loan_repayment.employer_id')
				->where(['loan_repayment_detail.applicant_id' => null])
	            //->andWhere(['>','loan_repayment_detail.applicant_id','0'])
				->andWhere(['>','loan_repayment.employer_id','0']);
                //->groupBy('loan_repayment_detail.applicant_id');
                

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
		//$query->joinWith("applicant");
        //$query->joinwith(["applicant", "applicant.user"]);
		$query->joinWith(["loanRepayment", "loanRepayment.employer"]);

        $query->andFilterWhere([
            'loan_repayment_detail_id' => $this->loan_repayment_detail_id,
            'loan_repayment_id' => $this->loan_repayment_id,
            'applicant_id' => $this->applicant_id,
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'amount' => $this->amount,
            'applicantName' => $this->applicantName,
            'loan_summary_id' => $this->loan_summary_id,
			'loan_repayment.payment_category' => $this->payment_category,
			'loan_repayment.payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'applicant_id', $this->applicant_id])
                ->andFilterWhere(['like', 'loan_repayment_detail.first_name', $this->first_name])
                ->andFilterWhere(['like', 'loan_repayment_detail.middle_name', $this->middle_name])
                ->andFilterWhere(['like', 'loan_repayment_detail.last_name', $this->last_name])
				->andFilterWhere(['like', 'loan_repayment.control_number', $this->control_number])
				->andFilterWhere(['like', 'loan_repayment.date_bill_generated', $this->date_bill_generated])
				->andFilterWhere(['like', 'employer.employer_name', $this->employer_id]);
                //->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno]);

        return $dataProvider;
    }

}
