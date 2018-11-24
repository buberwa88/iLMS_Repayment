<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\DisbursementDependent;

/**
 * DisbursementDependentSearch represents the model behind the search form about `backend\modules\disbursement\models\DisbursementDependent`.
 */
class DisbursementDependentSearch extends DisbursementDependent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_setting2_id', 'academic_year_id', 'instalment_definition_id', 'loan_item_id', 'associated_loan_item_id'], 'integer'],
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
        $query = DisbursementDependent::find();

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
            'disbursement_setting2_id' => $this->disbursement_setting2_id,
            'academic_year_id' => $this->academic_year_id,
            'instalment_definition_id' => $this->instalment_definition_id,
            'loan_item_id' => $this->loan_item_id,
            'associated_loan_item_id' => $this->associated_loan_item_id,
        ]);

        return $dataProvider;
    }
}
