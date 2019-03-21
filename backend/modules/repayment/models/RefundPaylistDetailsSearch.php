<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundPaylistDetails;

/**
 * RefundPaylistDetailsSearch represents the model behind the search form about `backend\modules\repayment\models\RefundPaylistDetails`.
 */
class RefundPaylistDetailsSearch extends RefundPaylistDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_paylist_details_id', 'refund_paylist_id', 'refund_claimant_id', 'refund_application_id', 'academic_year_id', 'financial_year_id', 'status'], 'integer'],
            [['refund_application_reference_number', 'claimant_f4indexno', 'claimant_name', 'phone_number', 'email_address', 'payment_bank_account_name', 'payment_bank_account_number', 'payment_bank_name', 'payment_bank_branch'], 'safe'],
            [['refund_claimant_amount'], 'number'],
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
        $query = RefundPaylistDetails::find();

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
            'refund_paylist_details_id' => $this->refund_paylist_details_id,
            'refund_paylist_id' => $this->refund_paylist_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'academic_year_id' => $this->academic_year_id,
            'financial_year_id' => $this->financial_year_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'refund_application_reference_number', $this->refund_application_reference_number])
            ->andFilterWhere(['like', 'claimant_f4indexno', $this->claimant_f4indexno])
            ->andFilterWhere(['like', 'claimant_name', $this->claimant_name])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'payment_bank_account_name', $this->payment_bank_account_name])
            ->andFilterWhere(['like', 'payment_bank_account_number', $this->payment_bank_account_number])
            ->andFilterWhere(['like', 'payment_bank_name', $this->payment_bank_name])
            ->andFilterWhere(['like', 'payment_bank_branch', $this->payment_bank_branch]);

        return $dataProvider;
    }
}
