<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\GepgLawson;

/**
 * GepgLawsonSearch represents the model behind the search form about `frontend\modules\repayment\models\GepgLawson`.
 */
class GepgLawsonSearch extends GepgLawson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gepg_lawson_id', 'status'], 'integer'],
            [['bill_number', 'control_number', 'control_number_date', 'deduction_month', 'gepg_date','amount_status'], 'safe'],
            [['amount'], 'number'],
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
        $query = GepgLawson::find();

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
            'gepg_lawson_id' => $this->gepg_lawson_id,
            'amount' => $this->amount,
            'control_number_date' => $this->control_number_date,
            'deduction_month' => $this->deduction_month,
            'status' => $this->status,
            'gepg_date' => $this->gepg_date,
			'amount_status' => $this->amount_status,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'control_number', $this->control_number]);

        return $dataProvider;
    }
}
