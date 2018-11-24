<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\LoanBeneficiary;

/**
 * LoanBeneficiarySearch represents the model behind the search form about `frontend\modules\repayment\models\LoanBeneficiary`.
 */
class LoanBeneficiarySearch extends LoanBeneficiary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['loan_beneficiary_id', 'place_of_birth', 'learning_institution_id'], 'integer'],
            [['firstname', 'middlename', 'surname', 'f4indexno', 'NID', 'date_of_birth', 'postal_address', 'physical_address', 'phone_number', 'email_address', 'password'], 'safe'],
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
        $query = LoanBeneficiary::find();

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
            'loan_beneficiary_id' => $this->loan_beneficiary_id,
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'learning_institution_id' => $this->learning_institution_id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'NID', $this->NID])
            ->andFilterWhere(['like', 'postal_address', $this->postal_address])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
