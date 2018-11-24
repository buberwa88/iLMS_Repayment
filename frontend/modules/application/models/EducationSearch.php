<?php

namespace frontend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\application\models\Education;

/**
 * EducationSearch represents the model behind the search form about `frontend\modules\application\models\Education`.
 */
class EducationSearch extends Education
{
    public function rules()
    {
        return [
            [['education_id', 'application_id', 'learning_institution_id', 'entry_year', 'completion_year', 'division', 'is_necta', 'under_sponsorship', 'alevel_index'], 'integer'],
            [['level', 'registration_number', 'programme_name', 'programme_code', 'class_or_grade', 'avn_number', 'sponsor_proof_document', 'olevel_index', 'institution_name'], 'safe'],
            [['points', 'gpa_or_average'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Education::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'education_id' => $this->education_id,
            'application_id' => $this->application_id,
            'learning_institution_id' => $this->learning_institution_id,
            'entry_year' => $this->entry_year,
            'completion_year' => $this->completion_year,
            'division' => $this->division,
            'points' => $this->points,
            'is_necta' => $this->is_necta,
            'gpa_or_average' => $this->gpa_or_average,
            'under_sponsorship' => $this->under_sponsorship,
            'alevel_index' => $this->alevel_index,
        ]);

        $query->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'registration_number', $this->registration_number])
            ->andFilterWhere(['like', 'programme_name', $this->programme_name])
            ->andFilterWhere(['like', 'programme_code', $this->programme_code])
            ->andFilterWhere(['like', 'class_or_grade', $this->class_or_grade])
            ->andFilterWhere(['like', 'avn_number', $this->avn_number])
            ->andFilterWhere(['like', 'sponsor_proof_document', $this->sponsor_proof_document])
            ->andFilterWhere(['like', 'olevel_index', $this->olevel_index])
            ->andFilterWhere(['like', 'institution_name', $this->institution_name]);

        return $dataProvider;
    }
	
	public function searchHelpDesk($params,$application_id)
    {
        $query = Education::find()->where(['application_id'=>$application_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'education_id' => $this->education_id,
            'application_id' => $this->application_id,
            'learning_institution_id' => $this->learning_institution_id,
            'entry_year' => $this->entry_year,
            'completion_year' => $this->completion_year,
            'division' => $this->division,
            'points' => $this->points,
            'is_necta' => $this->is_necta,
            'gpa_or_average' => $this->gpa_or_average,
            'under_sponsorship' => $this->under_sponsorship,
            'alevel_index' => $this->alevel_index,
        ]);

        $query->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'registration_number', $this->registration_number])
            ->andFilterWhere(['like', 'programme_name', $this->programme_name])
            ->andFilterWhere(['like', 'programme_code', $this->programme_code])
            ->andFilterWhere(['like', 'class_or_grade', $this->class_or_grade])
            ->andFilterWhere(['like', 'avn_number', $this->avn_number])
            ->andFilterWhere(['like', 'sponsor_proof_document', $this->sponsor_proof_document])
            ->andFilterWhere(['like', 'olevel_index', $this->olevel_index])
            ->andFilterWhere(['like', 'institution_name', $this->institution_name]);

        return $dataProvider;
    }
}
