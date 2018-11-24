<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ProgrammeCategory;

/**
 * ProgrammeCategorySearch represents the model behind the search form about `backend\modules\allocation\models\ProgrammeCategory`.
 */
class ProgrammeCategorySearch extends ProgrammeCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['programme_category_id'], 'integer'],
            [['programme_category_name', 'programme_category_desc'], 'safe'],
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
        $query = ProgrammeCategory::find();

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
            'programme_category_id' => $this->programme_category_id,
        ]);

        $query->andFilterWhere(['like', 'programme_category_name', $this->programme_category_name])
            ->andFilterWhere(['like', 'programme_category_desc', $this->programme_category_desc]);

        return $dataProvider;
    }
}
