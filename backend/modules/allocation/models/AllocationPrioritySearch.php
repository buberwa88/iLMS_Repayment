<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationPriority;

/**
 * AllocationPrioritySearch represents the model behind the search form about `backend\modules\allocation\models\AllocationPriority`.
 */
class AllocationPrioritySearch extends AllocationPriority
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_priority_id', 'academic_year_id', 'source_table', 'field_value', 'priority_order', 'baseline', 'created_by', 'updated_by'], 'integer'],
            [['source_table_field', 'created_at', 'updated_at'], 'safe'],
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
        $query = AllocationPriority::find();

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
            'allocation_priority_id' => $this->allocation_priority_id,
            'academic_year_id' => $this->academic_year_id,
            'source_table' => $this->source_table,
            'field_value' => $this->field_value,
            'priority_order' => $this->priority_order,
            'baseline' => $this->baseline,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'source_table_field', $this->source_table_field]);

        return $dataProvider;
    }
}
