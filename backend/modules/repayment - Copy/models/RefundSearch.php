<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\Refund;

/**
 * RefundSearch represents the model behind the search form about `backend\modules\repayment\models\Refund`.
 */
class RefundSearch extends Refund
{
    /**
     * @inheritdoc
     */
	 public $firstname;
	 public $middlename;
	 public $surname;
	 public $totalAmount;
    public function rules()
    {
        return [
            [['refund_id', 'claim_category', 'employer_id', 'applicant_id', 'claim_status', 'created_by', 'updated_by'], 'integer'],
            [['employee_id', 'description', 'claimant_letter_id', 'claimant_letter_received_date', 'claim_decision_date', 'phone_number', 'email_address', 'bank_name', 'bank_account_number', 'branch_name', 'claim_file_id', 'created_at', 'updated_at','beneficiary_f4indexno','firstname','middlename','surname','f4indexno','totalAmount'], 'safe'],
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
        $query = Refund::find();
		                 

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
            'refund_id' => $this->refund_id,
            'claim_category' => $this->claim_category,
            'employer_id' => $this->employer_id,
            'applicant_id' => $this->applicant_id,
            'claimant_letter_received_date' => $this->claimant_letter_received_date,
            'claim_decision_date' => $this->claim_decision_date,
            'amount' => $this->amount,
            'claim_status' => $this->claim_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
		    ->andFilterWhere(['like', 'user.firstname', $this->firstname])
			->andFilterWhere(['like', 'user.middlename', $this->middlename])
            ->andFilterWhere(['like', 'user.surname', $this->surname])
            ->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'claimant_letter_id', $this->claimant_letter_id])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'branch_name', $this->branch_name])
			->andFilterWhere(['like', 'beneficiary_f4indexno', $this->beneficiary_f4indexno])
            ->andFilterWhere(['like', 'claim_file_id', $this->claim_file_id]);

        return $dataProvider;
    }
}
