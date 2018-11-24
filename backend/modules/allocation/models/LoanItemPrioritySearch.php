<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\LoanItemPriority;

/**
 * LoanItemPrioritySearch represents the model behind the search form about `backend\modules\allocation\models\LoanItemPriority`.
 */
class LoanItemPrioritySearch extends LoanItemPriority
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_item_priority_id', 'academic_year_id', 'loan_item_id', 'priority_order', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = LoanItemPriority::find();

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
            'loan_item_priority_id' => $this->loan_item_priority_id,
            'academic_year_id' => $this->academic_year_id,
            'loan_item_id' => $this->loan_item_id,
            'priority_order' => $this->priority_order,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
