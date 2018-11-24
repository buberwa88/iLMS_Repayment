<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ScholarshipProgramme;

/**
 * ScholarshipProgrammeSearch represents the model behind the search form about `backend\modules\allocation\models\ScholarshipProgramme`.
 */
class ScholarshipProgrammeSearch extends ScholarshipProgramme
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scholarship_id', 'programme_id', 'is_active', 'academic_year_id'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = ScholarshipProgramme::find();

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
            'scholarship_id' => $this->scholarship_id,
            'programme_id' => $this->programme_id,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
            'academic_year_id' => $this->academic_year_id,
        ]);

        return $dataProvider;
    }
}
