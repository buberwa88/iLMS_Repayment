<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\RefundClaimant;

/**
 * RefundClaimantSearch represents the model behind the search form about `frontend\modules\repayment\models\RefundClaimant`.
 */
class RefundClaimantSearch extends RefundClaimant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_claimant_id', 'applicant_id', 'f4_completion_year', 'necta_details_confirmed', 'created_by', 'updated_by'], 'integer'],
            [['firstname', 'middlename', 'surname', 'sex', 'phone_number', 'f4indexno', 'necta_firstname', 'necta_middlename', 'necta_surname', 'necta_sex', 'created_at', 'updated_at'], 'safe'],
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
        $query = RefundClaimant::find();

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
            'refund_claimant_id' => $this->refund_claimant_id,
            'applicant_id' => $this->applicant_id,
            'f4_completion_year' => $this->f4_completion_year,
            'necta_details_confirmed' => $this->necta_details_confirmed,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'necta_firstname', $this->necta_firstname])
            ->andFilterWhere(['like', 'necta_middlename', $this->necta_middlename])
            ->andFilterWhere(['like', 'necta_surname', $this->necta_surname])
            ->andFilterWhere(['like', 'necta_sex', $this->necta_sex]);

        return $dataProvider;
    }
}
