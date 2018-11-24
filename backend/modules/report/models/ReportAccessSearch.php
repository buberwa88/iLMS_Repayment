<?php

namespace backend\modules\report\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\report\models\ReportAccess;

/**
 * ReportAccessSearch represents the model behind the search form about `backend\modules\report\models\ReportAccess`.
 */
class ReportAccessSearch extends ReportAccess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_access_id', 'report_id', 'user_id', 'created_by'], 'integer'],
            [['user_role', 'created_at'], 'safe'],
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
        $query = ReportAccess::find();

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
            'report_access_id' => $this->report_access_id,
            'report_id' => $this->report_id,
            'user_id' => $this->user_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'user_role', $this->user_role]);

        return $dataProvider;
    }
}
