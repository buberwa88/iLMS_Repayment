<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\Bank;

/**
 * BankSearch represents the model behind the search form about `backend\modules\application\models\Bank`.
 */
class BankSearch extends Bank
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank_id'], 'integer'],
            [['bank_name', 'swift_code'], 'safe'],
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
        $query = Bank::find();

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
            'bank_id' => $this->bank_id,
        ]);

        $query->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'swift_code', $this->swift_code]);

        return $dataProvider;
    }
}
