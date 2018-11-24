<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationSetting;

/**
 * AllocationSettingSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationSetting`.
 */
class AllocationSettingSearch extends AllocationSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_setting_id', 'academic_year_id', 'loan_item_id', 'priority_order', 'created_by'], 'integer'],
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
        $query = AllocationSetting::find();

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
            'allocation_setting_id' => $this->allocation_setting_id,
            'academic_year_id' => $this->academic_year_id,
            'loan_item_id' => $this->loan_item_id,
            'priority_order' => $this->priority_order,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        return $dataProvider;
    }
}
