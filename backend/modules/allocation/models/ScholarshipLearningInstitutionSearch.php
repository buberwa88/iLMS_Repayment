<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ScholarshipLearningInstitution;

/**
 * ScholarshipLearningInstitutionSearch represents the model behind the search form about `backend\modules\allocation\models\ScholarshipLearningInstitution`.
 */
class ScholarshipLearningInstitutionSearch extends ScholarshipLearningInstitution
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scholarship_id', 'learning_institution_id', 'is_active', 'academic_year_id'], 'integer'],
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
        $query = ScholarshipLearningInstitution::find();

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
            'learning_institution_id' => $this->learning_institution_id,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
            'academic_year_id' => $this->academic_year_id,
        ]);

        return $dataProvider;
    }
}
