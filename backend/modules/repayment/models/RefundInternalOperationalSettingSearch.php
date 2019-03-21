<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundInternalOperationalSetting;

/**
 * backend\modules\repayment\models\RefundInternalOperationalSettingSearch represents the model behind the search form about `backend\modules\repayment\models\RefundInternalOperationalSetting`.
 */
 class RefundInternalOperationalSettingSearch extends RefundInternalOperationalSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_internal_operational_id', 'flow_order_list', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['name', 'code', 'access_role_master', 'access_role_child', 'created_at', 'updated_at','approval_status','approval_comment'], 'safe'],
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
        $query = RefundInternalOperationalSetting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'refund_internal_operational_id' => $this->refund_internal_operational_id,
            'flow_order_list' => $this->flow_order_list,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'access_role_master', $this->access_role_master])
            ->andFilterWhere(['like', 'access_role_child', $this->access_role_child]);

        return $dataProvider;
    }
}
