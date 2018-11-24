<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting;

/**
 * AllocationPlanInstitutionTypeSettingSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationPlanInstitutionTypeSetting`.
 */
class AllocationPlanInstitutionTypeSettingSearch extends AllocationPlanInstitutionTypeSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_plan_id', 'institution_type'], 'integer'],
            [['student_distribution_percentage'], 'number'],
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
        $query = AllocationPlanInstitutionTypeSetting::find();

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
            'allocation_plan_id' => $this->allocation_plan_id,
            'institution_type' => $this->institution_type,
            'student_distribution_percentage' => $this->student_distribution_percentage,
        ]);

        return $dataProvider;
    }
}
