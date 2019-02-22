<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\GepgBillProcessingSetting;

/**
 * GepgBillProcessingSettingSearch represents the model behind the search form about `backend\modules\repayment\models\GepgBillProcessingSetting`.
 */
class GepgBillProcessingSettingSearch extends GepgBillProcessingSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gepg_bill_processing_setting_id', 'created_by'], 'integer'],
            [['bill_type', 'bill_processing_uri', 'bill_prefix', 'operation_type', 'created_at'], 'safe'],
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
        $query = GepgBillProcessingSetting::find();

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
            'gepg_bill_processing_setting_id' => $this->gepg_bill_processing_setting_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'bill_type', $this->bill_type])
            ->andFilterWhere(['like', 'bill_processing_uri', $this->bill_processing_uri])
            ->andFilterWhere(['like', 'bill_prefix', $this->bill_prefix])
            ->andFilterWhere(['like', 'operation_type', $this->operation_type]);

        return $dataProvider;
    }
}
