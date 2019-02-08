<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\RefundClaimantEmployment;

/**
 * RefundClaimantEmploymentSearch represents the model behind the search form about `frontend\modules\repayment\models\RefundClaimantEmployment`.
 */
class RefundClaimantEmploymentSearch extends RefundClaimantEmployment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_claimant_employment_id', 'refund_claimant_id', 'refund_application_id', 'created_by', 'updated_by'], 'integer'],
            [['employer_name', 'start_date', 'end_date', 'employee_id', 'matching_status', 'created_at', 'updated_at'], 'safe'],
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
        $query = RefundClaimantEmployment::find();

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
            'refund_claimant_employment_id' => $this->refund_claimant_employment_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_application_id' => $this->refund_application_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'employer_name', $this->employer_name])
            ->andFilterWhere(['like', 'employee_id', $this->employee_id])
            ->andFilterWhere(['like', 'matching_status', $this->matching_status]);

        return $dataProvider;
    }
}
