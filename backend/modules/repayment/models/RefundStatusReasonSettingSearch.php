<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundStatusReasonSetting;

/**
 * backend\modules\repayment\models\RefundStatusReasonSettingSearch represents the model behind the search form about `backend\modules\repayment\models\RefundStatusReasonSetting`.
 */
 class RefundStatusReasonSettingSearch extends RefundStatusReasonSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_status_reason_setting_id', 'status', 'category', 'created_by', 'updated_by'], 'integer'],
            [['reason', 'created_at', 'updated_at'], 'safe'],
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
        $query = RefundStatusReasonSetting::find();

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
            'refund_status_reason_setting_id' => $this->refund_status_reason_setting_id,
            'status' => $this->status,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
