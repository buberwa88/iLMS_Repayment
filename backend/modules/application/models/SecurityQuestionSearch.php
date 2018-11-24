<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\SecurityQuestion;

/**
 * SecurityQuestionSearch represents the model behind the search form about `backend\modules\application\models\SecurityQuestion`.
 */
class SecurityQuestionSearch extends SecurityQuestion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['security_question_id'], 'integer'],
            [['security_question'], 'safe'],
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
        $query = SecurityQuestion::find();

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
            'security_question_id' => $this->security_question_id,
        ]);

        $query->andFilterWhere(['like', 'security_question', $this->security_question]);

        return $dataProvider;
    }
}
