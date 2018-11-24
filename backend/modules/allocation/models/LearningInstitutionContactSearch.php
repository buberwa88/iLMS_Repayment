<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\LearningInstitutionContact;

/**
 * LearningInstitutionContactSearch represents the model behind the search form about `backend\modules\allocation\models\LearningInstitutionContact`.
 */
class LearningInstitutionContactSearch extends LearningInstitutionContact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['learning_institution_id', 'is_signator', 'updated_by', 'is_active'], 'integer'],
            [['cp_firstname', 'cp_middlename', 'cp_surname', 'cp_email_address', 'cp_phone_number', 'photo', 'category', 'signature', 'updated_at', 'created_at'], 'safe'],
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
        $query = LearningInstitutionContact::find();

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
            'learning_institution_id' => $this->learning_institution_id,
            'is_signator' => $this->is_signator,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'cp_firstname', $this->cp_firstname])
            ->andFilterWhere(['like', 'cp_middlename', $this->cp_middlename])
            ->andFilterWhere(['like', 'cp_surname', $this->cp_surname])
            ->andFilterWhere(['like', 'cp_email_address', $this->cp_email_address])
            ->andFilterWhere(['like', 'cp_phone_number', $this->cp_phone_number])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'signature', $this->signature]);

        return $dataProvider;
    }
}
