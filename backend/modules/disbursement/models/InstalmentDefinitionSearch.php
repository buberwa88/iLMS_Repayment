<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\InstalmentDefinition;

/**
 * InstalmentDefinitionSearch represents the model behind the search form about `backend\modules\disbursement\models\InstalmentDefinition`.
 */
class InstalmentDefinitionSearch extends InstalmentDefinition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instalment_definition_id', 'instalment', 'is_active'], 'integer'],
            [['instalment_desc'], 'safe'],
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
        $query = InstalmentDefinition::find();

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
            'instalment_definition_id' => $this->instalment_definition_id,
            'instalment' => $this->instalment,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'instalment_desc', $this->instalment_desc]);

        return $dataProvider;
    }
}
