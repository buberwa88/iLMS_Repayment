<?php

namespace backend\modules\allocation\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\allocation\models\AdmissionBatch;

/**
 * AdmissionBatchSearch represents the model behind the search form about `backend\modules\allocation\models\AdmissionBatch`.
 */
class AdmissionBatchSearch extends AdmissionBatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admission_batch_id', 'academic_year_id', 'created_by'], 'integer'],
            [['batch_number', 'batch_desc', 'created_at'], 'safe'],
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
        $query = AdmissionBatch::find();

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
            'admission_batch_id' => $this->admission_batch_id,
            'academic_year_id' => $this->academic_year_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'batch_number', $this->batch_number])
              ->andFilterWhere(['like', 'batch_desc', $this->batch_desc]);

        return $dataProvider;
    }
}
