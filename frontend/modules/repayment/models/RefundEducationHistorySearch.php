<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\RefundEducationHistory;

/**
 * RefundEducationHistorySearch represents the model behind the search form about `frontend\modules\repayment\models\RefundEducationHistory`.
 */
class RefundEducationHistorySearch extends RefundEducationHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_education_history_id', 'refund_application_id', 'program_id', 'institution_id', 'entry_year', 'completion_year', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = RefundEducationHistory::find();

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
            'refund_education_history_id' => $this->refund_education_history_id,
            'refund_application_id' => $this->refund_application_id,
            'program_id' => $this->program_id,
            'institution_id' => $this->institution_id,
            'entry_year' => $this->entry_year,
            'completion_year' => $this->completion_year,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
        ]);

        return $dataProvider;
    }
}
