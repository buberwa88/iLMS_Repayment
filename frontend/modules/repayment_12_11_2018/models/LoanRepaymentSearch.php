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
    public function rules()
    {
        return [
            [['loan_repayment_id', 'employer_id', 'applicant_id', 'pay_method_id'], 'integer'],
            [['bill_number', 'control_number', 'receipt_number', 'pay_phone_number', 'date_bill_generated', 'date_control_received', 'date_receipt_received'], 'safe'],
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
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
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
                                    ->groupBy('{{loan_repayment_detail}}.loan_repayment_id');
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
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
    public function searchByBatchID($params,$batchID)
    {
        $query = LoanRepayment::find()
                                   ->andwhere(['employer_id'=>$batchID]);

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
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
}
