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
            [['bill_number','transact_date_gepg', 'response_message', 'trans_id', 'payer_ref_id', 'currency', 'trans_date', 'payer_phone', 'payer_name', 'receipt_number', 'account_number','application_id','f4indexno','recon_amount'], 'safe'],
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
                                    //->select('gepg_receipt.receipt_number AS receipt_number,gepg_receipt.bill_number AS bill_number,gepg_receipt.bill_amount AS bill_amount,gepg_receipt.paid_amount AS paid_amount,gepg_receipt.application_id AS application_id,gepg_receipt.recon_amount AS recon_amount,gepg_receipt.amount_diff AS amount_diff,gepg_receipt.trans_date AS trans_date,gepg_receipt.reconciliation_status AS reconciliation_status,gepg_receipt.control_number AS control_number')
				    //->groupBy('receipt_number');
                                    //->groupBy('receipt_number')
                                   //->select('gepg_receipt.receipt_number AS receipt_number,gepg_receipt.bill_number AS bill_number,gepg_receipt.bill_amount AS bill_amount,gepg_receipt.paid_amount AS paid_amount,gepg_receipt.recon_amount AS recon_amount,gepg_receipt.amount_diff AS amount_diff,gepg_receipt.trans_date AS trans_date,gepg_receipt.reconciliation_status AS reconciliation_status,gepg_receipt.control_number AS control_number,application.application_id AS application_id')
                                   //->groupBy('receipt_number,bill_number,bill_amount,paid_amount,recon_amount,amount_diff,trans_date,reconciliation_status,control_number,application_id')
		                  //->select(["gepg_receipt.receipt_number AS receipt_number,gepg_receipt.bill_number AS bill_number,gepg_receipt.bill_amount AS bill_amount,gepg_receipt.paid_amount AS paid_amount,gepg_receipt.recon_amount AS recon_amount,gepg_receipt.amount_diff AS amount_diff,gepg_receipt.reconciliation_status AS reconciliation_status,gepg_receipt.control_number AS control_number,application.application_id AS application_id,DATE_FORMAT(gepg_receipt.trans_date, '%Y-%m-%d') as trans_dateF"]) 
                                  //->groupBy('receipt_number,bill_number,bill_amount,paid_amount,recon_amount,amount_diff,trans_dateF,reconciliation_status,control_number,application_id');
                                  
                            ->select(["gepg_receipt.receipt_number AS receipt_number,gepg_receipt.bill_number AS bill_number,gepg_receipt.bill_amount AS bill_amount,gepg_receipt.paid_amount AS paid_amount,gepg_receipt.recon_amount AS recon_amount,gepg_receipt.amount_diff AS amount_diff,gepg_receipt.reconciliation_status AS reconciliation_status,gepg_receipt.control_number AS control_number,application.application_id AS application_id,DATE_FORMAT(gepg_receipt.transact_date_gepg, '%Y-%m-%d') as trans_dateF"])
                            ->groupBy('receipt_number,bill_number,bill_amount,paid_amount,recon_amount,amount_diff,reconciliation_status,trans_dateF,control_number,application_id')
                            ->orderBy('trans_dateF DESC');

                          //->orderBy('gepg_receipt.id DESC');

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
            //'trans_date' => $this->trans_date,
            'reconciliation_status' => $this->reconciliation_status,
            'amount_diff' => $this->amount_diff,
            'recon_master_id' => $this->recon_master_id,
        ]);

        $query->andFilterWhere(['like', 'gepg_receipt.bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'response_message', $this->response_message])
            ->andFilterWhere(['like', 'transact_date_gepg', $this->transact_date_gepg])
            ->andFilterWhere(['like', 'trans_id', $this->trans_id])
			->andFilterWhere(['like', 'applicant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'payer_ref_id', $this->payer_ref_id])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'payer_phone', $this->payer_phone])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'trans_date', $this->trans_date])
            ->andFilterWhere(['like', 'gepg_receipt.receipt_number', $this->receipt_number])
			->andFilterWhere(['like', 'gepg_receipt.control_number', $this->control_number])
            ->andFilterWhere(['like', 'gepg_receipt.account_number', $this->account_number]);

        return $dataProvider;
    }
}

