<?php

namespace backend\modules\repayment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\repayment\models\EmployerType;

/**
 * EmployerTypeSearch represents the model behind the search form about `backend\modules\repayment\models\EmployerType`.
 */
class EmployerTypeSearch extends EmployerType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employer_type_id', 'is_active','has_TIN'], 'integer'],
            [['employer_type', 'created_at'], 'safe'],
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
        $query = EmployerType::find();

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
            'employer_type_id' => $this->employer_type_id,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
			'has_TIN'=> $this->has_TIN,
        ]);

        $query->andFilterWhere(['like', 'employer_type', $this->employer_type]);

        return $dataProvider;
    }
}
