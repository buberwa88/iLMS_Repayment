<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\LearningInstitution;

/**
 * LearningInstitutionSearch represents the model behind the search form about `backend\modules\allocation\models\LearningInstitution`.
 */
class LearningInstitutionSearch extends LearningInstitution
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['learning_institution_id', 'ward_id', 'bank_id', 'entered_by_applicant', 'created_by'], 'integer'],
            [['institution_type', 'institution_code', 'institution_name', 'bank_account_number', 'bank_account_name', 'bank_branch_name', 'created_at', 'cp_firstname', 'cp_middlename', 'cp_surname', 'cp_email_address', 'cp_phone_number','parent_id'], 'safe'],
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
        $query = LearningInstitution::find();

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
            'ward_id' => $this->ward_id,
            'bank_id' => $this->bank_id,
            'parent_id'=>$this->parent_id,
            'entered_by_applicant' => $this->entered_by_applicant,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'institution_type', $this->institution_type])
            ->andFilterWhere(['like', 'institution_code', $this->institution_code])
            ->andFilterWhere(['like', 'institution_name', $this->institution_name])
    
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'cp_firstname', $this->cp_firstname])
            ->andFilterWhere(['like', 'cp_middlename', $this->cp_middlename])
            ->andFilterWhere(['like', 'cp_surname', $this->cp_surname])
            ->andFilterWhere(['like', 'cp_email_address', $this->cp_email_address])
            ->andFilterWhere(['like', 'cp_phone_number', $this->cp_phone_number]);

        return $dataProvider;
    }
	public function searchEmployerView($params)
    {
        $query = LearningInstitution::find()->where(['institution_type'=>['UNIVERSITY','COLLEGE']]);

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
            'ward_id' => $this->ward_id,
            'bank_id' => $this->bank_id,
            'parent_id'=>$this->parent_id,
            'entered_by_applicant' => $this->entered_by_applicant,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'institution_type', $this->institution_type])
            ->andFilterWhere(['like', 'institution_code', $this->institution_code])
            ->andFilterWhere(['like', 'institution_name', $this->institution_name])
    
            ->andFilterWhere(['like', 'bank_account_number', $this->bank_account_number])
            ->andFilterWhere(['like', 'bank_account_name', $this->bank_account_name])
            ->andFilterWhere(['like', 'bank_branch_name', $this->bank_branch_name])
            ->andFilterWhere(['like', 'cp_firstname', $this->cp_firstname])
            ->andFilterWhere(['like', 'cp_middlename', $this->cp_middlename])
            ->andFilterWhere(['like', 'cp_surname', $this->cp_surname])
            ->andFilterWhere(['like', 'cp_email_address', $this->cp_email_address])
            ->andFilterWhere(['like', 'cp_phone_number', $this->cp_phone_number]);

        return $dataProvider;
    }
}
