<?php

namespace backend\modules\allocation\controllers;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\Currency;

/**
 * CurrencySearch represents the model behind the search form about `backend\modules\allocation\models\Currency`.
 */
class CurrencySearch extends Currency
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id'], 'integer'],
            [['currency_ref', 'currency_postfix', 'currency_desc'], 'safe'],
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
        $query = Currency::find();

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
            'currency_id' => $this->currency_id,
        ]);

        $query->andFilterWhere(['like', 'currency_ref', $this->currency_ref])
            ->andFilterWhere(['like', 'currency_postfix', $this->currency_postfix])
            ->andFilterWhere(['like', 'currency_desc', $this->currency_desc]);

        return $dataProvider;
    }
}
