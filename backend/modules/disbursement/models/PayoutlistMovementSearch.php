<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\PayoutlistMovement;

/**
 * PayoutlistMovementSearch represents the model behind the search form about `backend\modules\disbursement\models\PayoutlistMovement`.
 */
class PayoutlistMovementSearch extends PayoutlistMovement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movement_id', 'disbursements_batch_id', 'from_officer', 'to_officer', 'movement_status'], 'integer'],
            [['date_out',], 'safe'],
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
        $query = PayoutlistMovement::find();

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
            'movement_id' => $this->movement_id,
            
            'from_officer' => $this->from_officer,
            'to_officer' => $this->to_officer,
            'movement_status' => $this->movement_status,
            'date_out' => $this->date_out,
        ]);

        return $dataProvider;
    }
    public function searchmovement($params,$id)
    {
        $query = PayoutlistMovement::find()->where(["disbursements_batch_id"=>$id]);

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
            'movement_id' => $this->movement_id,
            'disbursements_batch_id' => $this->disbursements_batch_id,
            'from_officer' => $this->from_officer,
            'to_officer' => $this->to_officer,
            'movement_status' => $this->movement_status,
        
            'date_out' => $this->date_out,
        ]);

        return $dataProvider;
    }
}
