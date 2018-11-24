<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AllocationPlanStudentLoanItem;

/**
 * AllocationPlanStudentLoanItemSearch represents the model behind the search form about `backend\modules\allocation\models\AllocationPlanStudentLoanItem`.
 */
class AllocationPlanStudentLoanItemSearch extends AllocationPlanStudentLoanItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allocation_plan_id', 'application_id', 'loan_item_id', 'priority_order', 'rate_type', 'duration'], 'integer'],
            [['unit_amount', 'loan_award_percentage', 'total_amount_awarded'], 'number'],
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
        $query = AllocationPlanStudentLoanItem::find();

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
            'application_id' => $this->application_id,
            'loan_item_id' => $this->loan_item_id,
            'priority_order' => $this->priority_order,
            'rate_type' => $this->rate_type,
            'unit_amount' => $this->unit_amount,
            'duration' => $this->duration,
            'loan_award_percentage' => $this->loan_award_percentage,
            'total_amount_awarded' => $this->total_amount_awarded,
        ]);

        return $dataProvider;
    }
}
