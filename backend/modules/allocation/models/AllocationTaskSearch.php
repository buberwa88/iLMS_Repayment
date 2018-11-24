<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationTask;

/**
 * backend\modules\allocation\models\AllocationTaskSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationTask`.
 */
 class AllocationTaskSearch extends AllocationTask
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_task_id', 'status'], 'integer'],
            [['task_name', 'accept_code', 'reject_code'], 'safe'],
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
        $query = AllocationTask::find();

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
            'allocation_task_id' => $this->allocation_task_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'task_name', $this->task_name])
            ->andFilterWhere(['like', 'accept_code', $this->accept_code])
            ->andFilterWhere(['like', 'reject_code', $this->reject_code]);

        return $dataProvider;
    }
}
