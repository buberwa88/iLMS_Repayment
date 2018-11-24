<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\TreasuryPayment;

/**
 * TreasuryPaymentSearch represents the model behind the search form about `frontend\modules\repayment\models\TreasuryPayment`.
 */
class TreasuryPaymentSearch extends TreasuryPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['treasury_payment_id', 'pay_method_id', 'payment_status'], 'integer'],
            [['bill_number', 'control_number', 'receipt_number', 'pay_phone_number', 'payment_date', 'date_bill_generated', 'date_control_received', 'date_receipt_received'], 'safe'],
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
        $query = TreasuryPayment::find();

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
            'treasury_payment_id' => $this->treasury_payment_id,
            'amount' => $this->amount,
            'pay_method_id' => $this->pay_method_id,
            'payment_date' => $this->payment_date,
            //'date_bill_generated' => $this->date_bill_generated,
            'date_control_received' => $this->date_control_received,
            'date_receipt_received' => $this->date_receipt_received,
            'payment_status' => $this->payment_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'date_bill_generated', $this->date_bill_generated])
            ->andFilterWhere(['like', 'pay_phone_number', $this->pay_phone_number]);

        return $dataProvider;
    }
}
