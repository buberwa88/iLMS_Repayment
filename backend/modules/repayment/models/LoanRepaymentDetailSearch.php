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
    public function rules() {
        return [
            [['loan_repayment_detail_id', 'loan_repayment_id', 'applicant_id', 'loan_repayment_item_id', 'loan_summary_id'], 'integer'],
            [['amount'], 'number'],
            [['applicantName', 'firstname', 'surname', 'middlename', 'f4indexno', 'outstandingDebt', 'totalLoan'], 'safe'],
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

}
