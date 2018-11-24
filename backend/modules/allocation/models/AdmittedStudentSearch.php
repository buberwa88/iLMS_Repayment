<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AdmittedStudent;

/**
 * AdmittedStudentSearch represents the model behind the search form about `backend\modules\allocation\models\AdmittedStudent`.
 */
class AdmittedStudentSearch extends AdmittedStudent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admitted_student_id', 'admission_batch_id', 'programme_id', 'has_transfered'], 'integer'],
            [['f4indexno'], 'safe'],
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
        $query = AdmittedStudent::find();

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
            'admitted_student_id' => $this->admitted_student_id,
            'admission_batch_id' => $this->admission_batch_id,
            'programme_id' => $this->programme_id,
            'has_transfered' => $this->has_transfered,
        ]);

        $query->andFilterWhere(['like', 'f4indexno', $this->f4indexno]);

        return $dataProvider;
    }
}
