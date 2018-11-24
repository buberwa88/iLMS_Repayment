<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\QresponseList;

/**
 * QresponseListSearch represents the model behind the search form about `backend\modules\application\models\QresponseList`.
 */
class QresponseListSearch extends QresponseList
{
    public function rules()
    {
        return [
            [['qresponse_list_id', 'is_active'], 'integer'],
            [['response'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = QresponseList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'qresponse_list_id' => $this->qresponse_list_id,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'response', $this->response]);

        return $dataProvider;
    }
}
