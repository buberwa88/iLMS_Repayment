<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\ApplicationCycleStatus;

/**
 * ApplicationCycleStatusSearch represents the model behind the search form about `backend\modules\application\models\ApplicationCycleStatus`.
 */
class ApplicationCycleStatusSearch extends ApplicationCycleStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_cycle_status_id'], 'integer'],
            [['application_cycle_status_name', 'application_cycle_status_description'], 'safe'],
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
        $query = ApplicationCycleStatus::find();

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
            'application_cycle_status_id' => $this->application_cycle_status_id,
        ]);

        $query->andFilterWhere(['like', 'application_cycle_status_name', $this->application_cycle_status_name])
            ->andFilterWhere(['like', 'application_cycle_status_description', $this->application_cycle_status_description]);

        return $dataProvider;
    }
}
