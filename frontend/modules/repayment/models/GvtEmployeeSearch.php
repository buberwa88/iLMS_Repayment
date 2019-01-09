<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\GvtEmployee;

/**
 * GvtEmployeeSearch represents the model behind the search form about `frontend\modules\repayment\models\GvtEmployee`.
 */
class GvtEmployeeSearch extends GvtEmployee
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gvt_employee_id'], 'integer'],
            [['vote_number', 'vote_name', 'Sub_vote', 'sub_vote_name', 'check_number', 'f4indexno', 'first_name', 'middle_name', 'surname', 'sex', 'NIN', 'employment_date', 'created_at', 'payment_date','checked_status'], 'safe'],
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
        $query = GvtEmployee::find();

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
            'gvt_employee_id' => $this->gvt_employee_id,
            'employment_date' => $this->employment_date,
            'created_at' => $this->created_at,
            'payment_date' => $this->payment_date,
            'checked_status' => $this->checked_status,
        ]);

        $query->andFilterWhere(['like', 'vote_number', $this->vote_number])
            ->andFilterWhere(['like', 'vote_name', $this->vote_name])
            ->andFilterWhere(['like', 'Sub_vote', $this->Sub_vote])
            ->andFilterWhere(['like', 'sub_vote_name', $this->sub_vote_name])
            ->andFilterWhere(['like', 'check_number', $this->check_number])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'NIN', $this->NIN]);

        return $dataProvider;
    }
}
