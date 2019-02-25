<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundPaylistOperation;

/**
 * RefundPaylistOperationSearch represents the model behind the search form about `backend\modules\repayment\models\RefundPaylistOperation`.
 */
class RefundPaylistOperationSearch extends RefundPaylistOperation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_application_operation_id', 'refund_paylist_id', 'refund_internal_operational_id', 'previous_internal_operational_id', 'status', 'assignee', 'assigned_by', 'last_verified_by', 'is_current_stage', 'created_by', 'updated_by', 'is_active', 'general_status'], 'integer'],
            [['access_role_master', 'access_role_child', 'narration', 'assigned_at', 'date_verified', 'created_at', 'updated_at'], 'safe'],
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
        $query = RefundPaylistOperation::find();

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
            'refund_application_operation_id' => $this->refund_application_operation_id,
            'refund_paylist_id' => $this->refund_paylist_id,
            'refund_internal_operational_id' => $this->refund_internal_operational_id,
            'previous_internal_operational_id' => $this->previous_internal_operational_id,
            'status' => $this->status,
            'assignee' => $this->assignee,
            'assigned_at' => $this->assigned_at,
            'assigned_by' => $this->assigned_by,
            'last_verified_by' => $this->last_verified_by,
            'is_current_stage' => $this->is_current_stage,
            'date_verified' => $this->date_verified,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'general_status' => $this->general_status,
        ]);

        $query->andFilterWhere(['like', 'access_role_master', $this->access_role_master])
            ->andFilterWhere(['like', 'access_role_child', $this->access_role_child])
            ->andFilterWhere(['like', 'narration', $this->narration]);

        return $dataProvider;
    }

    public function searchPaylistOperation($params)
    {
        $query = RefundPaylistOperation::find();

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
        $query->joinwith(["refundInternalOperational"]);
        $query->andFilterWhere([
            'refund_application_operation_id' => $this->refund_application_operation_id,
            'refund_paylist_id' => $this->refund_paylist_id,
            'refund_internal_operational_id' => $this->refund_internal_operational_id,
            'previous_internal_operational_id' => $this->previous_internal_operational_id,
            'status' => $this->status,
            'assignee' => $this->assignee,
            'assigned_at' => $this->assigned_at,
            'assigned_by' => $this->assigned_by,
            'last_verified_by' => $this->last_verified_by,
            'is_current_stage' => $this->is_current_stage,
            'date_verified' => $this->date_verified,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'general_status' => $this->general_status,
        ]);

        $query->andFilterWhere(['like', 'access_role_master', $this->access_role_master])
            ->andFilterWhere(['like', 'access_role_child', $this->access_role_child])
            ->andFilterWhere(['like', 'narration', $this->narration]);

        return $dataProvider;
    }
}
