<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\VerificationCustomCriteria;

/**
 * VerificationCustomCriteriaSearch represents the model behind the search form about `backend\modules\application\models\VerificationCustomCriteria`.
 */
class VerificationCustomCriteriaSearch extends VerificationCustomCriteria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['verification_custom_criteria_id', 'verification_framework_id', 'created_by'], 'integer'],
            [['criteria_name', 'applicant_source_table', 'applicant_souce_column', 'applicant_source_value', 'operator', 'created_at'], 'safe'],
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
        $query = VerificationCustomCriteria::find();

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
            'verification_custom_criteria_id' => $this->verification_custom_criteria_id,
            'verification_framework_id' => $this->verification_framework_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'criteria_name', $this->criteria_name])
            ->andFilterWhere(['like', 'applicant_source_table', $this->applicant_source_table])
            ->andFilterWhere(['like', 'applicant_souce_column', $this->applicant_souce_column])
            ->andFilterWhere(['like', 'applicant_source_value', $this->applicant_source_value])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
