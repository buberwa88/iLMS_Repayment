<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationBudget;

/**
 * AllocationBudgetSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationBudget`.
 */
class AllocationBudgetSearch extends AllocationBudget
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_budget_id', 'academic_year_id', 'study_level', 'is_active'], 'integer'],
            [['budget_amount'], 'number'],
            [['applicant_category', 'place_of_study', 'budget_scope'], 'safe'],
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
        $query = AllocationBudget::find();

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
            'allocation_budget_id' => $this->allocation_budget_id,
            'budget_amount' => $this->budget_amount,
            'academic_year_id' => $this->academic_year_id,
            'study_level' => $this->study_level,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'applicant_category', $this->applicant_category])
            ->andFilterWhere(['like', 'place_of_study', $this->place_of_study])
            ->andFilterWhere(['like', 'budget_scope', $this->budget_scope]);

        return $dataProvider;
    }
}
