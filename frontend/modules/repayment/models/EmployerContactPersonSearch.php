<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\EmployerContactPerson;

/**
 * EmployerContactPersonSearch represents the model behind the search form about `frontend\modules\repayment\models\EmployerContactPerson`.
 */
class EmployerContactPersonSearch extends EmployerContactPerson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repayment_employer_contact_person_id', 'employer_id', 'user_id', 'created_by'], 'integer'],
            [['created_at', 'role'], 'safe'],
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
        $query = EmployerContactPerson::find();

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
            'repayment_employer_contact_person_id' => $this->repayment_employer_contact_person_id,
            'employer_id' => $this->employer_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'role', $this->role]);

        return $dataProvider;
    }
}
