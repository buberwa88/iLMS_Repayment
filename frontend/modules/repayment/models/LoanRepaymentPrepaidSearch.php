<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\LoanRepaymentPrepaid;
use frontend\modules\repayment\models\EmployerSearch;

/**
 * LoanRepaymentPrepaidSearch represents the model behind the search form about `frontend\modules\repayment\models\LoanRepaymentPrepaid`.
 */
class LoanRepaymentPrepaidSearch extends LoanRepaymentPrepaid
{
    /**
     * @inheritdoc
     */
	 public $firstname;
	 public $middlename;
	 public $surname;
    public function rules()
    {
        return [
            [['prepaid_id', 'employer_id', 'applicant_id', 'loan_summary_id', 'created_by', 'payment_status', 'cancelled_by', 'gepg_cancel_request_status', 'monthly_deduction_status'], 'integer'],
            [['monthly_amount'], 'number'],
            [['payment_date', 'created_at', 'bill_number', 'control_number', 'receipt_number', 'date_bill_generated', 'date_control_received', 'receipt_date', 'date_receipt_received', 'cancelled_at', 'cancel_reason', 'date_deducted','firstname','middlename','surname'], 'safe'],
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
        $query = LoanRepaymentPrepaid::find();

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
            'prepaid_id' => $this->prepaid_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'loan_summary_id' => $this->loan_summary_id,
            'monthly_amount' => $this->monthly_amount,
            //'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'receipt_date' => $this->receipt_date,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
            'cancelled_by' => $this->cancelled_by,
            'cancelled_at' => $this->cancelled_at,
            'gepg_cancel_request_status' => $this->gepg_cancel_request_status,
            'monthly_deduction_status' => $this->monthly_deduction_status,
            'date_deducted' => $this->date_deducted,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason]);

        return $dataProvider;
    }
	public function searchPrepaid($params)
    {
		$loggedin = Yii::$app->user->identity->user_id;
        $employer2 = EmployerSearch::getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $query = LoanRepaymentPrepaid::find()->where(['employer_id'=>$employerID]);

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
            'prepaid_id' => $this->prepaid_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'loan_summary_id' => $this->loan_summary_id,
            'monthly_amount' => $this->monthly_amount,
            //'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'receipt_date' => $this->receipt_date,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
            'cancelled_by' => $this->cancelled_by,
            'cancelled_at' => $this->cancelled_at,
            'gepg_cancel_request_status' => $this->gepg_cancel_request_status,
            'monthly_deduction_status' => $this->monthly_deduction_status,
            'date_deducted' => $this->date_deducted,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
			->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
			->andFilterWhere(['like', 'user.surname', $this->surname])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason]);

        return $dataProvider;
    }
}
