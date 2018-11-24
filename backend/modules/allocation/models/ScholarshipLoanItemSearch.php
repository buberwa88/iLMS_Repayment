<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ScholarshipLoanItem;

/**
 * ScholarshipLoanItemSearch represents the model behind the search form about `backend\modules\allocation\models\ScholarshipLoanItem`.
 */
class ScholarshipLoanItemSearch extends ScholarshipLoanItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scholarship_definition_id', 'loan_item_id', 'is_active', 'is_loan_item'], 'integer'],
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
        $query = ScholarshipLoanItem::find();

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
            'scholarship_definition_id' => $this->scholarship_definition_id,
            'loan_item_id' => $this->loan_item_id,
            'is_active' => $this->is_active,
            'is_loan_item' => $this->is_loan_item,
        ]);

        return $dataProvider;
    }
}
