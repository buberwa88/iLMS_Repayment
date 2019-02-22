<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\RefundLetterFormat;

/**
 * backend\modules\repayment\models\RefundLetterFormatSearch represents the model behind the search form about `backend\modules\repayment\models\RefundLetterFormat`.
 */
 class RefundLetterFormatSearch extends RefundLetterFormat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refund_letter_format_id', 'created_by', 'updated_by', 'is_active'], 'integer'],
            [['letter_name', 'header', 'footer', 'letter_heading', 'letter_body', 'created_at', 'updated_at'], 'safe'],
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
        $query = RefundLetterFormat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'refund_letter_format_id' => $this->refund_letter_format_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'letter_name', $this->letter_name])
            ->andFilterWhere(['like', 'header', $this->header])
            ->andFilterWhere(['like', 'footer', $this->footer])
            ->andFilterWhere(['like', 'letter_heading', $this->letter_heading])
            ->andFilterWhere(['like', 'letter_body', $this->letter_body]);

        return $dataProvider;
    }
}
