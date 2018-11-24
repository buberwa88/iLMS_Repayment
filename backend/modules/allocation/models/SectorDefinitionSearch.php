<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\SectorDefinition;

/**
 * SectorDefinitionSearch represents the model behind the search form about `backend\modules\allocation\models\SectorDefinition`.
 */
class SectorDefinitionSearch extends SectorDefinition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sector_definition_id'], 'integer'],
            [['sector_name', 'sector_desc'], 'safe'],
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
        $query = SectorDefinition::find();

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
            'sector_definition_id' => $this->sector_definition_id,
        ]);

        $query->andFilterWhere(['like', 'sector_name', $this->sector_name])
            ->andFilterWhere(['like', 'sector_desc', $this->sector_desc]);

        return $dataProvider;
    }
}
