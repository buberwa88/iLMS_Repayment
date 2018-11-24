<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\StudentExamResult;

/**
 * StudentExamResultSearch represents the model behind the search form about `backend\modules\allocation\models\StudentExamResult`.
 */
class StudentExamResultSearch extends StudentExamResult {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['student_exam_result_id', 'academic_year_id', 'programme_id', 'study_year', 'exam_status_id', 'semester', 'created_by'], 'integer'],
            [['registration_number', 'f4indexno', 'created_at'], 'safe'],
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
//            'csatus' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
                ->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }

    public function searchByCriteria($params, $status) {
        $query = StudentExamResult::find()
                ->where(["status" => $status]);

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'verified_at' => $this->verified_at,
            'verified_by' => $this->verified_by,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
                ->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }

    public function searchConfirmedExaminationByInstitution($params = NULL, $institutionId) {
        $query = StudentExamResult::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params) {
            $this->load($params);
        }

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
            'status' => StudentExamResult::STATUS_CONFIRMED,
            'learning_institution_id' => $institutionId,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
                ->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }

    public function searchPendingExaminationByInstitution($params = NULL, $institutionId) {
        $query = StudentExamResult::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params) {
            $this->load($params);
        }

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
            'status' => StudentExamResult::STATUS_DRAFT,
            'learning_institution_id' => $institutionId,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
                ->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }

    /*
     * retives the list of Student examination results that have been verified by the HLI but not submitted as approved for HESLB use
     */

    public function searchVerifiedExaminationByInstitution($params = NULL, $institutionId) {
        $query = StudentExamResult::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params) {
            $this->load($params);
        }

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
            'status' => StudentExamResult::STATUS_VERIFIED,
            'learning_institution_id' => $institutionId,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number])
                ->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }

}
