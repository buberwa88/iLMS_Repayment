<?php

namespace frontend\modules\disbursement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\disbursement\models\Instalment;

/**
 * InstalmentSearch represents the model behind the search form about `frontend\modules\disbursement\models\Instalment`.
 */
class InstalmentSearch extends Instalment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instalment_id', 'instalment', 'is_active'], 'integer'],
            [['instalment_desc'], 'safe'],
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
        $query = Instalment::find();

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
            'instalment_id' => $this->instalment_id,
            'instalment' => $this->instalment,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'instalment_desc', $this->instalment_desc]);

        return $dataProvider;
    }
}
