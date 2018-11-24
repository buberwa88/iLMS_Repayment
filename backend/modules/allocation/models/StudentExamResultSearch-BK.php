<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\StudentExamResult;

/**
 * StudentExamResultSearch represents the model behind the search form about `backend\modules\allocation\models\StudentExamResult`.
 */
class StudentExamResultSearch extends StudentExamResult
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_exam_result_id', 'academic_year_id', 'programme_id', 'study_year', 'exam_status_id', 'semester', 'confirmed', 'created_by', 'updated_by'], 'integer'],
            [['registration_number', 'f4indexno', 'created_at', 'updated_at'], 'safe'],
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
        $query = StudentExamResult::find();
                                    

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
            'student_exam_result_id' => $this->student_exam_result_id,
            'academic_year_id' => $this->academic_year_id,
            'programme_id' => $this->programme_id,
            'study_year' => $this->study_year,
            'exam_status_id' => $this->exam_status_id,
            'semester' => $this->semester,
            'confirmed' => $this->confirmed,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
    public function searchByCriteria($params,$status)
    {
        $query = StudentExamResult::find()
                                    ->where(["confirmed"=>$status]);

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
            'student_exam_result_id' => $this->student_exam_result_id,
            'academic_year_id' => $this->academic_year_id,
            'programme_id' => $this->programme_id,
            'study_year' => $this->study_year,
            'exam_status_id' => $this->exam_status_id,
            'semester' => $this->semester,
            'confirmed' => $this->confirmed,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
}
