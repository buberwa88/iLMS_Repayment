<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\NatureOfWork;

/**
 * NatureOfWorkSearch represents the model behind the search form about `backend\modules\repayment\models\NatureOfWork`.
 */
class NatureOfWorkSearch extends NatureOfWork
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nature_of_work_id'], 'integer'],
            [['description'], 'safe'],
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
        $query = NatureOfWork::find();

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
            'nature_of_work_id' => $this->nature_of_work_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
