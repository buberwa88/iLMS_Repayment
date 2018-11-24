<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\EmployerPenaltyCycle;

/**
 * EmployerPenaltyCycleSearch represents the model behind the search form about `backend\modules\repayment\models\EmployerPenaltyCycle`.
 */
class EmployerPenaltyCycleSearch extends EmployerPenaltyCycle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_penalty_cycle_id', 'employer_id', 'repayment_deadline_day', 'duration', 'is_active', 'created_by', 'updated_by'], 'integer'],
            [['penalty_rate'], 'number'],
            [['duration_type', 'cycle_type', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmployerPenaltyCycle::find();

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
            'employer_penalty_cycle_id' => $this->employer_penalty_cycle_id,
            'employer_id' => $this->employer_id,
            'repayment_deadline_day' => $this->repayment_deadline_day,
            'penalty_rate' => $this->penalty_rate,
            'duration' => $this->duration,
            'is_active' => $this->is_active,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'duration_type', $this->duration_type])
            ->andFilterWhere(['like', 'cycle_type', $this->cycle_type]);

        return $dataProvider;
    }
}
