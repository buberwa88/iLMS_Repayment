<?php

namespace backend\modules\report\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\report\models\ReportFilterSetting;

/**
 * ReportFilterSettingSearch represents the model behind the search form about `backend\modules\report\models\ReportFilterSetting`.
 */
class ReportFilterSettingSearch extends ReportFilterSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_filter_setting_id', 'number_of_rows', 'is_active', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = ReportFilterSetting::find();

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
            'report_filter_setting_id' => $this->report_filter_setting_id,
            'number_of_rows' => $this->number_of_rows,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
