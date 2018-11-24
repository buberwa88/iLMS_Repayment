<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\QtriggerMain;

/**
 * QtriggerMainSearch represents the model behind the search form about `backend\modules\application\models\QtriggerMain`.
 */
class QtriggerMainSearch extends QtriggerMain
{
    public function rules()
    {
        return [
            [['qtrigger_main_id'], 'integer'],
            [['description', 'join_operator'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = QtriggerMain::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'qtrigger_main_id' => $this->qtrigger_main_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'join_operator', $this->join_operator]);

        return $dataProvider;
    }
}
