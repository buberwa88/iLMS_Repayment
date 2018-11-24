<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\Criteria;

/**
 * CriteriaSearch represents the model behind the search form about `backend\modules\allocation\models\Criteria`.
 */
class CriteriaSearch extends Criteria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criteria_id', 'is_active'], 'integer'],
            [['criteria_description'], 'safe'],
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
        $query = Criteria::find();

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
            'criteria_id' => $this->criteria_id,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'criteria_description', $this->criteria_description]);

        return $dataProvider;
    }
}
