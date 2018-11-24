<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\QpossibleResponse;

/**
 * QpossibleResponseSearch represents the model behind the search form about `backend\modules\application\models\QpossibleResponse`.
 */
class QpossibleResponseSearch extends QpossibleResponse
{
    public function rules()
    {
        return [
            [['qpossible_response_id', 'question_id', 'qresponse_list_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $condition = "1=1")
    {
        $query = QpossibleResponse::find();
        $query->andWhere($condition);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'qpossible_response_id' => $this->qpossible_response_id,
            'question_id' => $this->question_id,
            'qresponse_list_id' => $this->qresponse_list_id,
           
        ]);

        return $dataProvider;
    }
}
