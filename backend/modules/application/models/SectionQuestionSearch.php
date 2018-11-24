<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\SectionQuestion;

/**
 * SectionQuestionSearch represents the model behind the search form about `backend\modules\application\models\SectionQuestion`.
 */
class SectionQuestionSearch extends SectionQuestion
{
    public function rules()
    {
        return [
            [['section_question_id', 'applicant_category_section_id', 'question_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $condition = "1=1")
    {
        $query = SectionQuestion::find();
        $query->andWhere($condition);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'section_question_id' => $this->section_question_id,
            'applicant_category_section_id' => $this->applicant_category_section_id,
            'question_id' => $this->question_id,
            
        ]);

        return $dataProvider;
    }
}
