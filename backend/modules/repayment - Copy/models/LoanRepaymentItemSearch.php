<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\LoanRepaymentItem;

/**
 * LoanRepaymentItemSearch represents the model behind the search form about `backend\modules\repayment\models\LoanRepaymentItem`.
 */
class LoanRepaymentItemSearch extends LoanRepaymentItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_repayment_item_id', 'is_active', 'created_by'], 'integer'],
            [['item_name', 'item_code', 'created_at'], 'safe'],
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
        $query = LoanRepaymentItem::find();

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
            'loan_repayment_item_id' => $this->loan_repayment_item_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'item_code', $this->item_code]);

        return $dataProvider;
    }
}
