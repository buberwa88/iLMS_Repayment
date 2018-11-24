<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\DisbursementBatch;

/**
 * DisbursementBatchSearch represents the model behind the search form about `backend\modules\disbursement\models\DisbursementBatch`.
 */
class DisbursementBatchSearch extends DisbursementBatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_batch_id', 'allocation_batch_id', 'learning_institution_id', 'academic_year_id', 'instalment_definition_id', 'batch_number', 'instalment_type', 'is_approved', 'institution_payment_request_id', 'created_by'], 'integer'],
            [['batch_desc', 'approval_comment', 'payment_voucher_number', 'cheque_number', 'created_at'], 'safe'],
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
        $query = DisbursementBatch::find();

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
            'disbursement_batch_id' => $this->disbursement_batch_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'learning_institution_id' => $this->learning_institution_id,
            'academic_year_id' => $this->academic_year_id,
            'instalment_definition_id' => $this->instalment_definition_id,
            'batch_number' => $this->batch_number,
            'instalment_type' => $this->instalment_type,
            'is_approved' => $this->is_approved,
            'institution_payment_request_id' => $this->institution_payment_request_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'batch_desc', $this->batch_desc])
            ->andFilterWhere(['like', 'approval_comment', $this->approval_comment])
            ->andFilterWhere(['like', 'payment_voucher_number', $this->payment_voucher_number])
            ->andFilterWhere(['like', 'cheque_number', $this->cheque_number]);

        return $dataProvider;
    }
     public function searchreviewdisbursement($params)
    {
        $query = DisbursementBatch::find();

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
            'disbursement_batch_id' => $this->disbursement_batch_id,
            'allocation_batch_id' => $this->allocation_batch_id,
            'learning_institution_id' => $this->learning_institution_id,
            'academic_year_id' => $this->academic_year_id,
            'instalment_definition_id' => $this->instalment_definition_id,
            'batch_number' => $this->batch_number,
            'instalment_type' => $this->instalment_type,
            'is_approved' => $this->is_approved,
            'institution_payment_request_id' => $this->institution_payment_request_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'batch_desc', $this->batch_desc])
            ->andFilterWhere(['like', 'approval_comment', $this->approval_comment])
            ->andFilterWhere(['like', 'payment_voucher_number', $this->payment_voucher_number])
            ->andFilterWhere(['like', 'cheque_number', $this->cheque_number]);

        return $dataProvider;
    }
}
