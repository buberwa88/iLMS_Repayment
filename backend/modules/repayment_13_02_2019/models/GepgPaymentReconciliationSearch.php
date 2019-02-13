<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\GepgPaymentReconciliation;

/**
 * GepgPaymentReconciliationSearch represents the model behind the search form about `backend\modules\repayment\models\GepgPaymentReconciliation`.
 */
class GepgPaymentReconciliationSearch extends GepgPaymentReconciliation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'trans_id'], 'integer'],
            [['trans_date', 'bill_number', 'control_number', 'receipt_number', 'payment_channel', 'account_number', 'Remarks', 'date_created'], 'safe'],
            [['paid_amount'], 'number'],
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
        $query = GepgPaymentReconciliation::find();

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
            'id' => $this->id,
            'trans_id' => $this->trans_id,
            'trans_date' => $this->trans_date,
            'paid_amount' => $this->paid_amount,
            'date_created' => $this->date_created,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'receipt_number', $this->receipt_number])
            ->andFilterWhere(['like', 'payment_channel', $this->payment_channel])
            ->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'Remarks', $this->Remarks]);

        return $dataProvider;
    }
}
