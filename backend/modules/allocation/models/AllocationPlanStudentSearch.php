<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationPlanStudent;

/**
 * AllocationPlanStudentSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationPlanStudent`.
 */
class AllocationPlanStudentSearch extends AllocationPlanStudent {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['allocation_plan_id', 'application_id', 'study_year'], 'integer'],
            [['needness_amount', 'total_allocated_amount'], 'number'],
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
        $query = AllocationPlanStudent::find();

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
            'allocation_plan_id' => $this->allocation_plan_id,
            'allocation_plan_student_id' => $this->allocation_plan_student_id,
            'allocation_history_id' => $this->allocation_history_id,
            'application_id' => $this->application_id,
            'academic_year_id' => $this->academic_year_id,
            'student_fee' => $this->student_fee,
            'student_fee_factor' => $this->student_fee_factor,
            'student_myfactor' => $this->student_myfactor,
            'programme_cost' => $this->programme_cost,
            'student_ability' => $this->student_ability,
            'needness_amount' => $this->needness_amount,
            'total_allocated_amount' => $this->total_allocated_amount,
            'study_year' => $this->study_year,
            'allocation_type' => $this->allocation_type,
        ]);

        return $dataProvider;
    }

}
