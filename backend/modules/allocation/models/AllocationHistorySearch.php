<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationHistory;

/**
 * AllocationHistorySearch represents the model behind the search form about `backend\modules\allocation\models\AllocationHistory`.
 */
class AllocationHistorySearch extends AllocationHistory {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['loan_allocation_history_id', 'academic_year_id', 'study_level', 'place_of_study', 'allocation_framework_id', 'student_type', 'created_by', 'reviewed_by', 'approved_by', 'status'], 'integer'],
            [['created_at', 'reviewed_at', 'approved_at'], 'safe'],
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
        $query = AllocationHistory::find();
        $query->orderBy('loan_allocation_history_id DESC');
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
            'loan_allocation_history_id' => $this->loan_allocation_history_id,
            'academic_year_id' => $this->academic_year_id,
            'study_level' => $this->study_level,
            'place_of_study' => $this->place_of_study,
            'allocation_framework_id' => $this->allocation_framework_id,
            'student_type' => $this->student_type,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'reviewed_at' => $this->reviewed_at,
            'reviewed_by' => $this->reviewed_by,
            'approved_at' => $this->approved_at,
            'approved_by' => $this->approved_by,
            'status' => $this->status,
        ]);


        return $dataProvider;
    }

}
