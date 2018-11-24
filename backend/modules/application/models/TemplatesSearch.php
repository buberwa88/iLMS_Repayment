<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\Templates;

/**
 * TemplatesSearch represents the model behind the search form about `backend\modules\application\models\Templates`.
 */
class TemplatesSearch extends Templates
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'template_status'], 'integer'],
            [['template_name', 'template_content'], 'safe'],
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
        $query = Templates::find();

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
            'template_id' => $this->template_id,
            'template_status' => $this->template_status,
        ]);

        $query->andFilterWhere(['like', 'template_name', $this->template_name])
            ->andFilterWhere(['like', 'template_content', $this->template_content]);

        return $dataProvider;
    }
}
