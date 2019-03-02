<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundVerificationResponseSetting;

/**
 * RefundVerificationResponseSettingSearch represents the model behind the search form about `backend\modules\repayment\models\RefundVerificationResponseSetting`.
 */
class RefundVerificationResponseSettingSearch extends RefundVerificationResponseSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_verification_response_setting_id', 'verification_status', 'created_by', 'updated_by'], 'integer'],
            [['response_code', 'access_role_master', 'access_role_child', 'reason', 'created_at', 'updated_at', 'is_active'], 'safe'],
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
        $query = RefundVerificationResponseSetting::find();

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
            'refund_verification_response_setting_id' => $this->refund_verification_response_setting_id,
            'verification_status' => $this->verification_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'response_code', $this->response_code])
            ->andFilterWhere(['like', 'access_role_master', $this->access_role_master])
            ->andFilterWhere(['like', 'access_role_child', $this->access_role_child])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);

        return $dataProvider;
    }
}
