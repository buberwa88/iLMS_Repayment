<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\Programme;

/**
 * ProgrammeSearch represents the model behind the search form about `backend\modules\allocation\models\Programme`.
 */
class ProgrammeSearch extends Programme
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['programme_id', 'learning_institution_id'], 'integer'],
            [['programme_code', 'programme_name'], 'safe'],
            [['academic_year'], 'required', 'on' => 'search'],
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
//            'years_of_study' => $this->years_of_study,
        ]);

        $query->andFilterWhere(['like', 'programme_code', $this->programme_code])
            ->andFilterWhere(['like', 'programme_name', $this->programme_name]);

        return $dataProvider;
    }
    
    public function searchCriteriaBases($params,$status)
    {
        $query = Programme::find()
                            ->where(['is_active'=>$status]);

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
//            'years_of_study' => $this->years_of_study,
        ]);

        $query->andFilterWhere(['like', 'programme_code', $this->programme_code])
            ->andFilterWhere(['like', 'programme_name', $this->programme_name]);

        return $dataProvider;
    }
    public function searchProgammeCosts($params = NULL) {
        $query = ProgrammeCost::find()
        //               ->select('programme.learning_institution_id,programme_category_id,programme_code,programme_name,programme_group_id,years_of_study,')
        ->join('RIGHT JOIN', 'programme', 'programme.programme_id=programme_cost.programme_id')
        ->where(['is_active' => self::STATUS_ACTIVE])
        ->orderBy('learning_institution_id');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($params) {
            $query->andFilterWhere([
                'academic_year_id' => $params['academic_year'],
            ]);
            if ($params['programme_id']) {
                $query->andFilterWhere([
                    'programme.programme_id' => $params['programme_id'],
                ]);
            }
            if ($params['learning_institution_id']) {
                $query->andFilterWhere([
                    'programme.learning_institution_id' => $params['learning_institution_id'],
                ]);
            }
            if ($$params['programme_group_id']) {
                $query->andFilterWhere([
                    'programme.programme_group_id' => $params['programme_group_id'],
                ]);
            }
            if ($this->year_of_study) {
                $query->andFilterWhere([
                    'year_of_study' => $params['year_of_study'],
                ]);
            }
        }
        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        
        return $dataProvider;
    }
    
}