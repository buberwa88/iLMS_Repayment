<?php

namespace backend\modules\report\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\report\models\PopularReport;

/**
 * PopularReportSearch represents the model behind the search form about `backend\modules\report\models\PopularReport`.
 */
class PopularReportSearch extends PopularReport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'rate'], 'integer'],
            [['set_date','report_id','package'], 'safe'],
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
        $query = PopularReport::find();

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
        $query->joinWith("report");
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            //'report_id' => $this->report_id,
            'rate' => $this->rate,
            'set_date' => $this->set_date,
        ]);
         $query->andFilterWhere(['like', 'report.name', $this->report_id])
        ->andFilterWhere(['like', 'report.package', $this->package]);

        return $dataProvider;
    }
}
