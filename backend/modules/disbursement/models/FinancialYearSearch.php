<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\FinancialYear;

/**
 * FinancialYearSearch represents the model behind the search form about `backend\modules\disbursement\models\FinancialYear`.
 */
class FinancialYearSearch extends FinancialYear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['financial_year_id', 'is_active'], 'integer'],
            [['financial_year'], 'safe'],
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
        $query = FinancialYear::find();

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
            'financial_year_id' => $this->financial_year_id,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'financial_year', $this->financial_year]);

        return $dataProvider;
    }
}
