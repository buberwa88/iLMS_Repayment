<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationPlanClusterSetting;

/**
 * AllocationPlanClusterSettingSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationPlanClusterSetting`.
 */
class AllocationPlanClusterSettingSearch extends AllocationPlanClusterSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_plan_cluster_setting_id', 'allocation_plan_id', 'cluster_definition_id', 'cluster_priority'], 'integer'],
            [['student_percentage_distribution', 'budget_percentage_distribution'], 'number'],
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
        $query = AllocationPlanClusterSetting::find();

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
            'allocation_plan_cluster_setting_id' => $this->allocation_plan_cluster_setting_id,
            'allocation_plan_id' => $this->allocation_plan_id,
            'cluster_definition_id' => $this->cluster_definition_id,
            'cluster_priority' => $this->cluster_priority,
            'student_percentage_distribution' => $this->student_percentage_distribution,
            'budget_percentage_distribution' => $this->budget_percentage_distribution,
        ]);

        return $dataProvider;
    }
}
