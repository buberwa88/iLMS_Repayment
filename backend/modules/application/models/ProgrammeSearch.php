<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\Programme;

/**
 * ProgrammeSearch represents the model behind the search form about `backend\modules\application\models\Programme`.
 */
class ProgrammeSearch extends Programme
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['programme_id', 'years_of_study'], 'integer'],
            [['programme_code', 'programme_name','learning_institution_id'], 'safe'],
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
        $query = Programme::find();

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
            'programme_id' => $this->programme_id,
            'learning_institution_id' => $this->learning_institution_id,
            'years_of_study' => $this->years_of_study,
        ]);

        $query->andFilterWhere(['like', 'programme_code', $this->programme_code])
            ->andFilterWhere(['like', 'programme_name', $this->programme_name]);

        return $dataProvider;
    }
	public function searchProgrameEmployer($params)
    {
        $query = Programme::find();

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
		$query->joinWith("learningInstitution");
        $query->andFilterWhere([
            'programme_id' => $this->programme_id,
            //'learning_institution_id' => $this->learning_institution_id,
            'years_of_study' => $this->years_of_study,
        ]);

        $query->andFilterWhere(['like', 'programme_code', $this->programme_code])
		    ->andFilterWhere(['like', 'learning_institution.institution_name', $this->learning_institution_id])
            ->andFilterWhere(['like', 'programme_name', $this->programme_name]);

        return $dataProvider;
    }
}
