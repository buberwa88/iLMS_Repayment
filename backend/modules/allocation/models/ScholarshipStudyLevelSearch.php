<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ScholarshipStudyLevel;

/**
 * ScholarshipStudyLevelSearch represents the model behind the search form about `backend\modules\allocation\models\ScholarshipStudyLevel`.
 */
class ScholarshipStudyLevelSearch extends ScholarshipStudyLevel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scholarship_definition_id', 'applicant_category_id', 'academic_year_id'], 'integer'],
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
        $query = ScholarshipStudyLevel::find();

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
            'applicant_category_id' => $this->applicant_category_id,
            'academic_year_id' => $this->academic_year_id,
        ]);

        return $dataProvider;
    }
}
