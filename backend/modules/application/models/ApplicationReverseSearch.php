<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\ApplicationReverse;

/**
 * ApplicationReverseSearch represents the model behind the search form about `backend\modules\application\models\ApplicationReverse`.
 */
class ApplicationReverseSearch extends ApplicationReverse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_reverse_id', 'application_id', 'reversed_by'], 'integer'],
            [['comment', 'reversed_at'], 'safe'],
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
        $query = ApplicationReverse::find();

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
            'application_reverse_id' => $this->application_reverse_id,
            'application_id' => $this->application_id,
            'reversed_by' => $this->reversed_by,
            'reversed_at' => $this->reversed_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
