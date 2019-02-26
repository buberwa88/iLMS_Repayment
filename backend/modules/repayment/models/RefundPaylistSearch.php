<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundPaylist;

/**
 * RefundPaylistSearch represents the model behind the search form about `backend\modules\repayment\models\RefundPaylist`.
 */
class RefundPaylistSearch extends RefundPaylist {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['refund_paylist_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['paylist_name', 'paylist_description', 'paylist_number', 'date_created', 'date_updated','current_level','paylist_total_amount'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = RefundPaylist::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->orderBy('refund_paylist_id DESC');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'refund_paylist_id' => $this->refund_paylist_id,
            'date_created' => $this->date_created,
            'created_by' => $this->created_by,
            'date_updated' => $this->date_updated,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'paylist_name', $this->paylist_name])
                ->andFilterWhere(['like', 'paylist_description', $this->paylist_description])
                ->andFilterWhere(['like', 'paylist_number', $this->paylist_number]);

        return $dataProvider;
    }

}
