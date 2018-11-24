<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ScholarshipStudent;

/**
 * ScholarshipStudentSearch represents the model behind the search form about `backend\modules\allocation\models\ScholarshipStudent`.
 */
class ScholarshipStudentSearch extends ScholarshipStudent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scholarship_student_id', 'scholarship_id', 'academic_year_id'], 'integer'],
            [['student_f4indexno', 'student_firstname', 'student_lastname', 'student_middlenames', 'student_f6indexno', 'student_admission_no'], 'safe'],
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
        $query = ScholarshipStudent::find();

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
            'scholarship_student_id' => $this->scholarship_student_id,
            'scholarship_id' => $this->scholarship_id,
            'academic_year_id' => $this->academic_year_id,
        ]);

        $query->andFilterWhere(['like', 'student_f4indexno', $this->student_f4indexno])
            ->andFilterWhere(['like', 'student_firstname', $this->student_firstname])
            ->andFilterWhere(['like', 'student_lastname', $this->student_lastname])
            ->andFilterWhere(['like', 'student_middlenames', $this->student_middlenames])
            ->andFilterWhere(['like', 'student_f6indexno', $this->student_f6indexno])
            ->andFilterWhere(['like', 'student_admission_no', $this->student_admission_no]);

        return $dataProvider;
    }
}
