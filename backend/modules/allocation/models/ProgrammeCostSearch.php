<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ProgrammeCost;

/**
 * ProgrammeFeeSearch represents the model behind the search form about `backend\modules\allocation\models\ProgrammeFee`.
 */
class ProgrammeCostSearch extends ProgrammeCost
{
    /**
     * @inheritdoc
     */
     public $learning_institution_id;
     public $rate_type;
    public function rules()
    {
        return [
            [['programme_cost_id', 'academic_year_id', 'programme_id', 'loan_item_id', 'duration', 'year_of_study'], 'integer'],
            [['unit_amount'], 'number'],
            [['learning_institution_id','rate_type'], 'safe'],
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
        $query = ProgrammeCost::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort'=>['attributes'=>['rate_type']]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'programme_cost_id' => $this->programme_cost_id,
            'academic_year_id' => $this->academic_year_id,
            'programme_id' => $this->programme_id,
            'loan_item_id' => $this->loan_item_id,
            'unit_amount' => $this->unit_amount,
            'duration' => $this->duration,
            'year_of_study' => $this->year_of_study,
            'rate_type'=>  $this->rate_type,
        ]);

        return $dataProvider;
    }
    public function searchByProgramme($params,$programme_id)
    {
        $query = ProgrammeCost::find()
                                ->where(['programme_id'=>$programme_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort'=>['attributes'=>['rate_type']]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'programme_cost_id' => $this->programme_cost_id,
            'academic_year_id' => $this->academic_year_id,
            'programme_id' => $this->programme_id,
            'loan_item_id' => $this->loan_item_id,
            'unit_amount' => $this->unit_amount,
            'duration' => $this->duration,
            'year_of_study' => $this->year_of_study,
            'rate_type'=>  $this->rate_type,
        ]);

        return $dataProvider;
    }
}
