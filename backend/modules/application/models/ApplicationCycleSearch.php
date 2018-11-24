<?php

namespace backend\modules\application\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\application\models\ApplicationCycle;

/**
 * ApplicationCycleSearch represents the model behind the search form about `backend\modules\application\models\ApplicationCycle`.
 */
class ApplicationCycleSearch extends ApplicationCycle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_cycle_id', 'application_cycle_status_id', 'academic_year_id'], 'integer'],
            [['application_status_remark', ], 'safe'],
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
        $query = ApplicationCycle::find();

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
            'application_cycle_id' => $this->application_cycle_id,
            'application_cycle_status_id' => $this->application_cycle_status_id,
            'academic_year_id' => $this->academic_year_id,
            'applicant_category' => $this->applicant_category,
        ]);
         $query->andFilterWhere(['like', 'application_status_remark', $this->application_status_remark]);
        return $dataProvider;
    }
}
