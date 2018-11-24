<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationFrameworkSpecialGroup;

/**
 * AllocationFrameworkSpecialGroupSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationFrameworkSpecialGroup`.
 */
class AllocationFrameworkSpecialGroupSearch extends AllocationFrameworkSpecialGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_group_id', 'allocation_framework_id'], 'integer'],
            [['group_name', 'applicant_source_table', 'applicant_souce_column', 'applicant_source_value', 'operator'], 'safe'],
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
        $query = AllocationFrameworkSpecialGroup::find();

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
            'special_group_id' => $this->special_group_id,
            'allocation_framework_id' => $this->allocation_framework_id,
        ]);

        $query->andFilterWhere(['like', 'group_name', $this->group_name])
            ->andFilterWhere(['like', 'applicant_source_table', $this->applicant_source_table])
            ->andFilterWhere(['like', 'applicant_souce_column', $this->applicant_souce_column])
            ->andFilterWhere(['like', 'applicant_source_value', $this->applicant_source_value])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
