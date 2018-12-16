<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\LoanRepayment;

/**
 * LoanRepaymentSearch represents the model behind the search form about `frontend\modules\repayment\models\LoanRepayment`.
 */
class LoanRepaymentSearch extends LoanRepayment
{
    /**
     * @inheritdoc
     */
    public $employer_name;
    public function rules()
    {
        return [
            [['loan_repayment_id', 'employer_id', 'applicant_id', 'pay_method_id'], 'integer'],
            [['bill_number', 'control_number', 'receipt_number', 'pay_phone_number', 'date_bill_generated', 'date_control_received', 'date_receipt_received','payment_date','employer_name'], 'safe'],
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
        $query = LoanRepayment::find()
                                ->orderBy("loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
    public function searchPaymentsForSpecificEmployer($params,$employerID)
    {
        $query = LoanRepayment::find()
                                    ->andwhere(['employer_id'=>$employerID])
                                    ->andWhere(['or',
                                        ['payment_status'=>'1'],
                                        ['payment_status'=>'0']
                                    ])
                                   ->orderBy("loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
	
	public function searchIncompleteBillEmployer($params,$employerID)
    {
        $query = LoanRepayment::find()
                                    ->andwhere(['employer_id'=>$employerID])
                                    ->andWhere(['and',
                                        ['payment_status'=>NULL],
                                    ])
                                    ->orderBy("loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
	
	public function searchPendingPaymentsEmployer($params,$employerID)
    {
        $query = LoanRepayment::find()
                                    ->andwhere(['employer_id'=>$employerID])
                                    ->andWhere(['and',
                                        ['payment_status'=>0],
                                    ])
                                    ->orderBy("loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
	
	public function searchPaymentsForSpecificApplicant($params,$applicantID)
    {
        $query = LoanRepayment::find()
                                    ->andwhere(['applicant_id'=>$applicantID])
                                    ->andWhere(['or',
                                        ['payment_status'=>'1'],
                                        ['payment_status'=>'0'],
                                    ])
                                    ->orderBy("loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
	
	public function searchPendingpaymentsBeneficiary($params,$applicantID)
    {
        $query = LoanRepayment::find()
                                    ->andwhere(['applicant_id'=>$applicantID])
                                    ->andWhere(['and',
                                        ['payment_status'=>'0'],
                                    ])
                                    ->orderBy("loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
	
	public function searchIncompleteBillBeneficiary($params,$applicantID)
    {
        $query = LoanRepayment::find()
                                    ->andwhere(['applicant_id'=>$applicantID])
                                    ->andWhere(['and',
                                        ['payment_status'=>NULL],
                                    ])
                                    ->orderBy("loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
	
	
    public function searchPaymentsForSpecificBeneficiary($params,$applicantID)
    {
        $query = LoanRepayment::find()
//                                    ->andwhere(['applicant_id'=>$applicantID])
//                                    ->andWhere(['or',
//                                        ['payment_status'=>'1'], 
//                                        ['payment_status'=>'0']
//                                    ]);
                                    ->select('loan_repayment.bill_number,loan_repayment.control_number,loan_repayment.date_control_received,loan_repayment.loan_repayment_id,loan_repayment_detail.applicant_id')
                                    ->leftJoin('loan_repayment_detail', '`loan_repayment_detail`.`loan_repayment_id` = `loan_repayment`.`loan_repayment_id`')
                                    ->where(['loan_repayment.payment_status' =>'1','loan_repayment_detail.applicant_id'=>$applicantID])
                                    ->groupBy('{{loan_repayment_detail}}.loan_repayment_id')
                                    ->orderBy("loan_repayment.loan_repayment_id DESC");
                                    //->with('orders');

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
    public function searchByBatchID($params,$batchID)
    {
        $query = LoanRepayment::find()
                                   ->andwhere(['employer_id'=>$batchID])
                                  ->orderBy("loan_repayment.loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
    public function searchTreasuryBills($params)
    {
        $query = LoanRepayment::find()
                                ->where(['loan_repayment.employer_id'=>NULL,'loan_repayment.applicant_id'=>NULL])
                                ->orderBy('loan_repayment.loan_repayment_id DESC');

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
    public function searchTreasuryBills2($params,$treasury_id)
    {
        $query = LoanRepayment::find()
                                ->where(['loan_repayment.treasury_payment_id'=>$treasury_id]);
                                //->orderBy('loan_repayment.loan_repayment_id DESC');

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
        //$query->joinwith(["loanRepayment","loanRepayment.employer"]);
        
        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])    
	    ->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
    public function searchReceiptTreasury($params)
    {
        $query = LoanRepayment::find()
                                ->where(['loan_repayment.employer_id'=>NULL,'loan_repayment.applicant_id'=>NULL,'payment_status'=>1])
                                ->orderBy("loan_repayment.loan_repayment_id DESC");

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
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
    public function searchTreasuryBillsEmployerPendingPayments($params)
    {
        $query = LoanRepayment::find()
                                ->select("loan_repayment.loan_repayment_id AS loan_repayment_id, loan_repayment.bill_number AS bill_number,loan_repayment.control_number AS control_number,loan_repayment.employer_id AS employer_id,loan_repayment.amount AS amount,loan_repayment.date_bill_generated AS date_bill_generated")
                                ->andWhere(['loan_repayment.payment_status'=>0,'employer.salary_source'=>1])
                                ->andWhere(['or',
                   ['loan_repayment.control_number'=>NULL],
                   ['loan_repayment.control_number'=>''],                 
                                    ]);
                                //->orderBy('loan_repayment.loan_repayment_id DESC');

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
        //$query->joinwith(["loanRepayment","loanRepayment.employer"]);
        
        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            //'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])    
	    ->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'date_bill_generated', $this->date_bill_generated])    
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

public function searchWaitingControlnumber($params)
    {
		$loggedin = Yii::$app->user->identity->user_id;
        $employer2 = \frontend\modules\repayment\models\EmployerSearch::getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        $query = LoanRepayment::find()
                                ->select("loan_repayment.payment_date AS payment_date,loan_repayment.bill_number AS bill_number,loan_repayment.control_number AS control_number,loan_repayment.employer_id AS employer_id,loan_repayment.amount AS amount,loan_repayment.date_bill_generated AS date_bill_generated")
                                ->andWhere(['loan_repayment.payment_status'=>0,'loan_repayment.employer_id'=>$employerID])
                                ->andWhere(['or',
                   ['loan_repayment.control_number'=>NULL],
                   ['loan_repayment.control_number'=>''],                 
                                    ]);
                                //->orderBy('loan_repayment.loan_repayment_id DESC');

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
        //$query->joinwith(["loanRepayment","loanRepayment.employer"]);
        
        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            //'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'employer.employer_name', $this->employer_name])    
	    ->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'date_bill_generated', $this->date_bill_generated])    
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
public function searchIncompleteBillEmployerGeneral($params,$employerID,$loan_given_to)
    {
        $query = LoanRepaymentDetail::find()
		                            ->select("loan_repayment.payment_date AS payment_date,loan_repayment.bill_number AS bill_number,loan_repayment.loan_repayment_id,loan_repayment.control_number AS control_number,loan_repayment.employer_id AS employer_id,loan_repayment.amount AS amount,loan_repayment.date_bill_generated AS date_bill_generated")
                                    ->andwhere(['loan_repayment.employer_id'=>$employerID,'loan_repayment_detail.loan_given_to'=>$loan_given_to])
                                    ->andWhere(['and',
                                        ['payment_status'=>NULL],
                                    ])
									->groupBy("loan_repayment_detail.loan_repayment_id")
                                    ->orderBy("loan_repayment.loan_repayment_id DESC");

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
        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
			->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }	
}
