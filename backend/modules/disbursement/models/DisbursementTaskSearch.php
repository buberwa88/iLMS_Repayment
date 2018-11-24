<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\DisbursementTask;

/**
 * DisbursementTaskSearch represents the model behind the search form about `backend\modules\disbursement\models\DisbursementTask`.
 */
class DisbursementTaskSearch extends DisbursementTask
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_task_id', 'status'], 'integer'],
            [['task_name'], 'safe'],
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
        $query = DisbursementTask::find();

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
            'disbursement_task_id' => $this->disbursement_task_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'task_name', $this->task_name]);

        return $dataProvider;
    }
}
