<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\ApplicantAssociate;

/**
 * ApplicantAssociateSearch represents the model behind the search form about `frontend\modules\application\models\ApplicantAssociate`.
 */
class ApplicantAssociateSearch extends ApplicantAssociate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['applicant_associate_id', 'application_id', 'occupation_id', 'learning_institution_id', 'ward_id'], 'integer'],
            [['organization_name', 'firstname', 'middlename', 'surname', 'sex', 'postal_address', 'phone_number', 'physical_address', 'email_address', 'NID', 'passport_photo', 'type'], 'safe'],
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
        $query = ApplicantAssociate::find();

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
            'applicant_associate_id' => $this->applicant_associate_id,
            'application_id' => $this->application_id,
            'occupation_id' => $this->occupation_id,
            'learning_institution_id' => $this->learning_institution_id,
            'ward_id' => $this->ward_id,
        ]);

        $query->andFilterWhere(['like', 'organization_name', $this->organization_name])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'postal_address', $this->postal_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'NID', $this->NID])
            ->andFilterWhere(['like', 'passport_photo', $this->passport_photo])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
