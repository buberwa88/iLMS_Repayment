<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\LoanRepayment;

/**
 * LoanRepaymentSearch represents the model behind the search form about `frontend\modules\repayment\models\LoanRepayment`.
 */
class LoanRepaymentSearch extends LoanRepayment {

    /**
     * @inheritdoc
     */
    public $f4indexno;
    public $firstname;
    public $middlename;
    public $surname;

    public function rules() {
        return [
            [['loan_repayment_id', 'pay_method_id'], 'integer'],
            [['bill_number', 'control_number', 'receipt_number', 'pay_phone_number', 'date_bill_generated', 'date_control_received', 'date_receipt_received', 'payment_date', 'payment_status', 'employer_id', 'applicant_id', 'f4indexno', 'firstname', 'middlename', 'surname'], 'safe'],
            [['amount'], 'number'],
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
    public function search($params) {
        $query = LoanRepayment::find();

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
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
                ->andFilterWhere(['like', 'control_number', $this->control_number])
                ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
                ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

    public function searchPaymentsForSpecificEmployer($params) {
        $query = LoanRepayment::find()
                //->andwhere(['employer_id'=>$employerID])
                ->andWhere(['or',
            ['payment_status' => '1'],
            ['payment_status' => '0']
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
        $query->joinWith("employer");
        $query->joinWith("applicant");
        $query->joinwith(["applicant", "applicant.user"]);

        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            //'employer_id' => $this->employer_id,
            //'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
                ->andFilterWhere(['like', 'control_number', $this->control_number])
                ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
                ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id])
                ->andFilterWhere(['like', 'user.firstname', $this->applicant_id])
                ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

    public function searchByBatchID($params, $batchID) {
        $query = LoanRepayment::find()
                ->andwhere(['employer_id' => $batchID]);

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
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
                ->andFilterWhere(['like', 'control_number', $this->control_number])
                ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
                ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

    public function searchPaymentsForSpecificEmployerheslb($params) {
        $query = LoanRepayment::find()
                ->where(['>', 'loan_repayment.employer_id', '0'])
                ->andWhere(['or',
                    ['payment_status' => '1'],
                    ['payment_status' => '0']
                ])
                ->andWhere(['or',
            ['treasury_payment_id' => NULL],
            ['treasury_payment_id' => '']
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
        $query->joinWith("employer");
        $query->joinWith("applicant");
        $query->joinwith(["applicant", "applicant.user"]);

        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            //'employer_id' => $this->employer_id,
            //'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
                ->andFilterWhere(['like', 'control_number', $this->control_number])
                ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
                ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id])
                ->andFilterWhere(['like', 'user.firstname', $this->applicant_id])
                ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

    public function searchPaymentsForSpecificBeneficiaryheslb($params) {
        $query = LoanRepayment::find()
                ->where(['>', 'loan_repayment.applicant_id', '0'])
                ->andWhere(['or',
                    ['payment_status' => '1'],
                    ['payment_status' => '0']
                ])
                ->andWhere(['or',
            ['treasury_payment_id' => NULL],
            ['treasury_payment_id' => '']
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
        $query->joinWith("employer");
        $query->joinWith("applicant");
        $query->joinwith(["applicant", "applicant.user"]);

        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            //'employer_id' => $this->employer_id,
            //'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
                ->andFilterWhere(['like', 'control_number', $this->control_number])
                ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
                ->andFilterWhere(['like', 'user.firstname', $this->firstname])
                ->andFilterWhere(['like', 'user.middlename', $this->middlename])
                ->andFilterWhere(['like', 'user.surname', $this->surname])
                ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id])
                ->andFilterWhere(['like', 'user.firstname', $this->applicant_id])
                ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

    public function searchPaymentsForSpecificBeneficiaryheslbRe($params) {
        $query = LoanRepayment::find()
                ->andWhere(['and',
                    ['>', 'loan_repayment.applicant_id', '0'],
                    ['payment_status' => '1']
                ])
                ->andWhere(['or',
            ['treasury_payment_id' => NULL],
            ['treasury_payment_id' => '']
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
        $query->joinWith("employer");
        $query->joinWith("applicant");
        $query->joinwith(["applicant", "applicant.user"]);

        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            //'employer_id' => $this->employer_id,
            //'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
                ->andFilterWhere(['like', 'control_number', $this->control_number])
                ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
                ->andFilterWhere(['like', 'user.firstname', $this->firstname])
                ->andFilterWhere(['like', 'user.middlename', $this->middlename])
                ->andFilterWhere(['like', 'user.surname', $this->surname])
                ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id])
                ->andFilterWhere(['like', 'user.firstname', $this->applicant_id])
                ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

    public function searchPaymentsForSpecificEmployerheslbRe($params) {
        $query = LoanRepayment::find()
                //->where(['>', 'loan_repayment.employer_id', '0'])
                ->andWhere(['and',
                    ['>', 'loan_repayment.employer_id', '0'],
                    ['payment_status' => '1']
                ])
                ->andWhere(['or',
            ['treasury_payment_id' => NULL],
            ['treasury_payment_id' => '']
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
        $query->joinWith("employer");
        $query->joinWith("applicant");
        $query->joinwith(["applicant", "applicant.user"]);

        $query->andFilterWhere([
            'loan_repayment_id' => $this->loan_repayment_id,
            //'employer_id' => $this->employer_id,
            //'applicant_id' => $this->applicant_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
                ->andFilterWhere(['like', 'control_number', $this->control_number])
                ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
                ->andFilterWhere(['like', 'employer.employer_name', $this->employer_id])
                ->andFilterWhere(['like', 'user.firstname', $this->applicant_id])
                ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }

    

}
