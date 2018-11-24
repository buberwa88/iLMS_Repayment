<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\CriteriaQuestionAnswer;

/**
 * CriteriaQuestionAnswerSearch represents the model behind the search form about `backend\modules\allocation\models\CriteriaQuestionAnswer`.
 */
class CriteriaQuestionAnswerSearch extends CriteriaQuestionAnswer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criteria_question_answer_id', 'criteria_question_id', 'qresponse_source_id', 'response_id'], 'integer'],
            [['value'], 'safe'],
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
        $query = CriteriaQuestionAnswer::find();

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
            'criteria_question_answer_id' => $this->criteria_question_answer_id,
            'criteria_question_id' => $this->criteria_question_id,
            'qresponse_source_id' => $this->qresponse_source_id,
            'response_id' => $this->response_id,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
