<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundVerificationFramework;

/**
 * backend\modules\repayment\models\RefundVerificationFrameworkSearch represents the model behind the search form about `backend\modules\repayment\models\RefundVerificationFramework`.
 */
 class RefundVerificationFrameworkSearch extends RefundVerificationFramework
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_verification_framework_id', 'created_by', 'confirmed_by', 'updated_by', 'is_active'], 'integer'],
            [['verification_framework_title', 'verification_framework_desc', 'verification_framework_stage', 'support_document', 'created_at', 'confirmed_at', 'updated_at'], 'safe'],
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
        $query = RefundVerificationFramework::find();

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
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'confirmed_by' => $this->confirmed_by,
            'confirmed_at' => $this->confirmed_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'verification_framework_title', $this->verification_framework_title])
            ->andFilterWhere(['like', 'verification_framework_desc', $this->verification_framework_desc])
            ->andFilterWhere(['like', 'verification_framework_stage', $this->verification_framework_stage])
            ->andFilterWhere(['like', 'support_document', $this->support_document]);

        return $dataProvider;
    }
}
