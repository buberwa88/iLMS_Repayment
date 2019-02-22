<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\LawsonMonthlyDeduction;

/**
 * LawsonMonthlyDeductionSearch represents the model behind the search form about `frontend\modules\repayment\models\LawsonMonthlyDeduction`.
 */
class LawsonMonthlyDeductionSearch extends LawsonMonthlyDeduction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lawson_monthly_deduction_id'], 'integer'],
            [['ActualBalanceAmount', 'DeductionAmount'], 'number'],
            [['CheckDate', 'CheckNumber', 'DateHired', 'DeductionCode', 'DeductionDesc', 'DeptName', 'FirstName', 'LastName', 'MiddleName', 'NationalId', 'Sex', 'VoteName', 'Votecode', 'created_at'], 'safe'],
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
        $query = LawsonMonthlyDeduction::find();

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
            'lawson_monthly_deduction_id' => $this->lawson_monthly_deduction_id,
            'ActualBalanceAmount' => $this->ActualBalanceAmount,
            'CheckDate' => $this->CheckDate,
            'DateHired' => $this->DateHired,
            'DeductionAmount' => $this->DeductionAmount,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'CheckNumber', $this->CheckNumber])
            ->andFilterWhere(['like', 'DeductionCode', $this->DeductionCode])
            ->andFilterWhere(['like', 'DeductionDesc', $this->DeductionDesc])
            ->andFilterWhere(['like', 'DeptName', $this->DeptName])
            ->andFilterWhere(['like', 'FirstName', $this->FirstName])
            ->andFilterWhere(['like', 'LastName', $this->LastName])
            ->andFilterWhere(['like', 'MiddleName', $this->MiddleName])
            ->andFilterWhere(['like', 'NationalId', $this->NationalId])
            ->andFilterWhere(['like', 'Sex', $this->Sex])
            ->andFilterWhere(['like', 'VoteName', $this->VoteName])
            ->andFilterWhere(['like', 'Votecode', $this->Votecode]);

        return $dataProvider;
    }
}
