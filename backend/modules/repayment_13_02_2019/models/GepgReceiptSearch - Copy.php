<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\GepgReceipt;

/**
 * GepgReceiptSearch represents the model behind the search form about `backend\modules\application\models\GepgReceipt`.
 */
class GepgReceiptSearch extends GepgReceipt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'retrieved', 'reconciliation_status', 'recon_master_id','application_id'], 'integer'],
            [['bill_number', 'response_message', 'trans_id', 'payer_ref_id', 'currency', 'trans_date', 'payer_phone', 'payer_name', 'receipt_number', 'account_number','application_id','f4indexno','recon_amount'], 'safe'],
            [['control_number', 'bill_amount', 'paid_amount', 'amount_diff'], 'number'],
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
        $query = GepgReceipt::find()
		                    ->orderBy('id DESC');

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
		$query->joinWith("application");
		$query->joinwith(["application","application.applicant"]);
		
        $query->andFilterWhere([
            'id' => $this->id,
            'retrieved' => $this->retrieved,
            //'control_number' => $this->control_number,
            'bill_amount' => $this->bill_amount,
            'paid_amount' => $this->paid_amount,
            'trans_date' => $this->trans_date,
            'reconciliation_status' => $this->reconciliation_status,
            'amount_diff' => $this->amount_diff,
            'recon_master_id' => $this->recon_master_id,
        ]);

        $query->andFilterWhere(['like', 'gepg_receipt.bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'response_message', $this->response_message])
            ->andFilterWhere(['like', 'trans_id', $this->trans_id])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'payer_ref_id', $this->payer_ref_id])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'payer_phone', $this->payer_phone])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'gepg_receipt.receipt_number', $this->receipt_number])
			->andFilterWhere(['like', 'gepg_receipt.control_number', $this->control_number])
            ->andFilterWhere(['like', 'gepg_receipt.account_number', $this->account_number]);

        return $dataProvider;
    }
}
