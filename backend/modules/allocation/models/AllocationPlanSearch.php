<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationPlan;

/**
 * AllocationPlanSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationPlan`.
 */
class AllocationPlanSearch extends AllocationPlan {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year_id', 'allocation_plan_id', 'allocation_plan_stage'], 'integer'],
            [['allocation_plan_title', 'allocation_plan_desc', 'allocation_plan_number', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = AllocationPlan::find();

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
        $query->orderBy('allocation_plan_id DESC');
        // grid filtering conditions
        $query->andFilterWhere([
            'academic_year_id' => $this->academic_year_id,
            'allocation_plan_id' => $this->allocation_plan_id,
            'allocation_plan_stage' => $this->allocation_plan_stage,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'allocation_plan_title', $this->allocation_plan_title])
                ->andFilterWhere(['like', 'allocation_plan_desc', $this->allocation_plan_desc])
                ->andFilterWhere(['like', 'allocation_plan_number', $this->allocation_plan_number]);

        return $dataProvider;
    }

}
