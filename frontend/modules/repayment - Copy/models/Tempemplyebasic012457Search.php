<?php

namespace frontend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\repayment\models\Tempemplyebasic012457;

/**
 * Tempemplyebasic012457Search represents the model behind the search form about `frontend\modules\repayment\models\Tempemplyebasic012457`.
 */
class Tempemplyebasic012457Search extends Tempemplyebasic012457
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'loan_repayment_id', 'applicant_id'], 'integer'],
            [['old_amount', 'new_amount'], 'safe'],
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
        $query = Tempemplyebasic012457::find();

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
            'id' => $this->id,
            'loan_repayment_id' => $this->loan_repayment_id,
            'applicant_id' => $this->applicant_id,
        ]);

        $query->andFilterWhere(['like', 'old_amount', $this->old_amount])
            ->andFilterWhere(['like', 'new_amount', $this->new_amount]);

        return $dataProvider;
    }
}
