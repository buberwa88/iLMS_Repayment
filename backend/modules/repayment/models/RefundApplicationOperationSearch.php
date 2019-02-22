<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundApplicationOperation;

/**
 * RefundApplicationOperationSearch represents the model behind the search form about `backend\modules\repayment\models\RefundApplicationOperation`.
 */
class RefundApplicationOperationSearch extends RefundApplicationOperation
{
    /**
     * @inheritdoc
     */
    public $f4indexno;
    public $firstname;
    public $middlename;
    public $surname;
    public $refund_type_id;
    public $current_status;
    public function rules()
    {
        return [
            [['refund_application_operation_id', 'refund_application_id', 'refund_internal_operational_id', 'status', 'refund_status_reason_setting_id', 'assignee', 'assigned_by', 'last_verified_by', 'is_current_stage', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['narration', 'assigned_at', 'date_verified', 'created_at', 'updated_at'], 'safe'],
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
    $query = RefundApplicationOperation::find();

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
        'refund_application_id' => $this->refund_application_id,
        'refund_internal_operational_id' => $this->refund_internal_operational_id,
        'status' => $this->status,
        'refund_status_reason_setting_id' => $this->refund_status_reason_setting_id,
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
    ]);

    $query->andFilterWhere(['like', 'access_role', $this->access_role])
        ->andFilterWhere(['like', 'narration', $this->narration]);

    return $dataProvider;
}
    public function searchVerification($params,$roles)
    {
        $query = RefundApplicationOperation::find()
            ->select('refund_application.refund_application_id,refund_application.refund_claimant_id, refund_application.refund_type_id,refund_application.current_status,refund_claimant.f4indexno,refund_claimant.firstname,refund_claimant.middlename,refund_claimant.surname,refund_application.verification_response,refund_application.current_level')
            ->where(['or',
                ['in','refund_application_operation.access_role_master',$roles],
                ['in','refund_application_operation.access_role_child',$roles],
            ])
            ->groupBy(['refund_application_operation.refund_application_id']);

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
        $query->joinwith("refundApplication");
        $query->joinwith(["refundApplication","refundApplication.refundClaimant"]);
        $query->joinwith(["refundApplication","refundApplication.refundInternalOperationalSetting"]);
        $query->andFilterWhere([
            'refund_application_operation_id' => $this->refund_application_operation_id,
            'refund_application_id' => $this->refund_application_id,
            'refund_internal_operational_id' => $this->refund_internal_operational_id,
            //'status' => $this->status,
            'refund_status_reason_setting_id' => $this->refund_status_reason_setting_id,
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
            'refund_application.refund_type_id'=>$this->refund_type_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'refund_claimant.firstname', $this->firstname])
            ->andFilterWhere(['like', 'refund_claimant.middlename', $this->middlename])
            ->andFilterWhere(['like', 'refund_claimant.surname', $this->surname])
            ->andFilterWhere(['like', 'refund_claimant.f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'narration', $this->narration]);

        return $dataProvider;
    }
}
