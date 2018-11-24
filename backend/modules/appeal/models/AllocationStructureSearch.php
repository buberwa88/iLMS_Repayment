<?php

namespace backend\modules\appeal\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationStructure;

/**
 * backend\modules\appeal\models\AllocationStructureSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationStructure`.
 */
 class AllocationStructureSearch extends AllocationStructure
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_structure_id', 'parent_id', 'order_level', 'status'], 'integer'],
            [['structure_name'], 'safe'],
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
        $query = AllocationStructure::find();

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
            'allocation_structure_id' => $this->allocation_structure_id,
            'parent_id' => $this->parent_id,
            'order_level' => $this->order_level,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'structure_name', $this->structure_name]);

        return $dataProvider;
    }
}
