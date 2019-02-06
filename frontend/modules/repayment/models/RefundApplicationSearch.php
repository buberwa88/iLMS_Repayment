<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\RefundApplication;

/**
 * RefundApplicationSearch represents the model behind the search form about `frontend\modules\repayment\models\RefundApplication`.
 */
class RefundApplicationSearch extends RefundApplication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_application_id', 'refund_claimant_id', 'finaccial_year_id', 'academic_year_id', 'current_status', 'refund_verification_framework_id', 'bank_id', 'refund_type_id', 'created_by', 'updated_by', 'is_active', 'submitted'], 'integer'],
            [['application_number', 'trustee_firstname', 'trustee_midlename', 'trustee_surname', 'trustee_sex', 'check_number', 'bank_account_number', 'bank_account_name', 'liquidation_letter_number', 'created_at', 'updated_at'], 'safe'],
            [['refund_claimant_amount'], 'number'],
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
        $query = RefundApplication::find();

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
            'refund_application_id' => $this->refund_application_id,
            'refund_claimant_id' => $this->refund_claimant_id,
            'refund_claimant_amount' => $this->refund_claimant_amount,
            'finaccial_year_id' => $this->finaccial_year_id,
            'academic_year_id' => $this->academic_year_id,
            'current_status' => $this->current_status,
            'refund_verification_framework_id' => $this->refund_verification_framework_id,
            'bank_id' => $this->bank_id,
            'refund_type_id' => $this->refund_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
            'submitted' => $this->submitted,
        ]);

        $query->andFilterWhere(['like', 'application_number', $this->application_number])
            ->andFilterWhere(['like', 'trustee_firstname', $this->trustee_firstname])
            ->andFilterWhere(['like', 'trustee_midlename', $this->trustee_midlename])
            ->andFilterWhere(['like', 'trustee_surname', $this->trustee_surname])
            ->andFilterWhere(['like', 'trustee_sex', $this->trustee_sex])
            ->andFilterWhere(['like', 'check_number', $this->check_number])
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'liquidation_letter_number', $this->liquidation_letter_number]);

        return $dataProvider;
    }
}
