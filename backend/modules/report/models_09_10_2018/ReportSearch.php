<?php

namespace backend\modules\report\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\report\models\Report;

/**
 * ReportSearch represents the model behind the search form about `backend\modules\report\models\Report`.
 */
class ReportSearch extends Report
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category'], 'integer'],
            [['name', 'file_name', 'field1', 'field2', 'field3', 'field4', 'field5', 'type1', 'type2', 'type3', 'type4', 'type5', 'description1', 'description2', 'description3', 'description4', 'description5', 'sql', 'sql_where', 'sql_order', 'sql_group', 'column1', 'column2', 'column3', 'column4', 'column5', 'condition1', 'condition2', 'condition3', 'condition4', 'condition5', 'package'], 'safe'],
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
        $query = Report::find();

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
            'id' => $this->id,
            'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'field1', $this->field1])
            ->andFilterWhere(['like', 'field2', $this->field2])
            ->andFilterWhere(['like', 'field3', $this->field3])
            ->andFilterWhere(['like', 'field4', $this->field4])
            ->andFilterWhere(['like', 'field5', $this->field5])
            ->andFilterWhere(['like', 'type1', $this->type1])
            ->andFilterWhere(['like', 'type2', $this->type2])
            ->andFilterWhere(['like', 'type3', $this->type3])
            ->andFilterWhere(['like', 'type4', $this->type4])
            ->andFilterWhere(['like', 'type5', $this->type5])
            ->andFilterWhere(['like', 'description1', $this->description1])
            ->andFilterWhere(['like', 'description2', $this->description2])
            ->andFilterWhere(['like', 'description3', $this->description3])
            ->andFilterWhere(['like', 'description4', $this->description4])
            ->andFilterWhere(['like', 'description5', $this->description5])
            ->andFilterWhere(['like', 'sql', $this->sql])
            ->andFilterWhere(['like', 'sql_where', $this->sql_where])
            ->andFilterWhere(['like', 'sql_order', $this->sql_order])
            ->andFilterWhere(['like', 'sql_group', $this->sql_group])
            ->andFilterWhere(['like', 'column1', $this->column1])
            ->andFilterWhere(['like', 'column2', $this->column2])
            ->andFilterWhere(['like', 'column3', $this->column3])
            ->andFilterWhere(['like', 'column4', $this->column4])
            ->andFilterWhere(['like', 'column5', $this->column5])
            ->andFilterWhere(['like', 'condition1', $this->condition1])
            ->andFilterWhere(['like', 'condition2', $this->condition2])
            ->andFilterWhere(['like', 'condition3', $this->condition3])
            ->andFilterWhere(['like', 'condition4', $this->condition4])
            ->andFilterWhere(['like', 'condition5', $this->condition5])
            ->andFilterWhere(['like', 'package', $this->package]);

        return $dataProvider;
    }
}
