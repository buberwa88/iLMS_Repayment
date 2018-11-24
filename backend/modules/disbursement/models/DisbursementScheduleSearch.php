<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\DisbursementSchedule;

/**
 * DisbursementScheduleSearch represents the model behind the search form about `backend\modules\disbursement\models\DisbursementSchedule`.
 */
class DisbursementScheduleSearch extends DisbursementSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_schedule_id', 'created_by', 'updated_by'], 'integer'],
            [['operator_name', 'created_at', 'updated_at'], 'safe'],
            [['from_amount', 'to_amount'], 'number'],
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
        $query = DisbursementSchedule::find();

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
            'disbursement_schedule_id' => $this->disbursement_schedule_id,
            'from_amount' => $this->from_amount,
            'to_amount' => $this->to_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'operator_name', $this->operator_name]);

        return $dataProvider;
    }
}
