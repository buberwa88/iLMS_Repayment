<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\CriteriaQuestion;

/**
 * CriteriaQuestionSearch represents the model behind the search form about `backend\modules\allocation\models\CriteriaQuestion`.
 */
class CriteriaQuestionSearch extends CriteriaQuestion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criteria_question_id', 'criteria_id','applicant_category_id','parent_id', 'question_id', 'academic_year_id', 'type'], 'integer'],
            [['operator'], 'safe'],
            [['weight_points', 'priority_points'], 'number'],
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
    public function search($params,$id)
    {
        $query = CriteriaQuestion::find()->where(['criteria_id'=>$id]);

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
            'criteria_question_id' => $this->criteria_question_id,
            'criteria_id' => $this->criteria_id,
            'question_id' => $this->question_id,
            'academic_year_id' => $this->academic_year_id,
            'type' => $this->type,
            'weight_points' => $this->weight_points,
            'priority_points' => $this->priority_points,
        ]);

        $query->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
