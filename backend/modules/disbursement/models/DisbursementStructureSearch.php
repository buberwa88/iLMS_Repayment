<?php

namespace backend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\disbursement\models\DisbursementStructure;

/**
 * DisbursementStructureSearch represents the model behind the search form about `backend\modules\disbursement\models\DisbursementStructure`.
 */
class DisbursementStructureSearch extends DisbursementStructure
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disbursement_structure_id', 'parent_id', 'order_level', 'status'], 'integer'],
            [['structure_name'], 'safe'],
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
        $query = DisbursementStructure::find();

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
            'disbursement_structure_id' => $this->disbursement_structure_id,
            'parent_id' => $this->parent_id,
            'order_level' => $this->order_level,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'structure_name', $this->structure_name]);

        return $dataProvider;
    }
}
