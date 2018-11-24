<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AdmissionStudent;

/**
 * AdmissionStudentSearch represents the model behind the search form about `backend\modules\allocation\models\AdmissionStudent`.
 */
class AdmissionStudentSearch extends AdmissionStudent {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['admission_student_id', 'admission_batch_id', 'programme_id', 'has_transfered', 'academic_year_id', 'admission_status'], 'integer'],
            [['f4indexno', 'firstname', 'middlename', 'surname', 'gender', 'f6indexno', 'course_code', 'course_description', 'institution_code', 'course_status', 'entry', 'study_year', 'admission_no', 'transfer_date'], 'safe'],
            [['points'], 'number'],
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
        $query = AdmissionStudent::find();


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
            'admission_student_id' => $this->admission_student_id,
            'admission_batch_id' => $this->admission_batch_id,
            'programme_id' => $this->programme_id,
            'has_transfered' => $this->has_transfered,
            'points' => $this->points,
            'academic_year_id' => $this->academic_year_id,
            'admission_status' => $this->admission_status,
        ]);

        $query->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
                ->andFilterWhere(['like', 'firstname', $this->firstname])
                ->andFilterWhere(['like', 'middlename', $this->middlename])
                ->andFilterWhere(['like', 'surname', $this->surname])
                ->andFilterWhere(['like', 'gender', $this->gender])
                ->andFilterWhere(['like', 'f6indexno', $this->f6indexno])
                ->andFilterWhere(['like', 'course_code', $this->course_code])
                ->andFilterWhere(['like', 'course_description', $this->course_description])
                ->andFilterWhere(['like', 'institution_code', $this->institution_code])
                ->andFilterWhere(['like', 'course_status', $this->course_status])
                ->andFilterWhere(['like', 'entry', $this->entry])
                ->andFilterWhere(['like', 'study_year', $this->study_year])
                ->andFilterWhere(['like', 'admission_no', $this->admission_no])
                ->andFilterWhere(['like', 'transfer_date', $this->transfer_date]);

        return $dataProvider;
    }

    public function searchByCriteria($params, $status) {
        $query = AdmissionStudent::find()
                ->where(['admission_status' => $status]);

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
            'admission_student_id' => $this->admission_student_id,
            'admission_batch_id' => $this->admission_batch_id,
            'programme_id' => $this->programme_id,
            'has_transfered' => $this->has_transfered,
            'points' => $this->points,
            'academic_year_id' => $this->academic_year_id,
            'admission_status' => $this->admission_status,
            'study_year' => $this->study_year,
        ]);

        $query->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
                ->andFilterWhere(['like', 'firstname', $this->firstname])
                ->andFilterWhere(['like', 'middlename', $this->middlename])
                ->andFilterWhere(['like', 'surname', $this->surname])
                ->andFilterWhere(['like', 'gender', $this->gender])
                ->andFilterWhere(['like', 'f6indexno', $this->f6indexno])
                ->andFilterWhere(['like', 'course_code', $this->course_code])
                ->andFilterWhere(['like', 'course_description', $this->course_description])
                ->andFilterWhere(['like', 'institution_code', $this->institution_code])
                ->andFilterWhere(['like', 'course_status', $this->course_status])
                ->andFilterWhere(['like', 'entry', $this->entry])
                ->andFilterWhere(['like', 'admission_no', $this->admission_no])
                ->andFilterWhere(['like', 'transfer_date', $this->transfer_date]);

        return $dataProvider;
    }

}
