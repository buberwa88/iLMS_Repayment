<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationUserStructure;

/**
 * backend\modules\allocation\models\AllocationUserStructureSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationUserStructure`.
 */
 class AllocationUserStructureSearch extends AllocationUserStructure
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_user_structure_id', 'allocation_structure_id', 'user_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = AllocationUserStructure::find();

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
            'allocation_user_structure_id' => $this->allocation_user_structure_id,
            'allocation_structure_id' => $this->allocation_structure_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
