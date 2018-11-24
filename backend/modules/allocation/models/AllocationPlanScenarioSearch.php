<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationFrameworkScenario;

/**
 * AllocationFrameworkScenarioSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationFrameworkScenario`.
 */
class AllocationFrameworkScenarioSearch extends AllocationFrameworkScenario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_framework_scenario_id', 'allocation_framework_id', 'allocation_scenario', 'priority_order'], 'integer'],
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
        $query = AllocationFrameworkScenario::find();

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
            'allocation_framework_scenario_id' => $this->allocation_framework_scenario_id,
            'allocation_framework_id' => $this->allocation_framework_id,
            'allocation_scenario' => $this->allocation_scenario,
            'priority_order' => $this->priority_order,
        ]);

        return $dataProvider;
    }
}
