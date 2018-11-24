<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AcademicYear;

/**
 * AcademicYearSearch represents the model behind the search form about `backend\models\AcademicYear`.
 */
class AcademicYearSearch extends AcademicYear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_year_id', 'is_current'], 'integer'],
            [['academic_year'], 'safe'],
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
        $query = AcademicYear::find();

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
            'academic_year_id' => $this->academic_year_id,
            'is_current' => $this->is_current,
        ]);

        $query->andFilterWhere(['like', 'academic_year', $this->academic_year]);

        return $dataProvider;
    }
}
