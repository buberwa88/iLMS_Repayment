<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\LearningInstitutionFee;

/**
 * LearningInstitutionFeeSearch represents the model behind the search form about `backend\modules\allocation\models\LearningInstitutionFee`.
 */
class LearningInstitutionFeeSearch extends LearningInstitutionFee {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['learning_institution_fee_id', 'academic_year_id', 'created_by', 'updated_by'], 'integer'],
            [['study_level', 'fee_amount'], 'number'],
            [['created_at', 'updated_at', 'learning_institution_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = LearningInstitutionFee::find();

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
        $query->joinWith('learningInstitution');
        // grid filtering conditions
        $query->andFilterWhere([
            'learning_institution_fee_id' => $this->learning_institution_fee_id,
            'learning_institution.institution_name' => $this->learning_institution_id,
            'academic_year_id' => $this->academic_year_id,
            'study_level' => $this->study_level,
            'fee_amount' => $this->fee_amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }

    /*
     * search from the list of institutions those which are not higher learning istitutions
     * the list will include seacondary & primary schools 
     */

    public function searchNonHigherLearningInstitution($params) {
        $query = LearningInstitutionFee::find();

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
        $query->joinWith('learningInstitution');
        $query->andFilterWhere(['NOT IN', 'institution_type', [LearningInstitution::INSTITUTION_TYPE_UNIVERSITY,LearningInstitution::INSTITUTION_TYPE_NON_UNIVERSITY]
        ]);
      /*  $query->andFilterWhere(['IN', 'institution_type', [LearningInstitution::INSTITUTION_TYPE_OLEVELSECONDARY,LearningInstitution::INSTITUTION_TYPE_ALEVELSECONDARY, LearningInstitution::INSTITUTION_TYPE_PRIMARY]
        ]);*/
        // grid filtering conditions
        $query->andFilterWhere([
            'learning_institution_fee_id' => $this->learning_institution_fee_id,
            'learning_institution.institution_name' => $this->learning_institution_id,
            'academic_year_id' => $this->academic_year_id,
            'study_level' => $this->study_level,
            'fee_amount' => $this->fee_amount,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }

}
