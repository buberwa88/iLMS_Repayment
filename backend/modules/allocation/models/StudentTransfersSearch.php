<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\StudentTransfers;

/**
 * StudentTransfersSearch represents the model behind the search form about `backend\modules\allocation\models\StudentTransfers`.
 */
class StudentTransfersSearch extends StudentTransfers {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['student_transfer_id', 'student_f4indexno', 'student_reg_no', 'programme_from', 'programme_to', 'effective_study_year', 'admitted_student_id', 'academic_year_id'], 'integer'],
            [['date_initiated', 'date_completed', 'created_at'], 'safe'],
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
        $query = StudentTransfers::find();

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
            'student_transfer_id' => $this->student_transfer_id,
            'programme_from' => $this->programme_from,
            'programme_to' => $this->programme_to,
            'date_initiated' => $this->date_initiated,
            'date_completed' => $this->date_completed,
            'effective_study_year' => $this->effective_study_year,
            'admitted_student_id' => $this->admitted_student_id,
            'academic_year_id' => $this->academic_year_id
        ]);

        return $dataProvider;
    }

}
