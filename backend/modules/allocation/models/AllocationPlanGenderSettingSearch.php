<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationPlanGenderSetting;

/**
 * AllocationPlanGenderSettingSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationPlanGenderSetting`.
 */
class AllocationPlanGenderSettingSearch extends AllocationPlanGenderSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_plan_gender_setting_id', 'allocation_plan_id'], 'integer'],
            [['female_percentage', 'male_percentage'], 'number'],
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
        $query = AllocationPlanGenderSetting::find();

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
            'allocation_plan_gender_setting_id' => $this->allocation_plan_gender_setting_id,
            'allocation_plan_id' => $this->allocation_plan_id,
            'female_percentage' => $this->female_percentage,
            'male_percentage' => $this->male_percentage,
        ]);

        return $dataProvider;
    }
    
    
}
