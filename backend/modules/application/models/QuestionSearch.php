<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\Question;

/**
 * QuestionSearch represents the model behind the search form about `backend\modules\application\models\Question`.
 */
class QuestionSearch extends Question
{
    public function rules()
    {
        return [
            [['question_id', 'response_data_length', 'qresponse_source_id', 'require_verification', 'is_active'], 'integer'],
            [['question', 'response_control', 'response_data_type', 'hint', 'verification_prompt'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Question::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'question_id' => $this->question_id,
            'response_data_length' => $this->response_data_length,
            'qresponse_source_id' => $this->qresponse_source_id,
            'require_verification' => $this->require_verification,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'response_control', $this->response_control])
            ->andFilterWhere(['like', 'response_data_type', $this->response_data_type])
            ->andFilterWhere(['like', 'hint', $this->hint])
            ->andFilterWhere(['like', 'verification_prompt', $this->verification_prompt]);

        return $dataProvider;
    }
}
