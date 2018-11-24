<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\QresponseSource;

/**
 * QresponseSourceSearch represents the model behind the search form about `backend\modules\allocation\models\QresponseSource`.
 */
class QresponseSourceSearch extends QresponseSource
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qresponse_source_id'], 'integer'],
            [['source_table', 'source_table_value_field', 'source_table_text_field'], 'safe'],
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
        $query = QresponseSource::find();

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
            'qresponse_source_id' => $this->qresponse_source_id,
        ]);

        $query->andFilterWhere(['like', 'source_table', $this->source_table])
            ->andFilterWhere(['like', 'source_table_value_field', $this->source_table_value_field])
            ->andFilterWhere(['like', 'source_table_text_field', $this->source_table_text_field]);

        return $dataProvider;
    }
}
