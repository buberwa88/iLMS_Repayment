<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\PayMethod;

/**
 * PayMethodSearch represents the model behind the search form about `backend\modules\repayment\models\PayMethod`.
 */
class PayMethodSearch extends PayMethod
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_method_id'], 'integer'],
            [['method_desc'], 'safe'],
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
        $query = PayMethod::find();

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
            'pay_method_id' => $this->pay_method_id,
        ]);

        $query->andFilterWhere(['like', 'method_desc', $this->method_desc]);

        return $dataProvider;
    }
}
