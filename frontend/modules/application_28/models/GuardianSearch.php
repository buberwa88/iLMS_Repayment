<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\Guardian;

/**
 * GuardianSearch represents the model behind the search form about `frontend\modules\application\models\Guardian`.
 */
class GuardianSearch extends Guardian
{
    public function rules()
    {
        return [
            [['gurdian_id', 'application_id', 'occupation_id', 'relationship_type_id'], 'integer'],
            [['firstname', 'middlename', 'surname', 'sex', 'postal_address', 'phone_number', 'physical_address', 'email_address', 'NID', 'passport_photo'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Guardian::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gurdian_id' => $this->gurdian_id,
            'application_id' => $this->application_id,
            'occupation_id' => $this->occupation_id,
            'relationship_type_id' => $this->relationship_type_id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'postal_address', $this->postal_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'NID', $this->NID])
            ->andFilterWhere(['like', 'passport_photo', $this->passport_photo]);

        return $dataProvider;
    }
}
