<?php

namespace backend\modules\appeal\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\appeal\models\AppealPlan;

/**
 * backend\modules\appeal\models\AppealPlanSearch represents the model behind the search form about `backend\modules\appeal\models\AppealPlan`.
 */
 class AppealPlanSearch extends AppealPlan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appeal_plan_id', 'academic_year_id', 'created_by', 'updated_by'], 'integer'],
            [['appeal_plan_title', 'appeal_plan_desc', 'created_at', 'updated_at','status'], 'safe'],
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
        $query = AppealPlan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'appeal_plan_id' => $this->appeal_plan_id,
            'academic_year_id' => $this->academic_year_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'appeal_plan_title', $this->appeal_plan_title])
            ->andFilterWhere(['like', 'appeal_plan_desc', $this->appeal_plan_desc]);

        return $dataProvider;
    }
}
