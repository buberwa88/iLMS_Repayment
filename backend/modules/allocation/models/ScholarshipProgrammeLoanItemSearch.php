<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ScholarshipProgrammeLoanItem;

/**
 * ScholarshipProgrammeLoanItemSearch represents the model behind the search form about `backend\modules\allocation\models\ScholarshipProgrammeLoanItem`.
 */
class ScholarshipProgrammeLoanItemSearch extends ScholarshipProgrammeLoanItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['academic_year_id', 'scholarships_id', 'programme_id', 'loan_item_id', 'rate_type', 'duration'], 'integer'],
            [['unit_amount'], 'number'],
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
        $query = ScholarshipProgrammeLoanItem::find();

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
            'created_at' => $this->created_at,
            'academic_year_id' => $this->academic_year_id,
            'scholarships_id' => $this->scholarships_id,
            'programme_id' => $this->programme_id,
            'loan_item_id' => $this->loan_item_id,
            'rate_type' => $this->rate_type,
            'unit_amount' => $this->unit_amount,
            'duration' => $this->duration,
        ]);

        return $dataProvider;
    }
}
