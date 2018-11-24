<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\LoanItem;

/**
 * LoanItemSearch represents the model behind the search form about `backend\modules\allocation\models\LoanItem`.
 */
class LoanItemSearch extends LoanItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_item_id', 'is_active'], 'integer'],
            [['item_name', 'item_code'], 'safe'],
             
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
        $query = LoanItem::find();

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
            'loan_item_id' => $this->loan_item_id,
           
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'item_code', $this->item_code]);

        return $dataProvider;
    }
}
