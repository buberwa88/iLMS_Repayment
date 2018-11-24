<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\GepgCnumber;

/**
 * GepgCnumberSearch represents the model behind the search form about `backend\modules\repayment\models\GepgCnumber`.
 */
class GepgCnumberSearch extends GepgCnumber
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'retrieved'], 'integer'],
            [['bill_number', 'response_message', 'control_number', 'trsxsts', 'trans_code', 'date_received'], 'safe'],
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
        $query = GepgCnumber::find();

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
            'id' => $this->id,
            'retrieved' => $this->retrieved,
            'date_received' => $this->date_received,
        ]);

        $query->andFilterWhere(['like', 'bill_number', $this->bill_number])
            ->andFilterWhere(['like', 'response_message', $this->response_message])
            ->andFilterWhere(['like', 'control_number', $this->control_number])
            ->andFilterWhere(['like', 'trsxsts', $this->trsxsts])
            ->andFilterWhere(['like', 'trans_code', $this->trans_code]);

        return $dataProvider;
    }
}
