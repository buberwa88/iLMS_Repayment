<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\Applicant;

/**
 * ApplicantSearch represents the model behind the search form about `frontend\modules\application\models\Applicant`.
 */
class ApplicantSearch extends Applicant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_id', 'user_id', 'loan_repayment_bill_requested'], 'integer'],
            [['NID', 'f4indexno', 'f6indexno', 'mailing_address', 'date_of_birth', 'place_of_birth'], 'safe'],
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
        $query = Applicant::find();

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
            'applicant_id' => $this->applicant_id,
            'user_id' => $this->user_id,
            'date_of_birth' => $this->date_of_birth,
            'loan_repayment_bill_requested' => $this->loan_repayment_bill_requested,
        ]);

        $query->andFilterWhere(['like', 'NID', $this->NID])
            ->andFilterWhere(['like', 'f4indexno', $this->f4indexno])
            ->andFilterWhere(['like', 'f6indexno', $this->f6indexno])
            ->andFilterWhere(['like', 'mailing_address', $this->mailing_address])
            ->andFilterWhere(['like', 'place_of_birth', $this->place_of_birth]);

        return $dataProvider;
    }
}
