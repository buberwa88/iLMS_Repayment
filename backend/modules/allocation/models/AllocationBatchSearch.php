<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationBatch;

/**
 * AllocationBatchSearch represents the model behind the search form about `frontend\modules\allocation\models\AllocationBatch`.
 */
class AllocationBatchSearch extends AllocationBatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_batch_id', 'batch_number', 'academic_year_id', 'is_approved', 'created_by', 'is_canceled'], 'integer'],
            [['batch_desc', 'approval_comment', 'created_at', 'cancel_comment'], 'safe'],
            [['available_budget'], 'number'],
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
        $query = AllocationBatch::find()->where("disburse_status IN(0,1)");

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
            'allocation_batch_id' => $this->allocation_batch_id,
            'batch_number' => $this->batch_number,
            'academic_year_id' => $this->academic_year_id,
            'available_budget' => $this->available_budget,
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'is_canceled' => $this->is_canceled,
        ]);

        $query->andFilterWhere(['like', 'batch_desc', $this->batch_desc])
            ->andFilterWhere(['like', 'approval_comment', $this->approval_comment])
          
            ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);

        return $dataProvider;
    }
     public function searchhli($params)
    {
        $query = AllocationBatch::find()->where("disburse_status IN(0,1)");

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
            'allocation_batch_id' => $this->allocation_batch_id,
            'batch_number' => $this->batch_number,
            'academic_year_id' => $this->academic_year_id,
            'available_budget' => $this->available_budget,
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'is_canceled' => $this->is_canceled,
        ]);

        $query->andFilterWhere(['like', 'batch_desc', $this->batch_desc])
            ->andFilterWhere(['like', 'approval_comment', $this->approval_comment])
          
            ->andFilterWhere(['like', 'cancel_comment', $this->cancel_comment]);

        return $dataProvider;
    }
}
