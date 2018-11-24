<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\ExamStatus;

/**
 * ExamStatusSearch represents the model behind the search form about `backend\modules\allocation\models\ExamStatus`.
 */
class ExamStatusSearch extends ExamStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exam_status_id'], 'integer'],
            [['status_desc'], 'safe'],
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
        $query = ExamStatus::find();

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
            'exam_status_id' => $this->exam_status_id,
        ]);

        $query->andFilterWhere(['like', 'status_desc', $this->status_desc]);

        return $dataProvider;
    }
}
