<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ScholarshipDefinition;

/**
 * ScholarshipDefinitionSearch represents the model behind the search form about `backend\modules\allocation\models\ScholarshipDefinition`.
 */
class ScholarshipDefinitionSearch extends ScholarshipDefinition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scholarship_id', 'is_active', 'is_full_scholarship'], 'integer'],
            [['scholarship_name', 'scholarship_desc', 'sponsor', 'country_of_study', 'start_year', 'end_year', 'closed_date'], 'safe'],
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
        $query = ScholarshipDefinition::find();

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
            'scholarship_id' => $this->scholarship_id,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
            'is_active' => $this->is_active,
            'closed_date' => $this->closed_date,
            'is_full_scholarship' => $this->is_full_scholarship,
        ]);

        $query->andFilterWhere(['like', 'scholarship_name', $this->scholarship_name])
            ->andFilterWhere(['like', 'scholarship_desc', $this->scholarship_desc])
            ->andFilterWhere(['like', 'sponsor', $this->sponsor])
            ->andFilterWhere(['like', 'country_of_study', $this->country_of_study]);

        return $dataProvider;
    }
}
