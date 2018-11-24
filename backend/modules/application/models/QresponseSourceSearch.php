<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\QresponseSource;

/**
 * QresponseSourceSearch represents the model behind the search form about `backend\modules\application\models\QresponseSource`.
 */
class QresponseSourceSearch extends QresponseSource
{
    public function rules()
    {
        return [
            [['qresponse_source_id'], 'integer'],
            [['source_table', 'source_table_value_field', 'source_table_text_field'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = QresponseSource::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'qresponse_source_id' => $this->qresponse_source_id,
        ]);

        $query->andFilterWhere(['like', 'source_table', $this->source_table])
            ->andFilterWhere(['like', 'source_table_value_field', $this->source_table_value_field])
            ->andFilterWhere(['like', 'source_table_text_field', $this->source_table_text_field]);

        return $dataProvider;
    }
}
