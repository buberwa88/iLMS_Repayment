<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ClusterDefinition;

/**
 * ClusterDefinitionSearch represents the model behind the search form about `backend\modules\allocation\models\ClusterDefinition`.
 */
class ClusterDefinitionSearch extends ClusterDefinition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cluster_definition_id'], 'integer'],
            [['cluster_name', 'cluster_desc'], 'safe'],
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
        $query = ClusterDefinition::find();

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
            'cluster_definition_id' => $this->cluster_definition_id,
        ]);

        $query->andFilterWhere(['like', 'cluster_name', $this->cluster_name])
            ->andFilterWhere(['like', 'cluster_desc', $this->cluster_desc]);

        return $dataProvider;
    }
}
